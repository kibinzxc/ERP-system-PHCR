<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['uid'])) {
    $loggedIn = true;
    $currentUserId = $_SESSION['uid'];
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ph_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $conn->close();
} else {
header("Location: ../../../login.php");
}


if (isset($_GET['logout'])) {
    if (isset($_SESSION['uid'])) {

        session_destroy();
        unset($_SESSION['uid']);
    }
    header("Location:../../../login.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ph_db";

// Create connection
$db= new mysqli($servername, $username, $password, $dbname);

$queryz = "SELECT COUNT(*) as unread_count FROM msg_users WHERE status = 'unread' AND uid =" . $_SESSION['uid'];
$result41 = $db->query($queryz);

if ($result41) {
    $row41 = $result41->fetch_assoc();
    $unreadNotificationCount = $row41['unread_count'];
} else {
    $unreadNotificationCount = 0; // Default to 0 if query fails
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the details from the cart
    $sqlCart = "SELECT * FROM cart WHERE uid = $currentUserId";
    $resultCart = $db->query($sqlCart);
    $payment = $_POST['flexRadioDefault'];
    $del_instruct = $_POST['del_instruct'];

    if ($resultCart) {
        // Fetch user details
        $sqlUser = "SELECT * FROM customerInfo WHERE uid = $currentUserId";
        $resultUser = $db->query($sqlUser);
        $userDetails = mysqli_fetch_assoc($resultUser);

        // Initialize variables for total price and delivery fee
        $totalPrice = 0;
        $deliveryFee = 50;

        // Initialize an array to store cart items
        $cartItems = array();

        // Iterate through cart items to calculate total price and store item details
        while ($row = mysqli_fetch_assoc($resultCart)) {
            //get the category id from dishes table
            $sqlCategory = "SELECT categoryID FROM dishes WHERE dish_id =" . $row['dish_id'];
            $resultCategory = $db->query($sqlCategory);
            $category = mysqli_fetch_assoc($resultCategory);

            // Check if the categoryID is '1'
            if ($category['categoryID'] == '1') {
                // Append additional text to the size for categoryID '1'
                $size = $row['size'] . "\ Regular Pan Pizza";
            } else {
                // Use the original size if categoryID is not '1'
                $size = $row['size'];
            }

            // Assuming you have columns 'name', 'size', and 'price' in your cart table
            $cartItems[] = array(
                'name' => $row['name'],
                'size' => $size,
                'price' => $row['price'],
                'qty' => $row['qty'],
                'totalPrice' => $row['totalprice'],
            );

            $totalPrice += $row['totalprice'];
        }

        // Add delivery fee to total price
        $totalPrice += $deliveryFee;

        // Convert cart items array to JSON for storage in the database
        $cartItemsJSON = json_encode($cartItems);

        // Insert order details into the 'test' table
        $insertOrderSql = "INSERT INTO `test` (uid, name, address, items, totalPrice, payment, del_instruct, status)
                           VALUES ('$currentUserId', '{$userDetails['name']}', '{$userDetails['address']}', '$cartItemsJSON', '$totalPrice', '$payment', '$del_instruct', 'placed')";
        $db->query($insertOrderSql);
        
        $deleteCartSql = "DELETE FROM cart WHERE uid = $currentUserId";
        $db->query($deleteCartSql);
        $db->close();
        header("Location: order-placed.php");
        echo "Order placed successfully! Total Price: $totalPrice";
    } else {
        // Handle query error for cart
        echo "Error fetching cart: " . $db->error;
    }
} else {


}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/pizzahut-logo.png">
    <title>Orders | Pizza Hut Chino Roces</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/order.css">
    <script src="../../../src/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/search-index.js"></script>
</head>

<body>

    <div class="container-fluid" style="overflow:hidden;">
        <div class="row row-flex">
            <!-- Add the row-flex class -->
            <div class="col-sm-1 custom-width" style="height:100vh;">
                <!-- Add the custom-width class -->
                <div class="sidebar" style="height:100vh;">
                    <a href="../../../index.php" class="item1">
                        <img class="logo" src="../../assets/img/pizzahut-logo.png" alt="Pizza Hut Logo">
                    </a>
                    <a href="menu.php" class="item">
                        <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="order.php" class="item active" id="orderLink">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Orders</span>
                    </a>
                    <a href="messages.php" class="item-last" id="messagesLink">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Messages</span>
                        <?php
                            
                            $unreadNotificationCount = $unreadNotificationCount; 
                            
                            if ($unreadNotificationCount > 0) {
                                echo '<span class="notification-count">' . $unreadNotificationCount . '</span>';
                            }
                        ?>
                    </a>
                    <!-- Toggle Login/Logout link -->
                    <?php if ($loggedIn) : ?>
                    <a href="profile.php" class="item">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                    <a href="order.php?logout=1" class="item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                    <?php else : ?><br><br>
                    <a href="../../../login.php" class="item-login">
                        <i class="fa-solid fa-user"></i>
                        <span>Login</span>
                    </a>
                    <?php endif; ?>

                </div>
            </div>
            <!-- BEGINNING OF BODY -->
            <div class="col-sm-11 wrap" style="padding:15px; height:100vh;">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper">
                            <h2><i class="fa-solid fa-utensils" style="margin-left:5px;"></i> My Orders</h2>
                            <div class="upper-buttons">
                                <a href="" class="btn btn-primary" style="margin-top:10px;"><i
                                        class="fa-solid fa-file-invoice"></i> Order History</a>
                                <a href="menu.php" class="btn btn-primary" style="margin-top:10px;"><i
                                        class="fa-solid fa-bag-shopping"></i> My Bag</a>
                                <a href="messages.php" class="btn btn-primary" style="margin-top:10px;"><i
                                        class="fa-solid fa-bell"></i> Messages</a>
                            </div>
                            <hr>
                            <?php
                            // Assuming you have a database connection established as $db and $currentUserId is defined

                            $sql = "SELECT * FROM test WHERE uid = $currentUserId";
                            $result = $db->query($sql);
                            $results = $db->query($sql);
                            $rowz = $results->fetch_assoc();
                                
                            
                            ?>

                                <div class = "col-sm-12 cart" style = "padding:25px 200px 25px 200px; position:relative; height:80vh; overflow:auto;">
                                    <div class = "card">
                                        <div class = "card-header">
                                            <h4>Order #<?php echo $rowz['orderID']?></h4>
                                        </div>
                                        <div class = "card-body">
                                            <div class = "row">
                                                <div class = "col-sm-6">
                                                    <h5>Order Details</h5>
                                                    <div style = "padding:10px 0 0 30px">
                                                    <p>Order Date: 12/12/2021</p>
                                                    <p>Order Time: 12:00 PM</p>
                                                    <p>Order Status: <span class="badge bg-warning">Preparing</span></p>
                                                    </div>
                                                </div>
                                                <div class = "col-sm-6">
                                                    <h5>Delivery Address</h5>
                                                    <div style = "padding:10px 0 0 30px">
                                                    <p>Address: <?php echo $rowz['address']?></p>
                                                    <p>Delivery Date: 12/12/2021</p>
                                                    <p>Delivery Time: 12:30 PMName</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-sm-12" style="margin-top:30px;">
                                                    <h5>Order Items</h5>
                                                    <table class="table" style="text-align:center;">
                                                        <thead>
                                                            <tr >
                                                                <th>Item Name</th>
                                                                <th>Size</th>
                                                                <th>Price</th>
                                                                <th>Quantity</th>
                                                                <th>Total Price</th>
                                                            </tr>
                                                        </thead>
                                            <?php $totalOrderPrice = 0;
                                    if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Check if the 'items' column is not null
                                        if ($row['items'] !== null) {
                                            $items_data = json_decode($row['items'], true);
                                
                                            // Check if json_decode was successful
                                                foreach ($items_data as $item) {
                                                    $name = $item['name'];
                                                    $size = $item['size'];
                                                    $price = $item['price'];
                                                    $qty = $item['qty'];
                                                    $totalPrice = $item['totalPrice'];
                                                     $totalOrderPrice += $totalPrice;
                                                   echo' <tr>
                                                        <td>' . $name . '</td>
                                                        <td>' . $size . '</td>
                                                        <td>₱ ' . $price . '</td>
                                                        <td>' . $qty . '</td>
                                                        <td>₱ ' . $totalPrice . '</td>
                                                    </tr>';
                                                    
                                                    
                                                }
                                               
                                        } else {
                                            // Handle case where 'items' column is null
                                            echo "'items' column is null";
                                        }
                                            }
                                        } else {
                                            echo "0 results";
                                        }

                                                   $deliveryFee = 50;
                                                    $totalAmount = $totalOrderPrice + $deliveryFee;
                                                    
                                            ?>
                                                        
                                                    </table>
                                                </div>
                                            </div>

                                            <div class = "row">
                                                <div class = "col-sm-12" style="margin-top:20px;">
                                                    <h5>Order Summary</h5>
                                                    <table class="table" style="text-align:left; margin-top:10px;">
                                                        <tbody >
                                                            <tr class="subtotal">
                                                                <td>Subtotal</td>
                                                                <td>₱ <?php echo $totalOrderPrice?></td>
                                                            </tr>
                                                            <tr class = "lasttotal">
                                                                <td>Delivery Fee</td>
                                                                <td>₱
                                                                    <?php echo $deliveryFee?></td>
                                                            </tr>   
                                                            <tr class = "total">
                                                                <td style="color:maroon;">Total</td>
                                                                <td style="color:maroon;">₱
                                                                    <?php echo $totalAmount?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                </div>

                        </div>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ENDING OF BODY -->


</body>

</html>
<?php
session_start();

$g = $_GET['edit_item'];
 // Create connection

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

    // Retrieve the current user's ID from the session
    $currentUserId = $_SESSION['uid'];

    $sql = "SELECT address FROM customerInfo WHERE uid = $currentUserId"; // Replace 'users' with your table name
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userAddress = $row['address']; // Store the user's address in a variable
        $currentUserId = $currentUserId;
    } else {
        $userAddress = "House No, Street, City, Province"; // Set a default value if no address is found
    }
    $userTypeQuery = "SELECT user_type FROM users WHERE uid = $currentUserId";
    $result = $conn->query($userTypeQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userType = $row['user_type'];

        // Check if user_type is "customer"
        if ($userType !== "customer") {
            header("Location: ../../../login.php");
            exit(); // Ensure script stops execution after redirection
        }
    }
    $conn->close();
} else {
header("Location: menu.php");
}


if (isset($_GET['logout'])) {
    if (isset($_SESSION['uid'])) {

        session_destroy();
        unset($_SESSION['uid']);
    }
    header("Location:../../../login.php");
    exit();
}

if (isset($_POST['addtobag'])) {
    $dbz = new mysqli('localhost', 'root', '', 'ph_db');
    $uid = $_SESSION['uid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $size1 = $_POST['size'];
    $size = ''.$size1.'';
    $dish_id = $_POST['dish_id'];
    $quantity = 1;  // default quantity
    // Check if the dish_id already exists in the cart
    $check_sql = "SELECT * FROM cart WHERE dish_id = '$dish_id' AND uid = '$uid'";
    $result = mysqli_query($dbz, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // If the dish_id exists, update the quantity and multiply the price
        $update_sql = "UPDATE cart SET qty = qty + $quantity, totalprice = totalprice + ($quantity * $price) WHERE dish_id = '$dish_id' AND uid = '$uid'";
        mysqli_query($dbz, $update_sql);
    } else {
        // If the dish_id doesn't exist, insert a new row with the multiplied price
        $total_price = $quantity * $price;
        $insert_sql = "INSERT INTO cart (dish_id, uid, name, size, qty, price, img,totalprice) 
                        VALUES ('$dish_id', '$uid', '$name', '$size', '$quantity', '$price', '$img','$total_price')";
        mysqli_query($dbz, $insert_sql);
    }
}

if (isset($_POST["confirmation"])) {
     $conn = new mysqli('localhost', 'root', '', 'ph_db');
    $selectedQty = $_POST["qty"];
    $dish_id = $_GET['edit_item'];
  $updateQuery = "UPDATE cart SET qty = '$selectedQty' WHERE dish_id = '$dish_id'";
 $_SESSION['success']  = "Bag updated successfully";
    header("Location:menu-beverages.php");
    // Execute the update query
    $result = mysqli_query($conn, $updateQuery);

  }



if (isset($_POST['checkout'])) {
    $uid = $_SESSION['uid']; 

    // Connect to the database
    $db = new mysqli('localhost', 'root', '', 'ph_db');

    // Check for a successful connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Get the quantity from the form
    $address = $_POST['address'];

    // Retrieve data from the 'cart' table based on the current user's UID
    $cartQuery = "SELECT * FROM cart WHERE uid = '$uid'";
    $cartResult = $db->query($cartQuery);

    // Check if the retrieval was successful
    if ($cartResult) {
        $name = array();
        
        while ($row = $cartResult->fetch_assoc()) {
            $orderDetails = array($row['size'], $row['name'], $row['qty'], $row['totalprice']);
            $names[] = $orderDetails;
        }
    

        $details = json_encode($names);

        $orderInsertQuery = "INSERT INTO `test` (uid, address, details) VALUES ('$uid', '$address', '$details')";
        $db->query($orderInsertQuery);
        

        header("Location:order.php");
        exit();
    } else {
        echo "Error retrieving data from cart: " . $db->error;
    }

    $db->close();
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


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/pizzahut-logo.png">
    <title>Menu | Pizza Hut Chino Roces</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/menu.css">
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
                    <a href="menu.php" class="item active">
                        <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="order.php" class="item" id="orderLink">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Orders</span>
                    </a>
                     <a href="order-history.php" class="item">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Records</span>
                    </a>
                    <a href="promo.php" class="item-last" id="messagesLink">
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
                    <a href="edit-item3.php?logout=1" class="item">
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
            <div class="col-sm-9" style="background: white;">
                <div class="container">
                    <div class="row">

                        <div class="col-sm-12"
                            style="padding:0; height:100%; overflow:hidden; border-radius:5px!important; margin-top:40px; width:100%;">
                            <img class="banner" src="../../assets/img/ph_banner2.png" alt="Banner"
                                style="width:100%; max-width:100%; min-width:100px; height:auto; overflow:hidden;">
                        </div>
                        <div class="col-sm-12" style="padding:0; margin:0; margin-top:30px;">
                            <div class="container" style="padding:0;">
                                <div class="row" style="padding:0px 15px 0 12px;">

                                    <div class="col-sm-4"
                                        style="text-align:center;">
                                        <a href="menu.php" class="menu-item">
                                            <span>Pizza</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-4" style="text-align:center;">
                                        <a href="menu-pasta.php" class="menu-item">
                                            <span>Pasta</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-4" style="text-align:center; border-bottom:5px solid red; margin-bottom:-20px;padding-bottom:20px;">
                                        <a href="menu-beverages.php" class="menu-item">
                                            <span>Beverages</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin-right:5px;">
                        </div>
                        <div class="col-sm-12 scroll" style="overflow-y: auto; height: 50vh; margin:0; padding:0;">

                            <div class="flex-container">

                                <?php
                $db = new mysqli('localhost', 'root', '', 'ph_db');
                $sql = "SELECT * FROM dishes where categoryID ='3' ORDER BY price asc ";
                $result = $db->query($sql);
                $result1 = $db->query($sql);
                $newrow = mysqli_fetch_array($result1);


                if ($result->num_rows > 0) {
                    $appointment = array();


                    while ($row = $result->fetch_assoc()) {

                        echo '
                <form method="post" action="">
                <div class="flex-item" style="border-radius:5px;">
                    <div class="head-card" style = " width:300px;  border-radius:5px;">
                        <div class="header-img">
                        <img src="../../assets/img/menu/' . $row['img'] . '" alt="notif pic" style="width:100%; max-width:100%; min-width:50px;min-height:50px; height:auto;">
                        </div>
                        <div class="body-card" style="padding:10px 20px 10px 20px; text-align:justify; background:#D9D9D9; height:5vh;">
                            <input type="hidden" id="hiddenField" name="name" value="' . $row['name'] . '">
                            <input type="hidden" id="hiddenField" name="dish_id" value="' . $row['dish_id'] . '">
                            <input type="hidden" id="hiddenField" name="price" value="' . $row['price'] . '">
                            <input type="hidden" id="hiddenField" name="img" value="' . $row['img'] . '">
                            <h5 style="font-weight:700;">' . $row['name'] . '</h5>
                            <p style="font-size:12px; color:black; overflow: hidden; margin-top:10px;">' . $row['slogan'] . '</p>
                    </div>
                        <div class="footer-card" style="padding:10px 20px 10px 20px; text-align:center; background:#D9D9D9;">
                             <select class="size" name="size" style="width:100%; text-align:center;" disabled>';
 // Split the 'size' data into an array
        $sizes = explode(',', $row['size']);

        // Iterate over the 'size' data and create an option for each size
        foreach ($sizes as $size) {
            echo '<option value="' . $size . '">' . ucfirst($size) . '</option>';
        }

        echo '
                            </select>
                        <input type = "hidden" id = "hiddenField" name = "size" value = "' . $row['size'] . '">
                        <input type="submit" class="addtobag" id="confirmation" value="Add to Bag - ₱' . $row['price'] . '" name="addtobag">
                            
                </div>  
                </div>
                </div>
</form>
                ';
                    }
                } else {

                    echo '<p style="text-align:center; margin-top:50px;">No Pizza Available Yet</p> ';
                }
                ?>


                                <!-- Add more items as needed -->
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- ENDING OF BODY -->

            <!-- BEGINNING OF My Bag-->
            <div class="col-sm-2" style="background-color: #efefef;">
                <!-- Add the fill-remaining class -->
                <div class="container" style="margin:0;padding:0;">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 style="margin-top:35px;margin-left:10px; color:#404040;">My Bag</h3><br><br>
                        </div>

                        <?php if ($currentUserId !== '1001'): ?>
                        <form method="post" action="">
                            <div class="col-sm-12">
                                <button id="counterBtn" style="font-weight:550; cursor:auto;" class="active"
                                    disabled>Delivery Address</button>
                            </div>
                            <div id="deliveryContent" style="display: block;">

                                <div class="col-sm-12">
                                    <input style="font-weight:bold; color:#333; margin-left:10px;" type="text"
                                        name="address" value="<?php echo $userAddress; ?>"
                                        <?php if (!$loggedIn) echo 'disabled'; else echo 'readonly'; ?>><br><br>
                                </div>
                                <div class="col-sm-12 cart"
                                    style="margin:0 0 -25px 0; padding:0; height:45vh; overflow-y: scroll; overflow:auto; ">

                                    <?php
                                        $db = new mysqli('localhost', 'root', '', 'ph_db');
                                        if ($loggedIn) {
                                            $sql = "SELECT * FROM cart WHERE uid = $currentUserId";
                                            $result = $db->query($sql);
                                            $result1 = $db->query($sql);
                                            $newrow = mysqli_fetch_array($result1);
                                            if ($result->num_rows > 0) {
                                                $cart = array();
                                                // Display events
                                                while ($row = $result->fetch_assoc()) {
                                                    $cart[] = $row;
                                                }
                                                $cart = array_reverse($cart);
                                                foreach ($cart as $row) {
                                                    echo '
                                            <div class = "box" style = "padding: 10px;border-radius:10px; margin: 10px 10px 10px 5px; position:relative; margin-left:10px;">
                                                <div class = "container" style="margin:0; padding:0;">
                                                    <div class ="row">
                                                        <div class = "col-sm-3">
                                                            <div class = "image" style="height:100%; width:100%">
                                                                <img src="../../../src/assets/img/menu/' . $row['img'] . '" alt="notif pic" style="width:100%; max-width:100%; min-width:100px; height:auto; overflow:hidden; border-radius:10px;">
                                                            </div>
                                                        </div>
                                                        <div class = "col-sm-6">
                                                            <div class = "caption">
                                                                <p>' . $row['size'] . ' ' . $row['name'] . '</p>
                                                            </div>
                                                            <div class="edit-btn">
                                                            <a  href="#" class="edit-btn"><i class="fa-solid fa-pencil"  style="font-size:20px;"></i></a> 
                                                            </div>
                                                            <div class="remove-btn">
                                                                <a  href="remove_item.php?remove_item='.$row['dish_id'].'" class="remove-btn"><i class="fa-solid fa-xmark" style="font-size:25px;"></i></a> 
                                                            </div>    
                                                        </div>
                                                        <div class = "col-sm-2 bottom-footer">
                                                            <div class = "price">
                                                                <p><span class="price-display" data-id="' . $row['cart_id'] . '">₱' . $row['price'] . '</span></p>
                                                                <input type="hidden" class="price" name="price" data-id="' . $row['cart_id'] . '" value="' . $row['price'] . '">
                                                            
                                                            <div class = "quantity1">
                                                             <div class="edit-btn">
                                                            <a  href="#" class="edit-btn"><i class="fa-solid fa-pencil"  style="font-size:20px;"></i></a> 
                                                            </div>
                                                            <select class="quantity" name="quantity" data-id="' . $row['cart_id'] . '" disabled>';
                                                 $sizes = explode(',', $row['qty']);

        // Iterate over the 'size' data and create an option for each size
        foreach ($sizes as $size) {
            echo '<option value="' . $size . '">' . ucfirst($size) . '</option>';
        }
                                                    echo '</select>
                                                    
                                                            </div>
                                                        </div>
                                                       </div>
                                                    </div>
                                                </div>

                                            </div>
                                            ';
                                                }
                                            } else {

                                                echo '<p style="text-align:center; margin-top:50px;">Add Items to your Bag</p> ';
                                            }
                                        } else {
                                            echo '<p style="text-align:center; margin-top:50px;">Please Login to Continue</p> ';
                                        }
                                        ?>

                                </div>
                                <div class="col-sm-12" style="margin: 30px 0 0 0;">
                                    <?php  $sql = "SELECT * FROM cart WHERE dish_id = '{$_GET['edit_item']}'";
                                            $result = $db->query($sql);
                                            $newrow = mysqli_fetch_array($result);
                                    ?>
                                    <div class="mpopup1" id="mpopup1">
                                        <div class="modal-content1">
                                            <div class="modal-header1">
                                                <h4 style="text-align:center; font-size:2rem;"><?php echo $newrow['name']; ?></h4>
                                            </div>
                                            <div class="modal-body1">
                                                <form method="POST" action="">
                                                    <label for="numberSelect">Select Quantity:</label>
                                                    <select id="numberSelect" id="numberSelect" name="qty"
                                                        style="width: 50px; text-align:center;">
                                                        <script>
                                                        // Get the select element
                                                        var selectElement = document.getElementById("numberSelect");

                                                        // Get the current quantity value from PHP (assuming it's echoed into JavaScript)
                                                        var currentQuantity =
                                                        <?php echo json_encode($newrow['qty']); ?>;

                                                        // Loop to generate options
                                                        for (var i = 1; i <= 10; i++) {
                                                            // Create an option element
                                                            var option = document.createElement("option");
                                                            option.value = i;
                                                            option.text = i;

                                                            // Set the selected attribute if it matches the current quantity
                                                            if (i == currentQuantity) {
                                                                option.selected = true;
                                                            }

                                                            // Append the option to the select element
                                                            selectElement.appendChild(option);
                                                        }
                                                        </script>
                                                    </select>

                                            </div>
                                            <div class="modal-footer1">


                                                <input type="submit" class="confirmation" id="confirmation"
                                                    value="Confirm" name="confirmation">
                                                <input type="button" class="cancellation" value="Cancel"
                                                    name="cancel_btn" onclick="closeModal()">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        </form>
                        <script>
                        function closeModal() {
                            window.location.href = 'menu-beverages.php'

                        }
                        </script>
                        <div class="linebreak" style="margin:0 15px 0 5px;">
                            <hr style="height:2px;">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6" style="padding:0; margin:0;">
                                    <p style="font-weight:550">Sub Total</p>
                                    <p style="font-weight:550">Delivery Fee</p>
                                </div>
                                <div class="col-sm-6" style="padding:0; margin:0;">
                                    <p id="subtotal" style="margin-left: 30px; font-weight:bold;"></p>
                                    <p id="delivery_fee" style="margin-left:30px; font-weight:bold;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="linebreak" style="margin:0 15px 0 5px;">
                            <hr style="height:2px;">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6" style="padding:0; margin:0;">
                                    <p style="font-weight:550">Total</p>
                                </div>
                                <div class="col-sm-6" style="padding:0; margin:0;">
                                    <p id="total_amount" style="margin-left:30px; font-weight:bold;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" style="padding:0 32px 0 32px; margin-top:20px;">
                        <input type="submit" value="Checkout" class="checkout" name="checkout" <?php if (!$loggedIn)
                                            echo 'disabled'; ?>>
                        </form>
                    </div>
                </div>

                <?php else: ?>
                <div class="col-sm-12">
                    <button id="deliveryBtn" class="active" style="font-weight:550; cursor:auto;" disabled>Over the
                        Counter</button>
                </div>
                <div id="counterContent" style="display: block;">
                    <form method="post">
                        <div class="col-sm-12"><br>
                        </div>
                        <div class="col-sm-12 cart"
                            style="margin:0 0 -25px 0; padding:0; height:61.8vh; overflow-y: scroll; overflow:auto; ">

                            <?php
                                        $db = new mysqli('localhost', 'root', '', 'ph_db');
                                        if ($loggedIn) {
                                            $sql3 = "SELECT * FROM cart WHERE uid = $currentUserId";
                                            $result3 = $db->query($sql3);
                                            $newrow3 = mysqli_fetch_array($result);
                                            if ($result3->num_rows > 0) {
                                                $cart3 = array();
                                                // Display events
                                                while ($row3 = $result3->fetch_assoc()) {
                                                    $cart3[] = $row3;
                                                }
                                                $cart3 = array_reverse($cart3);
                                                foreach ($cart3 as $row3) {
                                                    echo '
                                            <div class = "box" style = "padding: 10px;border-radius:10px; margin: 10px 10px 10px 5px; position:relative; margin-left:10px;">
                                                <div class = "container" style="margin:0; padding:0;">
                                                    <div class ="row">
                                                        <div class = "col-sm-3">
                                                            <div class = "image" style="height:100%; width:100%">
                                                                <img src="../../../src/assets/img/menu/' . $row3['img'] . '" alt="notif pic" style="width:100%; max-width:100%; min-width:100px; height:auto; overflow:hidden; border-radius:10px;">
                                                            </div>
                                                        </div>
                                                        <div class = "col-sm-6">
                                                            <div class = "caption">
                                                                <p>' . $row3['namesize'] . '</p>
                                                            </div>
                                                            <div class="remove-btn">
                                                                <a  href="#" class="remove-btn"><i class="fa-solid fa-xmark" style="font-size:25px;"></i></a> 
                                                            </div>    
                                                        </div>
                                                        <div class = "col-sm-2">
                                                            <div class = "price">
                                                                <p><span class="price-display" data-id="' . $row3['cart_id'] . '">₱' . $row3['price'] . '</span></p>
                                                                <input type="hidden" class="price" name="price" data-id="' . $row3['cart_id'] . '" value="' . $row3['price'] . '">
                                                            <div class = "quantity1">
                                                            <select class="quantity" name="quantity" data-id="' . $row3['cart_id'] . '">';
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }
                                                    echo '</select>

                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>';
                                                }
                                            } else {

                                                echo '<p style="text-align:center; margin-top:100px;">Add items to your bag</p> ';
                                            }
                                        } else {
                                            echo '<p style="text-align:center; margin-top:100px;">Please Login to Continue</p> ';
                                        }

                                        ?>

                        </div>
                        <div class="col-sm-12" style="margin: 30px 0 0 0;">
                            <div class="linebreak" style="margin:0 15px 0 5px;">
                                <hr style="height:2px;">
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6" style="padding:0; margin:0;">
                                        <p style="font-weight:550">Total</p>
                                    </div>
                                    <div class="col-sm-6" style="padding:0; margin:0;">
                                        <p id="total_amount1" style="margin-left:30px; font-weight:bold;">₱ 0
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding:0 20px 0 20px; margin-top:20px;">
                            <input type="submit" value="Checkout" class="checkout" name="checkout">
                    </form>
                </div>
            </div>


        </div>
        <?php endif; ?>
    </div>
    </div>
    </div>
    <!-- ENDING OF My Bag -->
    </div>
    </div>


    <script>
    <?php if (!$loggedIn) : ?>
    document.getElementById('messagesLink').classList.add('disabled');
    document.getElementById('orderLink').classList.add('disabled');
    <?php endif; ?>
    </script>

    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script>
        <?php if ($isCartEmpty) : ?>
            document.getElementById('orderLink').classList.add('disabled');
        <?php endif; ?>
    </script>
</body>

</html>
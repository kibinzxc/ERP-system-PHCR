<?php
session_start();

// Check if user is logged in

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

    $sql = "SELECT address FROM users WHERE uid = $currentUserId"; // Replace 'users' with your table name
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userAddress = $row['address']; // Store the user's address in a variable
        $currentUserId = $currentUserId;
    } else {
        $userAddress = "House No, Street, City, Province"; // Set a default value if no address is found
    }

    $conn->close();
} else {
    $currentUserId = 123; // or any default value
    $loggedIn = false;
    $userAddress = "";
}


if (isset($_GET['logout'])) {
    if (isset($_SESSION['uid'])) {

        session_destroy();
        unset($_SESSION['uid']);
    }
    header("Location: login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Hut Chino Roces Branch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/pages/ordering/css/styles.css">
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="src/pages/ordering/js/index.js"></script>
    <script src="src/pages/ordering/js/search-index.js"></script>
</head>

<body>

    <div class="container-fluid">
        <div class="row row-flex">
            <!-- Add the row-flex class -->
            <div class="col-sm-1 custom-width">
                <!-- Add the custom-width class -->
                <div class="sidebar">
                    <a href="index.php" class="item1">
                        <img class="logo" src="src\assets\img\pizzahut-logo.png" alt="Pizza Hut Logo">
                    </a>
                    <a href="src\pages\ordering\favorites.php" class="item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="src\pages\ordering\menu.php" class="item">
                        <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="src\pages\ordering\order.php" class="item">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Order</span>
                    </a>
                    <a href="src\pages\ordering\promo.php" class="item">
                        <i class="fa-solid fa-ticket"></i>
                        <span>Promo</span>
                    </a>
                    <a href="src\pages\ordering\rewards.php" class="item-last">
                        <i class="fa-solid fa-trophy"></i>
                        <span>Rewards</span>
                    </a>
                    <!-- Toggle Login/Logout link -->
                    <?php if ($loggedIn): ?>
                        <a href="src\pages\ordering\profile.php" class="item">
                            <i class="fa-solid fa-user"></i>
                            <span>Profile</span>
                        </a>
                        <a href="index.php?logout=1" class="item">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </a>
                    <?php else: ?><br><br>
                        <a href="login.php" class="item-login">
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
                        <div class="col-sm-11">
                            <div class="search-container">
                                <input type="text1" id="searchInput" placeholder="What would you like to eat?">
                                <ul id="searchResults"></ul>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="notification-container">
                                <a href="#" <?php if (!$loggedIn)
                                    echo 'disabled'; ?>>
                                    <i class="fas fa-bell notification-icon"></i>
                                </a>
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
                            <div class="col-sm-12">
                                <button id="counterBtn" style="font-weight:550; cursor:auto;" class="active"
                                    disabled>Delivery Address</button>
                            </div>
                            <div id="deliveryContent" style="display: block;">
                                <form method="post">
                                    <div class="col-sm-12">
                                        <input style="font-weight:bold; color:#333; margin-left:10px;" type="text"
                                            value="<?php echo $userAddress; ?>" <?php if (!$loggedIn)
                                                   echo 'disabled'; ?>><br><br>
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
                                                                <img src="src/assets/img/menu/' . $row['img'] . '" alt="notif pic" style="width:100%; max-width:100%; min-width:100px; height:auto; overflow:hidden; border-radius:10px;">
                                                            </div>
                                                        </div>
                                                        <div class = "col-sm-6">
                                                            <div class = "caption">
                                                                <p>' . $row['namesize'] . '</p>
                                                            </div>
                                                            <div class="remove-btn">
                                                                <a  href="#" class="remove-btn"><i class="fa-solid fa-xmark" style="font-size:25px;"></i></a> 
                                                            </div>    
                                                        </div>
                                                        <div class = "col-sm-2">
                                                            <div class = "price">
                                                                <p><span class="price-display" data-id="' . $row['cart_id'] . '">₱' . $row['price'] . '</span></p>
                                                                <input type="hidden" class="price" name="price" data-id="' . $row['cart_id'] . '" value="' . $row['price'] . '">
                                                            <div class = "quantity1">
                                                            <select class="quantity" name="quantity" data-id="' . $row['cart_id'] . '">';
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

                                                echo '<p style="text-align:center; margin-top:50px;">Add Items to your Bag</p> ';
                                            }
                                        } else {
                                            echo '<p style="text-align:center; margin-top:50px;">Please Login to Continue</p> ';
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
                                    <div class="col-sm-12" style="padding:0 20px 0 20px; margin-top:20px;">
                                        <input type="submit" value="Checkout" class="checkout" name="checkout" <?php if (!$loggedIn)
                                            echo 'disabled'; ?>>
                                    </div>
                            </div>
                            </form>
                        <?php else: ?>
                            <div class="col-sm-12">
                                <button id="deliveryBtn" class="active" style="font-weight:550; cursor:auto;" disabled>Over the Counter</button>
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
                                                                <img src="src/assets/img/menu/' . $row3['img'] . '" alt="notif pic" style="width:100%; max-width:100%; min-width:100px; height:auto; overflow:hidden; border-radius:10px;">
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
                                    </div>
                            </div>
                            </form>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- ENDING OF My Bag -->
    </div>
    </div>



</body>

</html>

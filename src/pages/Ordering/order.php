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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/order.css">
    <script src="../../../src/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/search-index.js"></script>
    
</head>

<body>
    <div class="container-fluid">
        <div class = "row row-flex"> <!-- Add the row-flex class -->
            <div class = "col-sm-1 custom-width"> <!-- Add the custom-width class -->
                <div class="sidebar">
                    <a href="../../../index.php" class="item1">
                        <img class="logo" src="../../assets/img/pizzahut-logo.png" alt="Pizza Hut Logo">
                    </a>
                    <a href="favorites.php" class="item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="menu.php" class="item">
                    <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="order.php" class="item active">
                    <i class="fa-solid fa-receipt"></i>
                        <span>Order</span>
                    </a>
                    <a href="promo.php" class="item-last">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Notification</span>
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
            <div class = "col-sm-11">
                <div class = "container" style="padding:0;">
                    <div class = "row">
                        <div class = "col-sm-9">
                            <div class="search-container">
                                
                            </div>
                        </div>
                        <div class = "col-sm-1">
                            <div class = "notification-container">
                                <a href="#" <?php if (!$loggedIn)
                                    echo 'disabled'; ?>>
                                    <i class="fas fa-bell notification-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class = "col-sm-1">
                            <div class = "notification-container">
                                <a href="#" <?php if (!$loggedIn)
                                    echo 'disabled'; ?>>
                                    <i class="fas fa-bell notification-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class = "col-sm-1">
                            <div class = "notification-container">
                                <a href="#" <?php if (!$loggedIn)
                                    echo 'disabled'; ?>>
                                <i class="fa-solid fa-bag-shopping"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- ENDING OF BODY -->
            
        </div>
    </div>
</body>

</html>
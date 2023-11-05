<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../../src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/favorites.css">
    <script src="../../../src/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    
</head>

<body>
    <div class="container-fluid">
        <div class = "row row-flex"> <!-- Add the row-flex class -->
            <div class = "col-sm-1 custom-width"> <!-- Add the custom-width class -->
                <div class="sidebar">
                    <a href="../../../index.php" class="item1">
                        <img class="logo" src="../../../src\assets\img\pizzahut-logo.png" alt="Pizza Hut Logo">
                    </a>
                    <a href="favorites.php" class="item active">
                        <i class="fa-regular fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="menu.php" class="item">
                    <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="order.php" class="item">
                    <i class="fa-solid fa-receipt"></i>
                        <span>Order</span>
                    </a>
                    <a href="promo.php" class="item">
                    <i class="fa-solid fa-ticket"></i>
                        <span>Promo</span>
                    </a>
                    <a href="rewards.php" class="item">
                    <i class="fa-solid fa-trophy"></i>
                        <span>Rewards</span>
                    </a>

                    <!-- Removed toggle button -->
                    <!-- Add more items as needed -->
                </div>
            </div>
            <div class = "col-sm-11 fill-remaining" style="background: white;"> <!-- Add the fill-remaining class -->
                  

            </div>
        </div>
    </div>
</body>

</html>
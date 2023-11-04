<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    <style>
    .logo {
        width: 100%;
        pointer-events:auto;
        margin: 10px 0 0 0; /* top | right | bottom | left */
    }
    .sidebar .item1{
        display: flex;
        flex-direction: column; /* Change to column direction */
        align-items: center;
        justify-content: center;
        padding: 10px;
        margin: 10px 0 10px 0; /* top | right | bottom | left */
        pointer-events:none;
    }
    .sidebar {
        height: 100vh; /* Add this rule */ 
    }
    .sidebar a {
        text-decoration: none;
        color: inherit;
    }
    .sidebar .item {
        display: flex;
        flex-direction: column; /* Change to column direction */
        align-items: center;
        justify-content: center;
        padding: 20px;
        margin: 15px 0 15px 0; /* top | right | bottom | left */
    }
    .sidebar .item:hover{
        background: #ddd;
    }
    .sidebar .item.active{
        background: #ddd;
        border-right: 5px solid red; /* Add this rule */
    }
    .custom-width {
        width: 100px!important; /* Add this rule */
        padding: 0!important; /* Remove padding */
        background: #efefef;
    }
    .fill-remaining {
        width: calc(100% - 100px); /* Fill remaining space */
    }
    .sidebar .item i {
    font-size: 1.3em; /* Adjust this value as needed */
    }
</style>
</head>

<body>
    <div class="container-fluid">
    <div class = "row row-flex"> <!-- Add the row-flex class -->
            <div class = "col-sm-1 custom-width"> <!-- Add the custom-width class -->
                <div class="sidebar">
                    <a href="home.php" class="item1">
                        <img class="logo" src="src\assets\img\pizzahut-logo.png" alt="Pizza Hut Logo">
                    </a>
                    <a href="#" class="item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="#" class="item active">
                    <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="#" class="item">
                    <i class="fa-solid fa-receipt"></i>
                        <span>Order</span>
                    </a>
                    <a href="#" class="item">
                    <i class="fa-solid fa-ticket"></i>
                        <span>Deals</span>
                    </a>
                    <a href="#" class="item">
                    <i class="fa-solid fa-trophy"></i>
                        <span>Rewards</span>
                    </a>

                    <!-- Removed toggle button -->
                    <!-- Add more items as needed -->
                </div>
            </div>
            <div class = "col-sm-11 fill-remaining" style="background: pink;"> <!-- Add the fill-remaining class -->
                  

            </div>
        </div>
    </div>
</body>

</html>
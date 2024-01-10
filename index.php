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
    $currentUserId = 01; // or any default value
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
    <link rel="stylesheet" href="src/pages/index/css/styles.css">
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    <a href="src\pages\index\favorites.php" class="item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="src\pages\index\menu.php" class="item">
                        <i class="fa-solid fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="src\pages\index\order.php" class="item">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Order</span>
                    </a>
                    <a href="src\pages\index\promo.php" class="item">
                        <i class="fa-solid fa-ticket"></i>
                        <span>Promo</span>
                    </a>
                    <a href="src\pages\index\rewards.php" class="item-last">
                        <i class="fa-solid fa-trophy"></i>
                        <span>Rewards</span>
                    </a>
                    <!-- Toggle Login/Logout link -->
                    <?php if ($loggedIn): ?>
                        <a href="src\pages\index\profile.php" class="item">
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
                                <a href="#">
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
                        <div class="col-sm-12">
                            
                                <button id="deliveryBtn" class="active">Delivery Address</button>
                                <button id="counterBtn">Over the Counter</button>
                                
                        </div>
                        <div id="deliveryContent" style="display: block;">
                        <form method="post">
                        <div class = "col-sm-12">
                        <input style="font-weight:bold; color:#333; margin-left:10px;" type="text" value="<?php echo $userAddress; ?>" <?php if (!$loggedIn) echo 'disabled'; ?>><br><br>
                        </div>                  
                        <div class="col-sm-12 cart"
                            style="margin:0 0 -25px 0; padding:0; height:45vh; overflow-y: scroll; overflow:auto; ">

                            <?php
                            $db = new mysqli('localhost', 'root', '', 'ph_db');
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

                                echo '<p style="text-align:center; margin-top:50px;">Please Login to Continue</p> ';
                            }
                            ?>
                           
                        </div>
                        <div class = "col-sm-12" style="margin: 30px 0 0 0;">
                            <div class = "linebreak" style="margin:0 15px 0 5px;">
                                <hr style="height:2px;">
                            </div>
                        </div>
                        <div class = "col-sm-12">
                            <div class = "container">
                                <div class = "row">
                                    <div class = "col-sm-6" style="padding:0; margin:0;">
                                    <p style="font-weight:550">Sub Total</p>
                                    <p style="font-weight:550">Delivery Fee</p>
                                    </div>
                                     <div class = "col-sm-6" style = "padding:0; margin:0;">
                                        <p id="subtotal" style="margin-left: 30px; font-weight:bold;">₱ 0</p>
                                        <p style = "margin-left:30px; font-weight:bold;">₱ 70.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-sm-12">
                            <div class = "linebreak" style="margin:0 15px 0 5px;">
                                <hr style="height:2px;">
                            </div>
                        </div>
                       <div class = "col-sm-12">
                            <div class = "container">
                                <div class = "row">
                                    <div class = "col-sm-6" style="padding:0; margin:0;">
                                    <p style="font-weight:550">Total</p>
                                    </div>
                                     <div class = "col-sm-6" style = "padding:0; margin:0;">
                                        <p id="total_amount" style = "margin-left:30px; font-weight:bold;">₱ 0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-sm-12" style="padding:0 20px 0 20px; margin-top:20px;">
                            <input type="submit" value="Checkout" class="checkout" name="checkout">
                        </div>
                        </div>
                        </form>
                        
                        <div id="counterContent" style="display: none;">
                        <!-- Your over the counter content here -->
                        </div>   
                    </div>
                </div>
            </div>
            <!-- ENDING OF My Bag -->
        </div>
    </div>
 <script>
$(document).ready(function () {
    // Function to update subtotal
    function updateSubtotal() {
        var subtotal = 0;

        // Iterate through each item in the cart
        $('.box').each(function () {
            var quantity = parseInt($(this).find('.quantity').val()); // Parse quantity to integer
            var price = parseFloat($(this).find('.price').text().replace('₱', '').trim()); // Parse and extract price

            subtotal += quantity * price;
        });

        $('#subtotal').text('₱ ' + subtotal.toFixed(2)); // Display subtotal with two decimal places

        updateTotalAmount(subtotal); // Call function to update total amount
    }

    // Function to update total amount
    function updateTotalAmount(subtotal) {
        var deliveryFee = 70; // Fixed delivery fee
        var totalAmount = subtotal + deliveryFee; // Calculate total amount

        $('#total_amount').text('₱ ' + totalAmount.toFixed(2)); // Display total amount with two decimal places
    }

    // Event listener for quantity change
    $('.quantity').on('change', function () {
        var id = $(this).data('id');
        var quantity = parseInt($(this).val());
        var price = parseFloat($('.price[data-id="' + id + '"]').val());

        var newPrice = quantity * price;

        $('.price-display[data-id="' + id + '"]').text('₱' + newPrice.toFixed(0));

        updateSubtotal();
    });

    // Initial update of subtotal when the page loads
    updateSubtotal();
});

    </script>



</body>

</html>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    // Dummy data for demonstration
    const data = [
        'Mag aaral',
        'Mag cocode',
        'Mag fofoodtrip',
        'Mag dadasal',
        'Mag kakalat',
        'Mag ooverthink',
        'Mag wawalwal'
        // Add more data as needed
    ];

    searchInput.addEventListener('input', function () {
        const inputValue = this.value.toLowerCase();
        const filteredData = data.filter(item => item.toLowerCase().includes(inputValue));
        displayResults(filteredData);
    });

    function displayResults(results) {
        searchResults.innerHTML = '';
        if (results.length === 0) {
            searchResults.style.display = 'none';
            return;
        }

        results.forEach(result => {
            const li = document.createElement('li');
            li.textContent = result;
            li.addEventListener('click', function () {
                searchInput.value = result;
                searchResults.style.display = 'none';
            });
            searchResults.appendChild(li);
        });

        searchResults.style.display = 'block';
    }

    // Hide results on outside click
    document.addEventListener('click', function (e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.style.display = 'none';
        }
    });
</script>




<script>
    // Get references to the buttons and sections
document.getElementById('deliveryBtn').addEventListener('click', function() {
    document.getElementById('deliveryContent').style.display = 'block';
    document.getElementById('counterContent').style.display = 'none';
    document.getElementById('deliveryBtn').classList.add('active');
    document.getElementById('counterBtn').classList.remove('active');
});

document.getElementById('counterBtn').addEventListener('click', function() {
    document.getElementById('deliveryContent').style.display = 'none';
    document.getElementById('counterContent').style.display = 'block';
    document.getElementById('counterBtn').classList.add('active');
    document.getElementById('deliveryBtn').classList.remove('active');
});

</script>

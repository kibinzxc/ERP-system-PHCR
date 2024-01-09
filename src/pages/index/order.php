<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']); // Change 'user' to 'email' for consistency
    header("Location:../../../login.php");
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
                    <a href="promo.php" class="item">
                    <i class="fa-solid fa-ticket"></i>
                        <span>Promo</span>
                    </a>
                    <a href="rewards.php" class="item-last">
                    <i class="fa-solid fa-trophy"></i>
                        <span>Rewards</span>
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
                        <div class = "col-sm-10">
                            <div class="search-container">
                                <input type="text" id="searchInput" placeholder="Find your previous selections">
                                <ul id="searchResults"></ul>
                            </div>
                        </div>
                        <div class = "col-sm-1">
                            <div class = "notification-container">
                                <a href="#" >
                                <i class="fas fa-bell notification-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class = "col-sm-1">
                            <div class = "notification-container">
                                <a href="#" >
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

  searchInput.addEventListener('input', function() {
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
      li.addEventListener('click', function() {
        searchInput.value = result;
        searchResults.style.display = 'none';
      });
      searchResults.appendChild(li);
    });

    searchResults.style.display = 'block';
  }

  // Hide results on outside click
  document.addEventListener('click', function(e) {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
      searchResults.style.display = 'none';
    }
  });
</script>
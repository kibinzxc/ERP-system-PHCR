<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Establish connection to your MySQL database
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "ph_db";

        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get user input from the form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // SQL injection prevention
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // Hash the password (you should use a more secure hashing algorithm in practice)
        $hashed_password = md5($password);

        // Search for user in the database
        $sql = "SELECT * FROM customers WHERE email='$email' AND password='$hashed_password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Login successful
            // Start a session
            session_start();
            // Store username in the session
            $_SESSION['email'] = $email;
            // Redirect to a logged-in page
            header("Location: index.php");
            exit();
        } else {
            // Login failed
            echo "<p>Login failed. Invalid username or password.</p>";
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.min.css">
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
    <link   rel="stylesheet" href ="src/pages/index/css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    
</head>
<body>
    <div class = "container">
        <div class = "row">
            <div class = "col-sm-1" style="height:6vh; background:white;">
                <button type="button" class= "back-btn" onclick="window.history.back()">
                    <i class="fa-solid fa-arrow-left" style="margin-right:7px;"></i>BACK
                </button>
            </div>

            <div class = "col-sm-11" style="height:6vh; background:white;">
                <div class = "topnav">
                    <a href = "index.php">
                        <img class="logo" src="src/assets/img/pizza_hut_horizontal_logo.png">
                    </a>
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-sm-12 no-padding">
                <div class ="backdrop">
                    <img class="full-screen" src="src/assets/img/blurred-login-backdrop.png">
                </div>
                <div class = "wrapper">
                    <div class = "login-wrapper">
                        <h1 class = "title">Login</h1><br><br><br><br>
                            <form action="" method="post">
                                <div class="user-box">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="username@email.com">
                                </div>
                                <div class="user-box">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder = "Password">
                                    <a href="forgotPass.php" >Forgot Password?</a>
                                </div>
                                    <input type="submit" value="Sign in" class="login-btn" name="login">
                                <div class="additional-links">
                                    <p>Don't have an account yet?<a href="register.php" class="register-link">Register here</a></p>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>

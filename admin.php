<?php
include('src/db/config.php');


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];

            switch ($_SESSION['user_type']) {
                case "cashier":
                    header("Location: src/pages/cashier/cashier.php");
                    break;
                case "manager":
                    header("Location: manager-dashboard.php");
                    break;
                case "customer":
                    header("Location: ordering-page.php");
                    break;
                case "employee":
                    header("Location: employee-dashboard.php");
                    break;
                default:
                    echo "Invalid user type.";
            }
        }
    } else {
        echo "Invalid email or password. Please try again.";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login Page</title>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="email" placeholder="email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div>
        <h2>Login</h2>
        <form action="process_login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" onkeyup="validateUsername()" required><br>
            <span id="username-status"></span><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        function validateUsername() {
            var username = document.getElementById("username").value;
            var statusElement = document.getElementById("username-status");

            if (username.startsWith("02")) {
                statusElement.textContent = "✔";
            } else {
                statusElement.textContent = "✘";
            }
        }
    </script>
</body>

</html>

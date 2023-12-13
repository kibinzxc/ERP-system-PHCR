<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Box</title>
  <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
  <div class="login-box">
    <h2>Login</h2>
    <form action="#">
      <div class="user-box">
        <input type="text" name="username" required>
        <label>Username</label>
      </div>
      <div class="user-box">
        <input type="password" name="password" required>
        <label>Password</label>
      </div>
      <a href="#" class="button">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Submit
      </a>
      <div class="additional-links">
        <a href="#" class="forgot-password">Forgot Password?</a>
        <p>Don't have an account? <a href="#" class="register-link">Register here</a></p>
      </div>
    </form>
  </div>
</body>
</html>

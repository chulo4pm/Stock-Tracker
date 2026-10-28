<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stock Tracker Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

  <div class="login-wrapper">
    <div class="login-box">
      <div class="login-header">
        <img src="assets/img/logo.png" alt="Logo" class="login-iconlogo">
        <h2>Stock Tracker</h2>
      </div>
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 1): ?>
          <div id="logout-message" class="logout-message">
          You have logged out successfully.
          </div>
        <?php endif; ?>

      <h3 class="login-title">Login</h3>

      <?php
      if (isset($_SESSION['register_success'])) {
          echo "<p style='color:green'>" . $_SESSION['register_success'] . "</p>";
          unset($_SESSION['register_success']);
      }
      if (isset($_SESSION['register_error'])) {
          echo "<p style='color:red'>" . $_SESSION['register_error'] . "</p>";
          unset($_SESSION['register_error']);
      }
      if (isset($_SESSION['login_error'])) {
          echo "<p style='color:red'>" . $_SESSION['login_error'] . "</p>";
          unset($_SESSION['login_error']);
      }
      ?>

      <form class="login-form" action="auth/login_process.php" method="POST">
        <div class="input-group">
          <img src="assets/img/pf.png" alt="User Icon" class="input-icon">
          <input type="text" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
          <img src="assets/img/lock-icon-11.png" alt="Lock Icon" class="input-icon">
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" class="login-button" name="login">LOGIN</button>
      </form>
    </div>
  </div>
<script>
  setTimeout(function() {
    var msg = document.getElementById('logout-message');
    if (msg) msg.style.display = 'none';
  }, 10000);
</script>
</body>
</html>

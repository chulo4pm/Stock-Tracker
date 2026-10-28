<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'manager') {
  header("Location: ../login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account - Stock Tracker</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-bodytwo">
  <?php include '../includes/sidebar.php'; ?>
  <div class="login-wrapper" style="margin-left:220px;">
    <div class="login-box">
      <div class="login-header" style="display: flex; align-items: center; justify-content: flex-start; gap: 10px;">
        <img src="../assets/img/logo.png" alt="Box Icon" class="login-iconlogo">
        <h2 style="margin: 0;">Stock Tracker</h2> 
      </div>

      <h3 class="login-title" style="text-align: center;">Create an account</h3>
      <?php
      if (isset($_SESSION['register_error'])) {
          echo "<p style='color:red; text-align:center'>" . $_SESSION['register_error'] . "</p>";
          unset($_SESSION['register_error']);
      }
      if (isset($_SESSION['register_success'])) {
          echo "<p style='color:green; text-align:center'>" . $_SESSION['register_success'] . "</p>";
          unset($_SESSION['register_success']);
      }
      ?>

      <form class="login-form" action="register.php" method="POST">
        <div class="input-group">
          <input type="text" name="fullname" placeholder="Full Name" required>
        </div>

        <div class="input-group">
          <img src="../assets/img/pf.png" alt="Email Icon" class="input-icon">
          <input type="text" name="user" placeholder="Email" required>
        </div>

        <div class="input-group">
          <img src="../assets/img/lock-icon-11.png" alt="Lock Icon" class="input-icon">
          <input type="password" name="password" placeholder="Password" required autocomplete="off">
        </div>

        <div class="input-group">
          <select name="role" required class="input-select">
            <option value="" disabled selected>Select Role</option>
            <option value="manager">Manager</option>
            <option value="staff">Staff</option>
          </select>
        </div>

        <button type="submit" class="login-button" name="register">Create</button>

      </form>
    </div>
  </div>

</body>
</html>
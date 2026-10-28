<?php
session_start();
include '../includes/sidebar.php';
if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Stock Tracker Inventory System</title>
  
</head>
<body>
   <div class="main-content">
      <div class="account-container">
        <h2>Account Details</h2>
        <div class="account-info">
          <p>Name: <?php echo htmlspecialchars($_SESSION['name']); ?></p>
          <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
          <p>Position: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
        </div>
        <form action="../auth/logout.php" method="post">
          <button type="submit" class="logout-btn">Log Out</button>
        </form>
      </div>
    </div>
</body>
</html>
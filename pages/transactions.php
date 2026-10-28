<?php
session_start();
require_once '../config.php';
include '../includes/sidebar.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
  exit();
}

// Get sales and restock history
$sales = $conn->query("SELECT * FROM sales_history ORDER BY date_purchased DESC");
$restocks = $conn->query("SELECT * FROM restock_history ORDER BY date_restocked DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/transactions.css">
  <title>Transactions History</title>
</head>
<body>
<div class="main">
  <h1>📊 Transactions History</h1>

  <div class="transactions-container">
    <div class="transaction-section">
      <h2>🛒 Sales History</h2>
      <table>
        <thead>
          <tr><th>Item Name</th><th>Quantity</th><th>Total</th><th>Date Purchased</th></tr>
        </thead>
        <tbody>
          <?php while ($row = $sales->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['item_name']) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td>₱<?= number_format($row['total'], 2) ?></td>
              <td><?= $row['date_purchased'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="transaction-section">
      <h2>📦 Restock History</h2>
      <table>
        <thead>
          <tr><th>Item Name</th><th>Quantity</th><th>Date Restocked</th></tr>
        </thead>
        <tbody>
          <?php while ($row = $restocks->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['item_name']) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td><?= $row['date_restocked'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>

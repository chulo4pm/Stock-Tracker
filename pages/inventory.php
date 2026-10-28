<?php
session_start();
include '../includes/sidebar.php';
require_once '../config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
  exit();
}

function displayItems($conn, $table_name, $title) {
  echo '
  <div class="table-section">
    <div style="display: flex; justify-content: space-between; align-items: center; background-color: #4880c9; padding: 10px 20px;">
      <h4 style="color: white; margin: 0;">' . ucfirst($title) . '</h4>
    </div>
    <table>
      <thead>
        <tr class="coloum">
          <th>Item Name</th><th>Quantity</th><th>Price</th><th>Aisle</th>
        </tr>
      </thead>
      <tbody>
  ';

  $query = "SELECT * FROM $table_name";
  $result = $conn->query($query);

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '
        <tr>
          <td><a href="selected_item.php?table=' . $table_name . '&id=' . $row['id'] . '" style="text-decoration:none; color:#000;">' . htmlspecialchars($row['item_name']) . '</a></td>
          <td>' . htmlspecialchars($row['quantity']) . '</td>
          <td>₱' . htmlspecialchars($row['price']) . '</td>
          <td>' . htmlspecialchars($row['aisle_number']) . '</td>
        </tr>
      ';
    }
  } else {
    echo '<tr><td colspan="4">No items found</td></tr>';
  }

  echo '
      </tbody>
    </table>
  </div>
  ';
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

  <div class="main">
  <div style="position: relative; min-height: 70px; margin-bottom: 30px;">
    <div style="display: flex; align-items: center;">
      <h1 style="margin: 0;">INVENTORY</h1>
    </div>
    <?php if ($_SESSION['role'] === 'manager'): ?>
      <form action="add_item.php" method="post" style="position: absolute; top: 0; right: 0;">
        <button type="submit" class="add_item-button top-cart">➕ Add Item</button>
      </form>
    <?php elseif ($_SESSION['role'] !== 'manager'): ?>
      <form action="cart.php" method="post" style="position: absolute; top: 0; right: 0;">
        <button type="submit" class="cart-button top-cart">🛒 Cart</button>
      </form>
    <?php endif; ?>
  </div>
    <div class="grid-container">
      <?php
      displayItems($conn, 'tables_item', 'Tables');
      displayItems($conn, 'chairs_item', 'Chairs');
      displayItems($conn, 'cabinets_item', 'Cabinets');
      displayItems($conn, 'beds_item', 'Beds');
      ?>
    </div>
  </div>
</body>
</html>

<?php
session_start();
include '../includes/sidebar.php';
require_once '../config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'manager') {
  header("Location: ../login.php");
  exit();
}

$table = isset($_GET['table']) ? $_GET['table'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$valid_tables = ['tables_item', 'chairs_item', 'cabinets_item', 'beds_item'];
if (!in_array($table, $valid_tables) || !$id) {
  die("Invalid request.");
}

// Fetch item details
$stmt = $conn->prepare("SELECT * FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$item) {
  die("Item not found.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $item_name = $_POST['item_name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $aisle_number = $_POST['aisle_number'];

  $update = $conn->prepare("UPDATE $table SET item_name=?, price=?, quantity=?, aisle_number=? WHERE id=?");
  $update->bind_param("sdisi", $item_name, $price, $quantity, $aisle_number, $id);
  if ($update->execute()) {
    header("Location: inventory.php?status=edited");
    exit();
  } else {
    $error = "Failed to update item.";
  }
  $update->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/add_item.css">
  <title>Edit Item | Stock Tracker</title>
</head>
<body>
  <div class="main-content">
    <div class="add_item-container">
      <h2>Edit Item</h2>
      <?php if (isset($error)): ?>
        <div style="color:red; text-align:center;"><?= $error ?></div>
      <?php endif; ?>
      <form class="add_item-form" method="POST" action="../assets/backends/edit_item_process.php">
        <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <div class="add_item-group">
          <h1>Item Name:</h1>
          <input type="text" name="item_name" value="<?= htmlspecialchars($item['item_name']) ?>" required>
        </div>
        <div class="add_item-group">
          <h1>Price:</h1>
          <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($item['price']) ?>" required>
        </div>
        <div class="add_item-group">
          <h1>Quantity:</h1>
          <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" required>
        </div>
        <div class="add_item-group">
          <h1>Aisle Number:</h1>
          <input type="text" name="aisle_number" value="<?= htmlspecialchars($item['aisle_number']) ?>" required>
        </div>
        <div class="button-group">
          <button type="submit" class="add-btn">Save Changes</button>
          <a href="inventory.php" class="back-btn" style="margin-left:10px;">Back</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

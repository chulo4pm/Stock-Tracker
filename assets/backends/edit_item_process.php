<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'manager') {
  header("Location: ../../login.php");
  exit();
}

 $table = isset($_POST['table']) ? $_POST['table'] : '';
 $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$valid_tables = ['tables_item', 'chairs_item', 'cabinets_item', 'beds_item'];
if (!in_array($table, $valid_tables) || !$id) {
  die("Invalid request.");
}

 $item_name = $_POST['item_name'];
 $price = $_POST['price'];
 $quantity = $_POST['quantity'];
 $aisle_number = $_POST['aisle_number'];

$update = $conn->prepare("UPDATE $table SET item_name=?, price=?, quantity=?, aisle_number=? WHERE id=?");
$update->bind_param("sdisi", $item_name, $price, $quantity, $aisle_number, $id);
if ($update->execute()) {
  header("Location: ../../pages/inventory.php?status=edited");
  exit();
} else {
  die("Failed to update item.");
}
$update->close();
?>

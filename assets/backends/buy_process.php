<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../../login.php");
  exit();
}

$email = $_SESSION['email'];

// Get cart items
$cart_items = $conn->prepare("SELECT * FROM cart WHERE user_email=?");
$cart_items->bind_param("s", $email);
$cart_items->execute();
$result = $cart_items->get_result();

while ($row = $result->fetch_assoc()) {
  $table = $row['item_table'];
  $id = $row['item_id'];
  $qty = $row['quantity'];

  // Get item details
  $check = $conn->prepare("SELECT item_name, price, quantity FROM $table WHERE id=?");
  $check->bind_param("i", $id);
  $check->execute();
  $item = $check->get_result()->fetch_assoc();

  if ($item && $item['quantity'] >= $qty) {
    // Update stock
    $update = $conn->prepare("UPDATE $table SET quantity = quantity - ? WHERE id = ?");
    $update->bind_param("ii", $qty, $id);
    $update->execute();

    // Record in sales_history
    $total = $item['price'] * $qty;
    $insert = $conn->prepare("INSERT INTO sales_history (user_email, item_name, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("ssdii", $email, $item['item_name'], $item['price'], $qty, $total);
    $insert->execute();
  }
}

// Clear cart after buying
$clear = $conn->prepare("DELETE FROM cart WHERE user_email=?");
$clear->bind_param("s", $email);
$clear->execute();

header("Location: ../../pages/cart.php?status=bought");
exit();
?>

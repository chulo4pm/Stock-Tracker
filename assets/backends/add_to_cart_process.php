<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../../login.php");
  exit();
}

if (isset($_POST['table'], $_POST['id'], $_POST['quantity'])) {
  $table = $_POST['table'];
  $id = intval($_POST['id']);
  $qty = intval($_POST['quantity']);
  $email = $_SESSION['email'];

  // Validate table name
  $valid_tables = ['tables_item', 'chairs_item', 'cabinets_item', 'beds_item'];
  if (!in_array($table, $valid_tables)) {
    header("Location: ../../pages/cart.php?status=error");
    exit();
  }

  // Check stock
  $stmt = $conn->prepare("SELECT quantity FROM $table WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();

  if (!$result || $result['quantity'] < $qty) {
    header("Location: ../../pages/cart.php?status=lowstock");
    exit();
  }

  // Add or update cart
  $check = $conn->prepare("SELECT * FROM cart WHERE user_email=? AND item_table=? AND item_id=?");
  $check->bind_param("ssi", $email, $table, $id);
  $check->execute();
  $exists = $check->get_result();

  if ($exists->num_rows > 0) {
    $update = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_email=? AND item_table=? AND item_id=?");
    $update->bind_param("issi", $qty, $email, $table, $id);
    $update->execute();
  } else {
    $insert = $conn->prepare("INSERT INTO cart (user_email, item_table, item_id, quantity) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssii", $email, $table, $id, $qty);
    $insert->execute();
  }

  header("Location: ../../pages/cart.php?status=added");
  exit();
} else {
  header("Location: ../../pages/cart.php?status=error");
  exit();
}
?>

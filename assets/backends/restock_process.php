<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../../login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_SESSION['email'];
  $item_type = $_POST['item_type'];
  $item_name = trim($_POST['item_name']);
  $quantity = intval($_POST['quantity']);

  // ✅ List of valid tables to prevent SQL injection
  $valid_tables = ['tables_item', 'chairs_item', 'cabinets_item', 'beds_item'];

  if (!in_array($item_type, $valid_tables)) {
    header("Location: ../../pages/restockitem.php?status=invalid");
    exit();
  }

  // ✅ Check if the item exists
  $check = $conn->prepare("SELECT id FROM $item_type WHERE item_name = ?");
  $check->bind_param("s", $item_name);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    // ✅ Update quantity and date
    $update = $conn->prepare("UPDATE $item_type SET quantity = quantity + ?, date_created = NOW() WHERE item_name = ?");
    $update->bind_param("is", $quantity, $item_name);

    if ($update->execute()) {
      // ✅ Insert record to restock_history table
      $insert = $conn->prepare("INSERT INTO restock_history (user_email, item_name, quantity, date_restocked) VALUES (?, ?, ?, NOW())");
      $insert->bind_param("ssi", $email, $item_name, $quantity);
      $insert->execute();

      header("Location: ../../pages/restockitem.php?status=success");
      exit();
    } else {
      header("Location: ../../pages/restockitem.php?status=error");
      exit();
    }
  } else {
    // ❌ Item not found
    header("Location: ../../pages/restockitem.php?status=notfound");
    exit();
  }
} else {
  header("Location: ../../pages/restockitem.php?status=invalid");
  exit();
}
?>

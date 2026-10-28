<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../../login.php");
  exit();
}

if (isset($_GET['id'])) {
  $cart_id = intval($_GET['id']);
  $email = $_SESSION['email'];

  // Delete item only for that user
  $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_email = ?");
  $stmt->bind_param("is", $cart_id, $email);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    header("Location: ../../pages/cart.php?status=removed");
    exit();
  } else {
    die("Error: Item not found or cannot be deleted.");
  }

  $stmt->close();
} else {
  die("Invalid request.");
}
?>
    
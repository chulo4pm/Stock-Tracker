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
    <link rel="stylesheet" href="../assets/css/add_item.css">
    <title>Stock Tracker Inventory System</title>
  </head>
  <body>
   <div class="main-content">
      <div class="add_item-container">
        <h2>Add Item</h2>
        <form class="add_item-form" action="../assets/backends/add_items_process.php" method="POST" enctype="multipart/form-data">
        <div class="input-group">
        <h1>Select Item:</h1>
        <select name="selected_item" required class="input-select">
          <option value="" disabled selected>Select Item</option>
          <option value="table">Table</option>
          <option value="chair">Chair</option>
          <option value="cabinet">Cabinet</option>
          <option value="bed">Bed</option>
        </select>
      </div>

      <div class="add_item-group">
        <h1>Item Name:</h1>
        <input type="text" name="item_name" required>
      </div>

      <div class="add_item-group">
        <h1>Price:</h1>
        <input type="number" name="price" required>
      </div>

      <div class="add_item-group">
        <h1>Quantity:</h1>
        <input type="number" name="quantity" required>
      </div>

      <div class="add_item-group">
        <h1>Aisle Number:</h1>
        <input type="text" name="aisle_number" required>
      </div>

      <div class="add_item-group">
        <h1>Upload Image:</h1>
        <input type="file" name="item_image" accept="image/*" required>
      </div>

      <div class="button-group">
        <button type="submit" name="submit" class="add-btn">Add</button>
        <button type="button" class="back-btn" onclick="history.back()">Back</button>
      </div>
    </div>
  </div>
</body>
</html>
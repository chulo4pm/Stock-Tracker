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
  <link rel="stylesheet" href="../assets/css/restock.css"> <!-- External CSS for Restock Page -->
  <title>Restock Item | Stock Tracker</title>
</head>
<body>
  <div class="main">
    <div class="form-section">
      <h1>Restock Item</h1>

      <!-- Status message -->
      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
          <div class="alert success">✅ Item successfully restocked!</div>
        <?php elseif ($_GET['status'] == 'notfound'): ?>
          <div class="alert error">⚠️ Item not found!</div>
        <?php elseif ($_GET['status'] == 'error'): ?>
          <div class="alert error">❌ Something went wrong!</div>
        <?php endif; ?>
      <?php endif; ?>

      <form method="POST" action="../assets/backends/restock_process.php">
        <label for="item-type">Item Type</label>
        <select id="item-type" name="item_type" required>
          <option value="tables_item">Table</option>
          <option value="chairs_item">Chair</option>
          <option value="cabinets_item">Cabinet</option>
          <option value="beds_item">Bed</option>
        </select>

        <label for="item-name">Item Name</label>
        <input type="text" id="item-name" name="item_name" placeholder="Enter item name" required>

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required min="1">

        <div class="button-container">
          <button type="submit" class="save-button" id="saveButton">
            Save
            <span id="loadingSpinner" class="loading-spinner" style="display: none;"></span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.querySelector("form").addEventListener("submit", function(e) {
      const saveButton = document.getElementById('saveButton');
      const loadingSpinner = document.getElementById('loadingSpinner');

      saveButton.disabled = true;
      loadingSpinner.style.display = 'inline-block';
    });
  </script>
</body>
</html>

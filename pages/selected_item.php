<?php
session_start();
include '../includes/sidebar.php';
if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
  exit();
}

require_once '../assets/backends/selected_item_process.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/selected_item.css">
  <title>Stock Tracker Inventory System</title>
</head>
<body>
  <h1 class="qw">ITEM DETAILS</h1>
  <div class="boxitem">
    <div class="product-card">
            <?php
            $has_image = !empty($item['image']);
            if ($has_image) {
              $img_path = '../assets/uploads/' . $item['image'];
              echo '<img src="' . htmlspecialchars($img_path) . '" alt="Item Image" class="product-img">';
            } else {
              echo '<img src="../assets/img/box.png" alt="No Image" class="product-img" style="opacity:0.5">';
              echo '<div style="color:red; text-align:center; font-size:14px;">No image available for this item.</div>';
            }
            ?>
      <h2 class="product-name"><?php echo htmlspecialchars($item['item_name']); ?></h2>
      <div class="priceasile">
        <div class="pa">Price</div>
        <div class="pa">Quantity</div>
        <div class="pa">Aisle</div>
      </div>
      <div class="product-details">
        <div class="detail"><strong>₱<?php echo htmlspecialchars($item['price']); ?></strong></div>
        <div class="detail"><?php echo htmlspecialchars($item['quantity']); ?></div>
        <div class="detail"><?php echo htmlspecialchars($item['aisle_number']); ?></div>
      </div>
      <?php if ($_SESSION['role'] === 'manager'): ?>
        <form action="edit_item.php" method="get" style="margin-top:20px;">
          <input type="hidden" name="table" value="<?php echo htmlspecialchars($_GET['table']); ?>">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
          <button type="submit" style="background:#4880c9; color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer;">✏️ Edit Item</button>
        </form>
      <?php else: ?>
        <form action="../assets/backends/add_to_cart_process.php" method="post" style="margin-top:20px;">
          <input type="hidden" name="table" value="<?php echo htmlspecialchars($_GET['table']); ?>">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
          <label for="qty">Quantity:</label>
          <input type="number" id="qty" name="quantity" min="1" max="<?php echo $item['quantity']; ?>" value="1" required>
          <button type="submit" style="background:#4880c9; color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer;">➕ Add to Cart</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>

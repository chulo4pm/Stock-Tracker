<?php
session_start();
require_once '../config.php';
include '../includes/sidebar.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
  exit();
}

$email = $_SESSION['email'];
$message = "";

// Handle status messages
if (isset($_GET['status'])) {
  if ($_GET['status'] == 'added') {
    $message = "✅ Item added to cart successfully!";
  } elseif ($_GET['status'] == 'removed') {
    $message = "🗑 Item removed from your cart.";
  } elseif ($_GET['status'] == 'bought') {
    $message = "💸 Purchase completed successfully!";
  }
}

// Fetch user cart
$query = $conn->prepare("SELECT * FROM cart WHERE user_email=?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/cart.css">
</head>
<body>
  <div class="cart-container">
    <div class="cart-header">
      <h1>🛒 My Cart</h1>
      <a href="inventory.php" class="back-button">Back to Inventory</a>
    </div>

    <?php if (!empty($message)): ?>
      <div class="message-popup" id="popupMessage">
        <?php echo htmlspecialchars($message); ?>
      </div>
      <script>
        setTimeout(() => {
          const popup = document.getElementById("popupMessage");
          if (popup) popup.style.opacity = "0";
        }, 3000);
      </script>
    <?php endif; ?>

    <?php
    if ($result->num_rows == 0) {
      echo '<div class="empty-cart">Your cart is empty.</div>';
    } else {
      echo '<form id="cartForm" action="../assets/backends/buy_process.php" method="post">';
      echo '<table class="cart-table">';
      echo '<thead><tr><th>Item Name</th><th>Quantity</th><th>Price</th><th>Total</th><th>Action</th></tr></thead><tbody>';

      $grand_total = 0;
      while ($row = $result->fetch_assoc()) {
        $cart_id = $row['id']; // ✅ Primary key from cart table
        $table = $row['item_table'];
        $item_id = $row['item_id'];
        $qty = $row['quantity'];

        $item = $conn->query("SELECT item_name, price FROM $table WHERE id=$item_id")->fetch_assoc();

        if ($item) {
          $total = $item['price'] * $qty;
          $grand_total += $total;
          echo "<tr>
                  <td>" . htmlspecialchars($item['item_name']) . "</td>
                  <td>{$qty}</td>
                  <td>₱" . number_format($item['price'], 2) . "</td>
                  <td>₱" . number_format($total, 2) . "</td>
                  <td>
                    <a href='../assets/backends/remove_from_cart.php?id={$cart_id}' class='remove-btn'>Remove</a>
                  </td>
                </tr>";
        }
      }

      echo "</tbody></table>";
      echo "<h3 class='total-text'>Total: ₱" . number_format($grand_total, 2) . "</h3>";
      echo '<div class="cart-actions">
              <button type="button" class="buy-button" onclick="openModal()">Buy Items</button>
            </div>';
      echo '</form>';
    }
    ?>
  </div>

  <!-- Confirmation Modal -->
  <div id="buyModal" class="modal">
    <div class="modal-content">
      <h2>Confirm Purchase</h2>
      <p>Are you sure you want to buy all items in your cart?</p>
      <div class="modal-buttons">
        <button class="confirm-btn" onclick="confirmBuy()">Yes</button>
        <button class="cancel-btn" onclick="closeModal()">Cancel</button>
      </div>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById('buyModal').style.display = 'flex';
    }

    function closeModal() {
      document.getElementById('buyModal').style.display = 'none';
    }

    function confirmBuy() {
      document.getElementById('cartForm').submit();
    }

    // Fade-out message after 3 seconds
    setTimeout(() => {
      const msg = document.querySelector('.message-popup');
      if (msg) msg.style.opacity = '0';
    }, 3000);
  </script>
</body>
</html>

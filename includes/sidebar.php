<link rel="stylesheet" href="../assets/css/sidebar.css">

<button class="hamburger" onclick="toggleSidebar()">☰</button>

<div class="sidebar modern-sidebar">
  <div class="logo">
    <h2>Stock Tracker</h2>
    <?php if (isset($_SESSION['role'])): ?>
      <span class="sidebar-role">Role: <?= ucfirst($_SESSION['role']) ?></span>
    <?php endif; ?>
  </div>
  <div class="sidebar-section">
    <?php
      $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'manager'): ?>
  <a href="../pages/dashboard.php" class="nav-link <?php if($current_page == 'dashboard.php') echo 'active'; ?>">Dashboard</a>
  <a href="../pages/staff_list.php" class="nav-link <?php if($current_page == 'staff_list.php') echo 'active'; ?>">Staff List</a>
  <a href="../pages/inventory.php" class="nav-link <?php if($current_page == 'inventory.php') echo 'active'; ?>">Inventory</a>
  <a href="../pages/restockitem.php" class="nav-link <?php if($current_page == 'restockitem.php') echo 'active'; ?>">Restock Item</a>
  <a href="../pages/transactions.php" class="nav-link <?php if($current_page == 'transactions.php') echo 'active'; ?>">Transactions</a>
  <a href="../auth/create.php" class="nav-link <?php if($current_page == 'create.php') echo 'active'; ?>">Create Account</a>
  <a href="../pages/user.php" class="nav-link <?php if($current_page == 'user.php') echo 'active'; ?>">User</a>
    <?php else: ?>
  <a href="../pages/inventory.php" class="nav-link <?php if($current_page == 'inventory.php') echo 'active'; ?>">Inventory</a>
  <a href="../pages/user.php" class="nav-link <?php if($current_page == 'user.php') echo 'active'; ?>">User</a>
    <?php endif; ?>
  </div>
</div>
<script>
function toggleSidebar() {
  document.querySelector('.sidebar').classList.toggle('show');
}
</script>

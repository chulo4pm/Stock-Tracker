<?php
session_start();
include '../includes/sidebar.php';
require_once '../config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'manager') {
  header("Location: ../login.php");
  exit();
}

$result = $conn->query("SELECT id, name, email, role FROM users WHERE role = 'staff'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff List | Stock Tracker</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .staff-list-container { max-width: 700px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); padding: 30px; }
    .staff-list-title { font-size: 28px; font-weight: 600; margin-bottom: 20px; text-align: center; }
    .staff-table { width: 100%; border-collapse: collapse; }
    .staff-table th, .staff-table td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; }
    .staff-table th { background: #4880c9; color: #fff; }
    .staff-table tr:hover { background: #f4f6f8; }
    .no-staff { text-align: center; color: #888; margin-top: 20px; }
  </style>
</head>
<body>
  <div class="staff-list-container">
    <div class="staff-list-title">Staff Accounts</div>
    <table class="staff-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Role</th></tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['role']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="3" class="no-staff">No staff accounts found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

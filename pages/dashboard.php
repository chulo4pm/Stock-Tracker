<?php
session_start();
include '../includes/sidebar.php';
require_once '../config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
  exit();
}

// ==== COMPUTE TOTAL SALES THIS MONTH ====
$sales_query = $conn->query("
  SELECT SUM(total) AS total_sales
  FROM sales_history
  WHERE MONTH(date_purchased) = MONTH(CURRENT_DATE())
  AND YEAR(date_purchased) = YEAR(CURRENT_DATE())
");

$total_sales = 0;
if ($sales_query && $sales_query->num_rows > 0) {
  $total_sales = $sales_query->fetch_assoc()['total_sales'] ?? 0;
}

// ==== GET MOST RECENTLY RESTOCKED ITEM (optional) ====
$recent_item = "No recent restock";
$recent_query = $conn->query("
  SELECT item_name FROM (
    SELECT item_name, date_created FROM tables_item
    UNION ALL
    SELECT item_name, date_created FROM chairs_item
    UNION ALL
    SELECT item_name, date_created FROM cabinets_item
    UNION ALL
    SELECT item_name, date_created FROM beds_item
  ) AS all_items
  ORDER BY date_created DESC LIMIT 1
");
if ($recent_query && $recent_query->num_rows > 0) {
  $recent_item = $recent_query->fetch_assoc()['item_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Stock Tracker Inventory System</title>
</head>
<body>
 <div class="main">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
    <div class="summary">
      <div class="summary-box">
        <h3><?php echo htmlspecialchars($recent_item); ?></h3>
        <p>Recently Restocked</p>
      </div>
      <div class="summary-box">
        <h3>₱<?php echo number_format($total_sales, 2); ?></h3>
        <p>Total Sales This Month</p>
      </div>
    </div>

    <div class="table-section">
      <div class="table-header">
        <h4>Low In Stocks</h4>
      </div>
      <table>
        <thead>
          <tr class="iq">
            <th>Item name</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $low_stock_query = "
            SELECT item_name, quantity FROM (
              SELECT item_name, quantity FROM tables_item
              UNION ALL
              SELECT item_name, quantity FROM chairs_item
              UNION ALL
              SELECT item_name, quantity FROM cabinets_item
              UNION ALL
              SELECT item_name, quantity FROM beds_item
            ) AS all_items
            WHERE quantity <= 5
          ";
          $result = $conn->query($low_stock_query);
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr><td>{$row['item_name']}</td><td>{$row['quantity']}</td></tr>";
            }
          } else {
            echo "<tr><td colspan='2'>No low stock items</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

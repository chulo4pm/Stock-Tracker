<?php
// Copy this file to config.php and fill in your own values.
// Values can also come from environment variables (handy for hosting/Docker).
$host     = getenv('DB_HOST') ?: 'localhost';
$user     = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$database = getenv('DB_NAME') ?: 'stock_tracker';
$port     = (int)(getenv('DB_PORT') ?: 3306); // XAMPP is often 3306; change if yours differs

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

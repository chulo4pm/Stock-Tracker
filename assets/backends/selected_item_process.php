<?php
require_once '../config.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = intval($_GET['id']);

    $valid_tables = ['tables_item', 'chairs_item', 'cabinets_item', 'beds_item'];
    if (!in_array($table, $valid_tables)) {
        die("Invalid table name");
    }

    $stmt = $conn->prepare("SELECT *, mime_type FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $item = $result->fetch_assoc();
    } else {
        die("Item not found.");
    }

    $stmt->close();
} else {
    die("Invalid request.");
}
?>

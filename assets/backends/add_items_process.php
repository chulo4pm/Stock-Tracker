<?php
session_start();
require_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['selected_item'];
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $aisle_number = $_POST['aisle_number'];
    $mime_type = mime_content_type($_FILES['item_image']['tmp_name']);
    $upload_dir = '../../assets/uploads/';
    $ext = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('item_', true) . '.' . $ext;
    $target_path = $upload_dir . $filename;
    if (!move_uploaded_file($_FILES['item_image']['tmp_name'], $target_path)) {
        die("Failed to upload image.");
    }

    switch ($role) {
        case 'table':
            $table_name = 'tables_item';
            break;
        case 'chair':
            $table_name = 'chairs_item';
            break;
        case 'cabinet':
            $table_name = 'cabinets_item';
            break;
        case 'bed':
            $table_name = 'beds_item';
            break;
        default:
            die("Invalid item type.");
    }

    $stmt = $conn->prepare("INSERT INTO $table_name (item_name, price, quantity, aisle_number, image, mime_type) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sdisss", $item_name, $price, $quantity, $aisle_number, $filename, $mime_type);

    if ($stmt->execute()) {
        header("Location: ../../pages/inventory.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

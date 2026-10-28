<?php
session_start();
require_once '../config.php';

if (isset($_POST['register'])) {
    $name = $_POST['fullname'];
    $email = $_POST['user'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered.';
        header("Location: ../login.php");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ssss", $name, $email, $hashed, $role);
    $stmt->execute();

    $_SESSION['register_success'] = 'Account created successfully. You can log in now.';
    header("Location: ../login.php");
    exit();
}
?>

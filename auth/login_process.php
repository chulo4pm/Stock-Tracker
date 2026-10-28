<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $stored = $user['password'];
        $ok = password_verify($password, $stored);

        // Legacy accounts with plain-text passwords: accept once, then upgrade to a hash
        if (!$ok && hash_equals($stored, $password)) {
            $ok = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $up->bind_param("si", $newHash, $user['id']);
            $up->execute();
        }

        if ($ok) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'staff') {
                header("Location: ../pages/inventory.php");
            } else {
                header("Location: ../pages/dashboard.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = 'Incorrect password.';
        }
    } else {
        $_SESSION['login_error'] = 'Email not found.';
    }

    header("Location: ../login.php");
    exit();
}
?>

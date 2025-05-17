<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = "All password fields are required.";
        header("Location: user.php");
        exit;
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "New password and confirmation do not match.";
        header("Location: user.php");
        exit;
    }

    if (strlen($new_password) < 6) {
        $_SESSION['error'] = "New password must be at least 6 characters long.";
        header("Location: user.php");
        exit;
    }

    $sql = "SELECT password_hash FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: user.php");
        exit;
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "User not found.";
        $stmt->close();
        header("Location: user.php");
        exit;
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($old_password, $user['password_hash'])) {
        $_SESSION['error'] = "Old password is incorrect.";
        header("Location: user.php");
        exit;
    }
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $update_sql = "UPDATE users SET password_hash = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    if (!$update_stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header("Location: user.php");
        exit;
    }

    $update_stmt->bind_param("si", $new_password_hash, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Password updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update password.";
    }

    $update_stmt->close();
    header("Location: user.php");
    exit;
}

header("Location: user.php");
exit;

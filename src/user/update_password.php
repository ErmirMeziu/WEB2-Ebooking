<?php
session_start();
header('Content-Type: application/json');

include '../db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$sql = "SELECT password_hash FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($old_password, $user['password_hash'])) {
    echo json_encode(['status' => 'error', 'message' => 'Old password is incorrect.']);
    exit;
}

if ($new_password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'New password and confirm password do not match.']);
    exit;
}

if (strlen($new_password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'New password must be at least 8 characters.']);
    exit;
}

if ($old_password === $new_password) {
    echo json_encode(['status' => 'error', 'message' => 'New password cannot be the same as the old password.']);
    exit;
}

$new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

$sql_update = "UPDATE users SET password_hash = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $new_password_hashed, $user_id);

if ($stmt_update->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error updating password: ' . $stmt_update->error]);
}

$stmt_update->close();
$conn->close();
exit;
?>
<?php
session_start();
include '../db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    $_SESSION['msg'] = "User not logged in.";
    header("Location: user.php");
    exit;
}

$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$phone = $_POST['phone'] ?? '';
$birthdate = $_POST['birthdate'] ?? null;
$gender = $_POST['gender'] ?? '';
$bio = $_POST['bio'] ?? '';

if (!$name || !$surname || !$gender) {
    $_SESSION['msg'] = "Name, surname, and gender are required.";
    header("Location: user.php");
    exit;
}

$sql = "UPDATE users SET name = ?, surname = ?, phone = ?, birthdate = ?, gender = ?, bio = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['msg'] = "Prepare failed: " . $conn->error;
    header("Location: user.php");
    exit;
}

$stmt->bind_param("ssssssi", $name, $surname, $phone, $birthdate, $gender, $bio, $user_id);

if ($stmt->execute()) {
    $_SESSION['msg'] = "Profile updated successfully!";
} else {
    $_SESSION['msg'] = "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: user.php");
exit;

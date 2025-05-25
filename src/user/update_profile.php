<?php
session_start();
header('Content-Type: application/json');
include '../db.php';

$response = [];

function setResponseMessage(&$response, $status, $message)
{
    $response['status'] = $status;
    $response['message'] = $message;
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    setResponseMessage($response, 'error', 'User not logged in.');
    echo json_encode($response);
    exit;
}

$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$phone = $_POST['phone'] ?? '';
$birthdate = $_POST['birthdate'] ?? null;
$gender = $_POST['gender'] ?? '';
$bio = $_POST['bio'] ?? '';

if (!$name || !$surname || !$gender) {
    setResponseMessage($response, 'error', 'Name, surname, and gender are required.');
    echo json_encode($response);
    exit;
}

$sql = "UPDATE users SET name = ?, surname = ?, phone = ?, birthdate = ?, gender = ?, bio = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    setResponseMessage($response, 'error', 'Prepare failed: ' . $conn->error);
    echo json_encode($response);
    exit;
}

$stmt->bind_param("ssssssi", $name, $surname, $phone, $birthdate, $gender, $bio, $user_id);

if ($stmt->execute()) {
    $_SESSION['user_name'] = $name;
    setResponseMessage($response, 'success', 'Profile updated successfully!');
} else {
    setResponseMessage($response, 'error', 'Error updating profile: ' . $stmt->error);
}

$stmt->close();
$conn->close();

echo json_encode($response);
exit;
?>
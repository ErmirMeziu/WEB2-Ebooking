<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin']) {
    die("Access denied");
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);
$action = $_GET['action'];

$stmt = $conn->prepare("UPDATE site_reviews SET status = ? WHERE id = ?");
if (!$stmt) {
    header("Location: admin_reviews.php?error=" . urlencode("Error preparing statement: " . $conn->error));
    exit;
}

$status = $action === 'approve' ? 'approved' : ($action === 'unapprove' ? 'pending' : 'deleted');
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: user.php?section=reviews");
} else {
    header("Location: user.php?section=reviews");
}

$stmt->close();
$conn->close();
exit;
?>
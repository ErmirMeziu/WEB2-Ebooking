<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to leave a review.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_SESSION['user_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5.']);
        exit;
    }
    if (empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Comment cannot be empty.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO site_reviews (user_id, rating, comment, status) VALUES (?, ?, ?, 'pending')");///Insertimi, Fshirja, Update-imi i DB nga PHP
    if (!$stmt) {
        error_log("Database prepare failed: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error occurred.']);
        exit;
    }
    $stmt->bind_param("iis", $user_id, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully!']);
    } else {
        error_log("Failed to submit review: " . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Failed to submit review.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
exit;
?>
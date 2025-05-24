<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to leave a review.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $rating = floatval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5 || empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Invalid rating or comment.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO site_reviews (user_id, rating, comment, status) VALUES (?, ?, ?, 'pending')");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Database prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("ids", $user_id, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit review: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

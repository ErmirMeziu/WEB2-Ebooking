<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputEmail = trim($_POST['login_email'] ?? '');
    $password = $_POST['login_password'] ?? '';

    if (empty($inputEmail) || empty($password)) {
        $response['message'] = "Please fill in both email and password.";
    } elseif (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $response['message'] = "Password must be at least 8 characters long.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $inputEmail);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $inputEmail;

                $_SESSION['is_admin'] = str_ends_with(strtolower($inputEmail), '@admin.com');

                $response['success'] = true;
                $response['message'] = "Login successful.";
            } else {
                $response['message'] = "Incorrect email or password.";
            }
        } else {
            $response['message'] = "Incorrect email or password.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
exit;

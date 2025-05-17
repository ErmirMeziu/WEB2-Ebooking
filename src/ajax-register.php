<?php
include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php');

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST['register_name'], $_POST['register_surname'], $_POST['register_email'], $_POST['register_phoneNumber'], $_POST['register_password'], $_POST['confirm_password'])
) {
    $name = trim($_POST['register_name']);
    $surname = trim($_POST['register_surname']);
    $email = trim($_POST['register_email']);
    $phone = trim($_POST['register_phoneNumber']);
    $password = $_POST['register_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($name) || empty($surname) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        $response['message'] = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $response['message'] = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirmPassword) {
        $response['message'] = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response['message'] = "Email is already registered.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, surname, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)");
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssss", $name, $surname, $email, $phone, $passwordHash);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Registration successful!";
            } else {
                $response['message'] = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
    $conn->close();
} else {
    $response['message'] = "Invalid request.";
}

echo json_encode($response);
exit;

?>
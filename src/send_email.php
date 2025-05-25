<?php
// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$name = $email = $message = '';
$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'user-message', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If no errors, proceed to send email
    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->SMTPDebug = 0; // Disable debugging for production
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'meziuermir@gmail.com'; // SMTP username for sending emails
            $mail->Password = 'rwrw oqwc zosh tbsv'; // SMTP App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('travelgeotrip@gmail.com'); // Recipient email for form submissions

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Contact Form Submission from ' . $name;
            $mail->Body = '<h3>Contact Form Submission</h3>' .
                          '<p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>' .
                          '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>' .
                          '<p><strong>Message:</strong> ' . nl2br(htmlspecialchars($message)) . '</p>';
            $mail->AltBody = "Name: $name\nEmail: $email\nMessage: $message";

            $mail->send();
            $success = "Your message has been sent successfully!";
        } catch (Exception $e) {
            $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

// Output JavaScript for alert and redirect
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>
<body>
    <script>
        <?php if (!empty($success)): ?>
            alert("<?php echo addslashes($success); ?>");
            window.location.href = "/WEB2-Ebooking/src/AboutUs.php";
        <?php elseif (!empty($errors)): ?>
            alert("<?php echo addslashes(implode('\n', $errors)); ?>");
            window.location.href = "/WEB2-Ebooking/src/AboutUs.php";
        <?php else: ?>
            window.location.href = "/WEB2-Ebooking/src/AboutUs.php";
        <?php endif; ?>
    </script>
</body>
</html>

<!--
Email : travelgeotrip@gmail.com 
Psw: geotrip123.
-->
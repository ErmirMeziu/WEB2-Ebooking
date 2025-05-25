<?php
// Manual requires for PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$name = $email = $message = '';
$errors = [];
$log_errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Log form submission to a file
    if (empty($errors)) {
        $log_dir = $_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/logs/';
        $log_file = $log_dir . 'contact_form.log';
        $log_data = date('Y-m-d H:i:s') . " | Name: $name | Email: $email | Message: $message\n";

        // Create the logs directory if it doesn't exist
        if (!is_dir($log_dir)) {
            if (!mkdir($log_dir, 0755, true)) {
                $log_errors[] = "Unable to create logs directory.";
            }
        }

        // Check log file size
        $max_size = 1048576; // 1MB limit
        if (file_exists($log_file) && filesize($log_file) > $max_size) {
            $log_errors[] = "Log file is too large. Please contact support.";
        }

        // Attempt to log the submission
        if (empty($log_errors)) {
            $file = @fopen($log_file, 'a');
            if ($file === false) {
                $error = error_get_last();
                $log_errors[] = "Unable to log form submission. Error: " . ($error['message'] ?? 'Unknown error');
            } else {
                fwrite($file, $log_data);
                fclose($file);
            }
        }
    }

    // Proceed with email sending if validation passes
    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'meziuermir@gmail.com';
            $mail->Password = 'rwrw oqwc zosh tbsv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress('travelgeotrip@gmail.com');

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
        <?php elseif (!empty($log_errors)): ?>
            alert("<?php echo addslashes(implode('\n', $log_errors)); ?>");
            window.location.href = "/WEB2-Ebooking/src/AboutUs.php";
        <?php else: ?>
            window.location.href = "/WEB2-Ebooking/src/AboutUs.php";
        <?php endif; ?>
    </script>
</body>
</html>
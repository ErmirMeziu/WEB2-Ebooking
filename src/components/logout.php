<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];

session_destroy();

header("Location: /WEB2-Ebooking/src/index.php");
exit;
?>
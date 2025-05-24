<?php
    session_start();
    require_once '../db.php';

    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        die("Access denied.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_id'])) {
        $car_id = intval($_POST['car_id']);
        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
            $stmt->bind_param("i", $car_id);
            $stmt->execute();
            $conn->commit();
            header("Location: /WEB2-Ebooking/src/Cars-Page/cars.php");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            die("Error deleting car: " . $e->getMessage());
        }
    } else {
        die("Invalid request.");
    }
?>
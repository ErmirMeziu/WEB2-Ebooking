<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Book Car</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/carspage.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .booking-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .booking-container h1 {
            color: #393939;
            text-align: left;
            margin-bottom: 20px;
        }
        .car-images-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .car-image-large {
            flex: 2;
            height: 300px;
            background-size: cover;
            background-position: center;
            border-radius: 5px;
            background-color: #f0f0f0; 
        }
        .car-image-small-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .car-image-small {
            height: 140px;
            background-size: cover;
            background-position: center;
            border-radius: 5px;
            background-color: #f0f0f0; 
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #393939;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .price-details {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .price-details p {
            margin: 5px 0;
            color: #393939;
        }
        .btn-confirm {
            width: 100%;
            padding: 12px;
            background-color: #d72c21;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-confirm:hover {
            background-color: #b5241a;
        }
        .error {
            color: #d72c21;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        require_once __DIR__ . '/carclass.php';
        require_once '../db.php';

        $carid = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $stmt = $conn->prepare("SELECT c.name, c.type, c.price, ci.imgurl 
                                FROM cars c 
                                LEFT JOIN carimages ci ON c.id = ci.carid 
                                WHERE c.id = ? 
                                ORDER BY ci.id ASC LIMIT 3");
        $stmt->bind_param("i", $carid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            die("Car not found.");
        }
        $carData = $result->fetch_assoc();

        $images = [];
        $images[] = $carData['imgurl'];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['imgurl'];
        }
        $image_url = $images[0];
        $car = new CarDetails(
            $carid,
            $carData['name'],
            $carData['price'],
            $images, 
            0,       
            0,       
            [],      
            []       
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                echo "<script>alert('Please log in to book a car.'); window.location.href = 'cardetails.php?id=$carid';</script>";
                exit;
            }
            $user_id = $_SESSION['user_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $today = date('Y-m-d');
            if ($start_date < $today || $end_date < $start_date) {
                $error = "Invalid date selection!";
            } else {
                $stmt = $conn->prepare("SELECT * FROM car_rentals WHERE car_id = ? AND (rental_start <= ? AND rental_end >= ?)");
                $stmt->bind_param("iss", $carid, $end_date, $start_date);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $error = "This car is already booked for the selected dates.";
                } else {
                    $start = new DateTime($start_date);
                    $end = new DateTime($end_date);
                    $interval = $start->diff($end);
                    $days = $interval->days + 1;
                    $total_price = $days * $carData['price'];
                    
                    $stmt = $conn->prepare("INSERT INTO car_rentals (user_id, car_id, rental_start, rental_end, image, total_price) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("iisssd", $user_id, $carid, $start_date, $end_date, $image_url, $total_price);
                    if ($stmt->execute()) {
                        echo "<script>alert('Car booked successfully! Total price: €" . number_format($total_price, 2) . "'); window.location.href = 'cardetails.php?id=$carid';</script>";
                    } else {
                        $error = "Error booking the car: " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        }
        $stmt->close();
        ?>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <section class="booking-container">
        <h1>Book <?= htmlspecialchars($car->getname()) ?></h1>
        <div class="car-images-container">
            <div class="car-image-large" style="background-image: url('<?php echo htmlspecialchars($images[0]); ?>');"></div>
            <div class="car-image-small-container">
                <div class="car-image-small" style="background-image: url('<?php echo htmlspecialchars($images[1]); ?>');"></div>
                <div class="car-image-small" style="background-image: url('<?php echo htmlspecialchars($images[2]); ?>');"></div>
            </div>
        </div>
        <form method="POST" action="">
            <div class="form-group">
                <label for="start_date">Rental Start Date</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">Rental End Date</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <div class="price-details">
                <p><strong>Type:</strong> <?= htmlspecialchars($carData['type'] ?? 'Unknown') ?></p>
                <p><strong>Price per Day:</strong> €<span id="pricePerDay"><?= number_format($carData['price'], 2) ?></span></p>
                <p><strong>Total Price:</strong> €<span id="totalPrice">0</span></p>
            </div>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <button type="submit" class="btn-confirm">Rent the Car</button>
        </form>
    </section>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalPriceSpan = document.getElementById('totalPrice');
        const pricePerDay = parseFloat(document.getElementById('pricePerDay').textContent);

        function calculateTotalPrice() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            if (startDate && endDate && endDate >= startDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
                const total = diffDays * pricePerDay;
                totalPriceSpan.textContent = total.toFixed(2);
            } else {
                totalPriceSpan.textContent = '0';
            }
        }

        startDateInput.addEventListener('change', calculateTotalPrice);
        endDateInput.addEventListener('change', calculateTotalPrice);
        const today = new Date('2025-05-24').toISOString().split('T')[0];
        startDateInput.setAttribute('min', today);
        endDateInput.setAttribute('min', today);
    </script>
</body>
</html>
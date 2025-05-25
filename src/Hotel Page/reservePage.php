<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Book Hotel</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/carspage.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/login-register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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

        .hotel-images-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .hotel-image-large {
            flex: 2;
            height: 300px;
            background-size: cover;
            background-position: center;
            border-radius: 5px;
            background-color: #f0f0f0;
        }

        .hotel-image-small-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .hotel-image-small {
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

        .form-group input,
        .form-group select {
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
    require_once '../db.php';

    $hotel_id = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 0;

    if ($hotel_id <= 0) {
        header("Location: /WEB2-Ebooking/src/Hotel Page/hotels.php?error=" . urlencode("Invalid hotel ID."));
        exit;
    }

    $stmt = $conn->prepare("
        SELECT h.name, h.overall_rating
        FROM hotels h
        WHERE h.id = ?
    ");
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        header("Location: /WEB2-Ebooking/src/Hotel Page/hotels.php?error=" . urlencode("Hotel not found."));
        exit;
    }
    $hotelData = $result->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("
        SELECT imgurl
        FROM hotel_images
        WHERE hotel_id = ?
        ORDER BY is_main DESC, id ASC
        LIMIT 3
    ");
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['imgurl'];
    }
    $stmt->close();
    while (count($images) < 3) {
        $images[] = '/WEB2-Ebooking/src/images/placeholder.jpg';
    }

    $stmt = $conn->prepare("
        SELECT id, room_type, price
        FROM rooms
        WHERE hotel_id = ?
    ");
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    $stmt->close();
    if (empty($rooms)) {
        header("Location: /WEB2-Ebooking/src/Hotel Page/hotels.php?error=" . urlencode("No rooms available for this hotel."));
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Please log in to book a hotel.'); window.location.href = '/WEB2-Ebooking/src/Hotel Page/hotels.php';</script>";
            exit;
        }
        $user_id = $_SESSION['user_id'];
        $room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
        $check_in = $_POST['check_in'] ?? '';
        $check_out = $_POST['check_out'] ?? '';

        $room_valid = false;
        $room_price = 0;
        foreach ($rooms as $room) {
            if ($room['id'] === $room_id) {
                $room_valid = true;
                $room_price = $room['price'];
                break;
            }
        }
        if (!$room_valid) {
            $error = "Invalid room selection!";
        } else {
            $today = date('Y-m-d');
            if ($check_in < $today || $check_out <= $check_in) {
                $error = "Invalid date selection!";
            } else {
                $stmt = $conn->prepare("
                    SELECT *
                    FROM hotel_bookings
                    WHERE hotel_id = ? AND (
                        (check_in <= ? AND check_out >= ?) OR
                        (check_in <= ? AND check_out >= ?) OR
                        (check_in >= ? AND check_out <= ?)
                    )
                ");
                $stmt->bind_param("issssss", $hotel_id, $check_out, $check_in, $check_out, $check_in, $check_in, $check_out);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $error = "This hotel is already booked for the selected dates.";
                } else {
                    $start = new DateTime($check_in);
                    $end = new DateTime($check_out);
                    $interval = $start->diff($end);
                    $days = $interval->days;
                    if ($days == 0)
                        $days = 1;
                    $total_price = $days * $room_price;

                    $stmt = $conn->prepare("
                        INSERT INTO hotel_bookings (user_id, hotel_id, check_in, check_out, total_price, rooms)
                        VALUES (?, ?, ?, ?, ?, 1)
                    ");
                    $stmt->bind_param("iissd", $user_id, $hotel_id, $check_in, $check_out, $total_price);
                    if ($stmt->execute()) {
                        echo "<script>alert('Hotel booked successfully! Total price: S\$" . number_format($total_price, 2) . "'); window.location.href = '/WEB2-Ebooking/src/Hotel Page/hotels.php';</script>";
                    } else {
                        $error = "Error booking the hotel: " . $stmt->error;
                    }
                }
                $stmt->close();
            }
        }
    }
    ?>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <section id="all">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/login.php'); ?>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/register.php'); ?>
        <script>
            setTimeout(() => {
                const script = document.createElement('script');
                script.src = '/WEB2-Ebooking/src/script/login-register.js';
                document.body.appendChild(script);
            }, 500);
        </script>
    </section>

    <section class="booking-container">
        <h1>Book <?= htmlspecialchars($hotelData['name']) ?></h1>
        <div class="hotel-images-container">
            <div class="hotel-image-large" style="background-image: url('<?= htmlspecialchars($images[0]) ?>');"></div>
            <div class="hotel-image-small-container">
                <div class="hotel-image-small" style="background-image: url('<?= htmlspecialchars($images[1]) ?>');">
                </div>
                <div class="hotel-image-small" style="background-image: url('<?= htmlspecialchars($images[2]) ?>');">
                </div>
            </div>
        </div>
        <form method="POST" action="">
            <div class="form-group">
                <label for="room_id">Room Type</label>
                <select id="room_id" name="room_id" required>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['id'] ?>" data-price="<?= $room['price'] ?>">
                            <?= htmlspecialchars($room['room_type']) ?> ($<?= number_format($room['price'], 2) ?> per
                            night)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="check_in">Check-in Date</label>
                <input type="date" id="check_in" name="check_in" required>
            </div>
            <div class="form-group">
                <label for="check_out">Check-out Date</label>
                <input type="date" id="check_out" name="check_out" required>
            </div>
            <div class="price-details">
                <p><strong>Rating:</strong> <?= htmlspecialchars($hotelData['overall_rating'] ?? 'N/A') ?></p>
                <p><strong>Price per Night:</strong> $<span
                        id="pricePerNight"><?= number_format($rooms[0]['price'], 2) ?></span></p>
                <p><strong>Total Price:</strong> $<span id="totalPrice">0</span></p>
            </div>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <button type="submit" class="btn-confirm">Book the Hotel</button>
        </form>
    </section>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

    <script>
        const roomSelect = document.getElementById('room_id');
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalPriceSpan = document.getElementById('totalPrice');
        const pricePerNightSpan = document.getElementById('pricePerNight');

        function calculateTotalPrice() {
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const pricePerNight = parseFloat(selectedOption.dataset.price);
            pricePerNightSpan.textContent = pricePerNight.toFixed(2);

            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            if (checkIn && checkOut && checkOut > checkIn) {
                const diffTime = Math.abs(checkOut - checkIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const total = diffDays * pricePerNight;
                totalPriceSpan.textContent = total.toFixed(2);
            } else {
                totalPriceSpan.textContent = '0';
            }
        }

        roomSelect.addEventListener('change', calculateTotalPrice);
        checkInInput.addEventListener('change', calculateTotalPrice);
        checkOutInput.addEventListener('change', calculateTotalPrice);

        const today = new Date().toISOString().split('T')[0];
        checkInInput.setAttribute('min', today);
        checkOutInput.setAttribute('min', today);
    </script>
</body>

</html>
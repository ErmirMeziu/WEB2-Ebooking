<?php
include '../db.php';
session_start();

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: /login.php');
    exit;
}

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$section = $_GET['section'] ?? 'profile';

$delete_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_rental') {
    $car_id = $_POST['car_id'] ?? null;
    $rental_start = $_POST['rental_start'] ?? null;
    $rental_end = $_POST['rental_end'] ?? null;
    $target_user_id = $_POST['user_id'] ?? $user_id;

    if ($car_id && is_numeric($car_id) && $rental_start && $rental_end && $target_user_id && is_numeric($target_user_id)) {
        if ($is_admin) {
            $sql = "DELETE FROM car_rentals WHERE user_id = ? AND car_id = ? AND rental_start = ? AND rental_end = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                $delete_message = "Error preparing delete query: " . $conn->error;
            } else {
                $stmt->bind_param("iiss", $target_user_id, $car_id, $rental_start, $rental_end);
            }
        } else {
            if ($target_user_id != $user_id) {
                $delete_message = "You don't have permission to delete this rental.";
            } else {
                $sql = "DELETE FROM car_rentals WHERE user_id = ? AND car_id = ? AND rental_start = ? AND rental_end = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $delete_message = "Error preparing delete query: " . $conn->error;
                } else {
                    $stmt->bind_param("iiss", $user_id, $car_id, $rental_start, $rental_end);
                }
            }
        }

        if ($stmt) {
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $delete_message = "Rental removed successfully.";
                }
            } else {
                $delete_message = "Error deleting rental: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Handle review actions (approve/unapprove/delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $is_admin) {
    $review_id = $_POST['review_id'] ?? null;
    if ($review_id && is_numeric($review_id)) {
        if ($_POST['action'] === 'approve_review') {
            $sql = "UPDATE site_reviews SET status = 'approved' WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $review_id);
            if ($stmt->execute()) {
                $delete_message = "Review approved successfully.";
            } else {
                $delete_message = "Error approving review: " . $stmt->error;
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'unapprove_review') {
            $sql = "UPDATE site_reviews SET status = 'pending' WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $review_id);
            if ($stmt->execute()) {
                $delete_message = "Review unapproved successfully.";
            } else {
                $delete_message = "Error unapproving review: " . $stmt->error;
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'delete_review') {
            $sql = "DELETE FROM site_reviews WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $review_id);
            if ($stmt->execute()) {
                $delete_message = "Review deleted successfully.";
            } else {
                $delete_message = "Error deleting review: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Fetch user profile data
$sql = "SELECT name, surname, email, phone, birthdate, gender, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch hotel bookings
$booked_hotels = [];
if ($section === 'hotels') {
    if ($is_admin) {
        $sql = "SELECT hb.id AS booking_id, hb.user_id, h.id AS hotel_id, h.name, h.city, h.country, hb.check_in, hb.check_out, hb.total_price, 
                (SELECT MIN(r.price) FROM rooms r WHERE r.hotel_id = h.id) AS price, 
                h.overall_rating, h.review_count, u.name AS user_name, u.surname AS user_surname
                FROM hotel_bookings hb
                JOIN hotels h ON hb.hotel_id = h.id
                JOIN users u ON hb.user_id = u.id";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "SELECT hb.id AS booking_id, h.id AS hotel_id, h.name, h.city, h.country, hb.check_in, hb.check_out, hb.total_price, 
                (SELECT MIN(r.price) FROM rooms r WHERE r.hotel_id = h.id) AS price, 
                h.overall_rating, h.review_count
                FROM hotel_bookings hb
                JOIN hotels h ON hb.hotel_id = h.id
                WHERE hb.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $booked_hotels[] = $row;
    }
    unset($row);
    unset($result);
    $stmt->close();
    unset($stmt);
}

// Fetch car rentals
$booked_cars = [];
if ($section === 'cars') {
    if ($is_admin) {
        $sql = "SELECT cr.user_id, c.id AS car_id, c.name, c.type, cr.rental_start, cr.rental_end, cr.total_price, c.price, u.name AS user_name, u.surname AS user_surname
                FROM car_rentals cr
                JOIN cars c ON cr.car_id = c.id
                JOIN users u ON cr.user_id = u.id";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "SELECT c.id AS car_id, c.name, c.type, cr.rental_start, cr.rental_end, cr.total_price, c.price
                FROM car_rentals cr
                JOIN cars c ON cr.car_id = c.id
                WHERE cr.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $booked_cars[] = $row;
    }
    unset($row);
    unset($result);

    $stmt->close();
    unset($stmt);
}


//delete hotel booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_booking') {
    $booking_id = $_POST['booking_id'] ?? null;
    $hotel_id = $_POST['hotel_id'] ?? null;
    $check_in = $_POST['check_in'] ?? null;
    $check_out = $_POST['check_out'] ?? null;
    $target_user_id = $_POST['user_id'] ?? $user_id;

    if (!is_numeric($booking_id) || !is_numeric($hotel_id) || !$check_in || !$check_out || !is_numeric($target_user_id)) {
        $delete_message = "Invalid booking details.";
    } elseif (!$is_admin && $target_user_id != $user_id) {
        $delete_message = "Permission denied.";
    } else {
        $sql = "DELETE FROM hotel_bookings WHERE id = ? AND user_id = ? AND hotel_id = ? AND check_in = ? AND check_out = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $delete_message = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("iiiss", $booking_id, $target_user_id, $hotel_id, $check_in, $check_out);
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $delete_message = "Booking removed successfully.";
                header("Location: ?section=hotels");
                exit;
            } else {
                $delete_message = "Booking not found.";
            }
            $stmt->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $is_admin ? 'Admin Dashboard' : 'User Dashboard'; ?></title>
    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/user.css" />
    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/navbar.css" />
    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/footer.css" />
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <style>
        header {
            position: relative !important;
            background-color: #041625 !important;
        }
    </style>
</head>

<body>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <div class="container">
        <div class="nav-panel">
            <div class="nav-panel-header">
                <h2><?php echo $is_admin ? 'Admin Dashboard' : 'User Dashboard'; ?></h2>
            </div>
            <div class="nav-panel-nav">
                <ul>
                    <li><a href="?section=profile" class="<?php echo $section === 'profile' ? 'active' : ''; ?>"><i
                                class="fas fa-user"></i> Profile</a></li>
                    <li><a href="?section=hotels" class="<?php echo $section === 'hotels' ? 'active' : ''; ?>"><i
                                class="fas fa-hotel"></i>
                            <?php echo $is_admin ? 'All Hotel Bookings' : 'Booked Hotels'; ?></a></li>
                    <li><a href="?section=cars" class="<?php echo $section === 'cars' ? 'active' : ''; ?>"><i
                                class="fas fa-car"></i> <?php echo $is_admin ? 'All Car Rentals' : 'Rented Cars'; ?></a>
                    </li>
                    <li><a href="?section=reviews" class="<?php echo $section === 'reviews' ? 'active' : ''; ?>"><i
                                class="fas fa-star"></i> <?php echo $is_admin ? 'All Reviews' : 'My Reviews'; ?></a>
                    </li>
                    <!-- <li><a href="/WEB2-Ebooking/src/components/logout.php"><i class="fas fa-sign-out-alt"></i>
                            Logout</a></li> -->
                </ul>
            </div>
        </div>

        <div class="content">
            <?php if ($delete_message): ?>
                <div
                    class="delete-message <?php echo strpos($delete_message, 'successfully') !== false ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($delete_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($section === 'profile'): ?>
                <div class="card" id="personal-info">
                    <h3>Personal Info</h3>
                    <form method="POST" action="update_profile.php" class="profile-form">
                        <div class="form-grid">
                            <input type="text" name="name" placeholder="First Name"
                                value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required />
                            <input type="text" name="surname" placeholder="Last Name"
                                value="<?php echo htmlspecialchars($user['surname'] ?? ''); ?>" required />
                            <input type="email" name="email" placeholder="Email"
                                value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly />
                            <input type="tel" name="phone" placeholder="Mobile"
                                value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" />
                            <input type="date" name="birthdate"
                                value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>" />
                            <select name="gender" required>
                                <option value="Male" <?php echo ($user['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male
                                </option>
                                <option value="Female" <?php echo ($user['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>
                                    Female</option>
                                <option value="Other" <?php echo ($user['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>
                                    Other</option>
                            </select>
                            <textarea name="bio"
                                placeholder="About you..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-actions">
                            <button class="btn-red" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>

                <div class="card" id="update-password">
                    <h3>Update Password</h3>
                    <form method="POST" action="update_password.php" class="update-password">
                        <input type="password" name="old_password" placeholder="Old Password" required />
                        <input type="password" name="new_password" placeholder="New Password" required />
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                        <div class="form-actions">
                            <button class="btn-red" type="submit">Change Password</button>
                            <span class="message"></span>
                        </div>
                    </form>
                </div>
            <?php elseif ($section === 'hotels'): ?>
                <div class="card" id="booked-hotels">
                    <h3 class="section-title"><?php echo $is_admin ? 'All Hotel Bookings' : 'Booked Hotels'; ?></h3>
                    <?php if (empty($booked_hotels)): ?>
                        <p class="no-rentals">No hotel bookings found.</p>
                    <?php else: ?>
                        <div class="booking-list">
                            <?php
                            include '../db.php';
                            foreach ($booked_hotels as $hotel):
                                $stmt = $conn->prepare("SELECT imgurl FROM hotel_images WHERE hotel_id = ? AND is_main = 1 LIMIT 1");
                                $stmt->bind_param("i", $hotel['hotel_id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $image = $result->fetch_assoc();
                                $stmt->close();

                                $user_phone = '';
                                if ($is_admin && isset($hotel['user_id'])) {
                                    $stmt = $conn->prepare("SELECT phone FROM users WHERE id = ?");
                                    $stmt->bind_param("i", $hotel['user_id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $user = $result->fetch_assoc();
                                    $user_phone = $user['phone'] ?? 'N/A';
                                    $stmt->close();
                                }
                                ?>
                                <div class="booking-item">
                                    <div class="booking-image">
                                        <?php if ($image && !empty($image['imgurl'])): ?>
                                            <img src="<?php echo htmlspecialchars($image['imgurl']); ?>"
                                                alt="<?php echo htmlspecialchars($hotel['name']); ?>">
                                        <?php else: ?>
                                            <img src="/WEB2-Ebooking/src/images/Hotels/placeholder.jpg" alt="No image available">
                                        <?php endif; ?>
                                    </div>
                                    <div class="booking-info">
                                        <h4 class="hotel-name">
                                            <a
                                                href="/WEB2-Ebooking/src/Hotels-page/hoteldetails.php?id=<?php echo $hotel['hotel_id']; ?>">
                                                <?php echo htmlspecialchars($hotel['name']); ?>
                                            </a>
                                        </h4>
                                        <?php if ($is_admin): ?>
                                            <p class="info-item"><span>User:</span>
                                                <?php echo htmlspecialchars($hotel['user_name'] . ' ' . $hotel['user_surname']); ?></p>
                                            <p class="info-item"><span>Phone:</span> <?php echo htmlspecialchars($user_phone); ?></p>
                                        <?php endif; ?>
                                        <p class="info-item"><span>Location:</span>
                                            <?php echo htmlspecialchars($hotel['city'] . ', ' . $hotel['country']); ?></p>
                                        <p class="info-item"><span>Price per night:</span>
                                            <?php echo number_format($hotel['price'], 2); ?>€</p>
                                        <p class="info-item"><span>Booking Period:</span>
                                            <?php echo htmlspecialchars(date('M d, Y', strtotime($hotel['check_in']))); ?> -
                                            <?php echo htmlspecialchars(date('M d, Y', strtotime($hotel['check_out']))); ?>
                                        </p>
                                        <p class="info-item"><span>Total Price:</span>
                                            <?php echo number_format($hotel['total_price'], 2); ?>€</p>
                                    </div>
                                    <div class="remove-btn-container">
                                        <form method="POST" action="?section=hotels"
                                            onsubmit="return confirm('Are you sure you want to remove this booking?');">
                                            <input type="hidden" name="action" value="delete_booking">
                                            <input type="hidden" name="booking_id" value="<?php echo $hotel['booking_id']; ?>">
                                            <?php if ($is_admin): ?>
                                                <input type="hidden" name="user_id" value="<?php echo $hotel['user_id']; ?>">
                                            <?php endif; ?>
                                            <input type="hidden" name="hotel_id" value="<?php echo $hotel['hotel_id']; ?>">
                                            <input type="hidden" name="check_in" value="<?php echo $hotel['check_in']; ?>">
                                            <input type="hidden" name="check_out" value="<?php echo $hotel['check_out']; ?>">
                                            <button type="submit" class="remove-btn">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif ($section === 'cars'): ?>
                <div class="card" id="booked-cars">
                    <h3 class="section-title"><?php echo $is_admin ? 'All Car Rentals' : 'Booked Cars'; ?></h3>
                    <?php if (empty($booked_cars)): ?>
                        <p class="no-rentals">No car rentals found.</p>
                    <?php else: ?>
                        <div class="booking-list">
                            <?php
                            include '../db.php';
                            foreach ($booked_cars as $car):
                                $stmt = $conn->prepare("SELECT imgurl FROM carimages WHERE carid = ? LIMIT 1");
                                $stmt->bind_param("i", $car['car_id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $image = $result->fetch_assoc();
                                $stmt->close();

                                $user_phone = '';
                                if ($is_admin && isset($car['user_id'])) {
                                    $stmt = $conn->prepare("SELECT phone FROM users WHERE id = ?");
                                    $stmt->bind_param("i", $car['user_id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $user = $result->fetch_assoc();
                                    $user_phone = $user['phone'] ?? 'N/A';
                                    $stmt->close();
                                }
                                ?>
                                <div class="booking-item">
                                    <div class="booking-image">
                                        <?php if ($image && !empty($image['imgurl'])): ?>
                                            <img src="<?php echo htmlspecialchars($image['imgurl']); ?>"
                                                alt="<?php echo htmlspecialchars($car['name']); ?>">
                                        <?php else: ?>
                                            <img src="/WEB2-Ebooking/src/images/Cars/placeholder.jpg" alt="No image available">
                                        <?php endif; ?>
                                    </div>
                                    <div class="booking-info">
                                        <h4 class="car-name">
                                            <a href="/WEB2-Ebooking/src/Cars-page/cardetails.php?id=<?php echo $car['car_id']; ?>">
                                                <?php echo htmlspecialchars($car['name']); ?>
                                            </a>
                                        </h4>
                                        <?php if ($is_admin): ?>
                                            <p class="info-item"><span>User:</span>
                                                <?php echo htmlspecialchars($car['user_name'] . ' ' . $car['user_surname']); ?></p>
                                            <p class="info-item"><span>Phone:</span> <?php echo htmlspecialchars($user_phone); ?></p>
                                        <?php endif; ?>
                                        <p class="info-item"><span>Type:</span> <?php echo htmlspecialchars($car['type']); ?></p>
                                        <p class="info-item"><span>Price per day:</span>
                                            <?php echo number_format($car['price'], 2); ?>€</p>
                                        <p class="info-item"><span>Rental Period:</span>
                                            <?php echo htmlspecialchars(date('M d, Y', strtotime($car['rental_start']))); ?> -
                                            <?php echo htmlspecialchars(date('M d, Y', strtotime($car['rental_end']))); ?>
                                        </p>
                                        <p class="info-item"><span>Total Price:</span>
                                            <?php echo number_format($car['total_price'], 2); ?>€</p>
                                    </div>
                                    <div class="remove-btn-container">
                                        <form method="POST" action="?section=cars"
                                            onsubmit="return confirm('Are you sure you want to remove this rental?');">
                                            <input type="hidden" name="action" value="delete_rental">
                                            <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                                            <?php if ($is_admin): ?>
                                                <input type="hidden" name="user_id" value="<?php echo $car['user_id']; ?>">
                                            <?php endif; ?>
                                            <input type="hidden" name="rental_start" value="<?php echo $car['rental_start']; ?>">
                                            <input type="hidden" name="rental_end" value="<?php echo $car['rental_end']; ?>">
                                            <button type="submit" class="remove-btn">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif ($section === 'reviews'): ?>
                <div class="card" id="reviews">
                    <h3><?php echo $is_admin ? 'All Reviews' : 'My Reviews'; ?></h3>
                    <div class="reviews-container">
                        <?php if ($is_admin): ?>
                            <?php
                            $sql = "SELECT sr.id, sr.rating, sr.comment, sr.created_at, sr.status, u.name 
                                    FROM site_reviews sr 
                                    JOIN users u ON sr.user_id = u.id 
                                    ORDER BY sr.created_at DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows === 0) {
                                echo "<p>No reviews found.</p>";
                            } else {
                                while ($row = $result->fetch_assoc()): ?>
                                    <div class="review-card">
                                        <p><strong><?php echo htmlspecialchars($row['name']); ?></strong> rated
                                            <?php echo $row['rating']; ?> ★
                                        </p>
                                        <p><?php echo htmlspecialchars($row['comment']); ?></p>
                                        <p><small><?php echo $row['created_at']; ?></small></p>
                                        <?php if ($row['status'] === 'pending'): ?>
                                            <form method="POST" action="?section=reviews" style="display: inline;">
                                                <input type="hidden" name="action" value="approve_review">
                                                <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="action-approve">Approve</button>
                                            </form>
                                            <form method="POST" action="?section=reviews" style="display: inline;">
                                                <input type="hidden" name="action" value="delete_review">
                                                <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="action-delete"
                                                    onclick="return confirm('Are you sure you want to delete this review?');">Delete</button>
                                            </form>
                                        <?php elseif ($row['status'] === 'approved'): ?>
                                            <form method="POST" action="?section=reviews" style="display: inline;">
                                                <input type="hidden" name="action" value="unapprove_review">
                                                <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="action-unapprove">Unapprove</button>
                                            </form>
                                            <form method="POST" action="?section=reviews" style="display: inline;">
                                                <input type="hidden" name="action" value="delete_review">
                                                <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="action-delete"
                                                    onclick="return confirm('Are you sure you want to delete this review?');">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile;
                            }
                            $stmt->close();
                            ?>
                        <?php else: ?>
                            <?php
                            $stmt = $conn->prepare("SELECT sr.rating, sr.comment, sr.created_at, sr.status
                                                   FROM site_reviews sr
                                                   WHERE sr.user_id = ?
                                                   ORDER BY sr.created_at DESC");
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows === 0) {
                                echo "<p>No reviews found.</p>";
                            } else {
                                while ($row = $result->fetch_assoc()): ?>
                                    <div class="review-card">
                                        <p>You rated <?php echo $row['rating']; ?> ★
                                        </p>
                                        <p><?php echo htmlspecialchars($row['comment']); ?></p>
                                        <p><small><?php echo $row['created_at']; ?></small></p>
                                    </div>
                                <?php endwhile;
                            }
                            $stmt->close();
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
<script>
    document.querySelector('.update-password').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const messageSpan = form.querySelector('.message');

        const old_password = form.old_password.value.trim();
        const new_password = form.new_password.value.trim();
        const confirm_password = form.confirm_password.value.trim();

        if (new_password.length < 8) {
            messageSpan.style.color = 'red';
            messageSpan.textContent = 'New password must be at least 8 characters.';
            return;
        }

        if (new_password !== confirm_password) {
            messageSpan.style.color = 'red';
            messageSpan.textContent = 'New password and confirm password do not match.';
            return;
        }

        if (old_password === new_password) {
            messageSpan.style.color = 'red';
            messageSpan.textContent = 'New password cannot be the same as old password.';
            return;
        }

        const formData = new FormData(form);

        fetch('update_password.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageSpan.style.color = 'green';
                    form.reset();
                } else {
                    messageSpan.style.color = 'red';
                }
                messageSpan.textContent = data.message;
            })
            .catch(err => {
                messageSpan.style.color = 'red';
                messageSpan.textContent = 'Something went wrong. Please try again.';
                console.error(err);
            });
    });


    document.querySelector('.profile-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);


        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                let messageSpan = form.querySelector('.message');
                if (!messageSpan) {
                    messageSpan = document.createElement('span');
                    messageSpan.classList.add('message');
                    messageSpan.style.marginTop = '8px';
                    form.querySelector('.form-actions').appendChild(messageSpan);
                }

                if (data.status === 'success') {
                    messageSpan.style.color = 'green';
                    messageSpan.textContent = 'Profile updated successfully.';
                } else {
                    messageSpan.style.color = 'red';
                    messageSpan.textContent = data.message || 'Update failed. Please try again.';
                }
            })
            .catch(err => {
                let messageSpan = form.querySelector('.message');
                if (!messageSpan) {
                    messageSpan = document.createElement('span');
                    messageSpan.classList.add('message');
                    form.querySelector('.form-actions').appendChild(messageSpan);
                }
                messageSpan.style.color = 'red';
                messageSpan.textContent = 'Something went wrong. Please try again.';
                console.error(err);
            });
    });
</script>
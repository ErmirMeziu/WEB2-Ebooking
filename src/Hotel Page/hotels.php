<?php
session_start();
include '../db.php';

$hotels_per_page = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $hotels_per_page;

$search = isset($_GET['text']) ? trim($_GET['text']) : '';
$checkin = isset($_GET['date']) ? $_GET['date'] : '';
$guests = isset($_GET['number']) ? max(1, intval($_GET['number'])) : 1;
$bed_type = isset($_GET['bed_type']) ? (array) $_GET['bed_type'] : [];
$amenities = isset($_GET['amenities']) ? (array) $_GET['amenities'] : [];
$rating = isset($_GET['rating']) ? floatval($_GET['rating']) : 0;

$error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

$today = date('Y-m-d');
if ($checkin && $checkin < $today) {
    $error_message = "Check-in date cannot be in the past.";
    $checkin = '';
}

$bed_types = [];
$result = $conn->query("SELECT DISTINCT bed_configuration FROM rooms WHERE bed_configuration IS NOT NULL");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bed_types[] = $row['bed_configuration'];
    }
}
$bed_types = array_unique($bed_types);
sort($bed_types);

$all_amenities = [];
$result = $conn->query("SELECT amenities FROM hotels WHERE amenities IS NOT NULL");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $amenities_list = explode(',', $row['amenities']);
        foreach ($amenities_list as $amenity) {
            $amenity = trim($amenity);
            if ($amenity) {
                $all_amenities[] = $amenity;
            }
        }
    }
}
$all_amenities = array_unique($all_amenities);
sort($all_amenities);

$fun_activities = ['Beach', 'Fitness', 'Spa', 'Hiking', 'Golf'];
$popular_amenities = ['Cancellation', 'Breakfast'];
$utility_amenities = array_diff($all_amenities, $fun_activities, $popular_amenities);

$rating_counts = [
    5 => 0,
    4 => 0,
    3 => 0,
    0 => 0
];

$result = $conn->query("SELECT COUNT(*) FROM hotels WHERE overall_rating >= 5");
if ($result) {
    $row = $result->fetch_row();
    $rating_counts[5] = $row ? $row[0] : 0;
} else {
    error_log("Query failed for rating >= 5: " . $conn->error);
}

$result = $conn->query("SELECT COUNT(*) FROM hotels WHERE overall_rating >= 4 AND overall_rating < 5");
if ($result) {
    $row = $result->fetch_row();
    $rating_counts[4] = $row ? $row[0] : 0;
} else {
    error_log("Query failed for rating >= 4 and < 5: " . $conn->error);
}

$result = $conn->query("SELECT COUNT(*) FROM hotels WHERE overall_rating >= 3 AND overall_rating < 4");
if ($result) {
    $row = $result->fetch_row();
    $rating_counts[3] = $row ? $row[0] : 0;
} else {
    error_log("Query failed for rating >= 3 and < 4: " . $conn->error);
}

$result = $conn->query("SELECT COUNT(*) FROM hotels WHERE overall_rating < 3");
if ($result) {
    $row = $result->fetch_row();
    $rating_counts[0] = $row ? $row[0] : 0;
} else {
    error_log("Query failed for rating < 3: " . $conn->error);
}

$query = "SELECT h.id, h.name, h.address, h.city, h.country, h.overall_rating, h.review_count, h.amenities, h.last_booked,
        hi.imgurl AS image_path, r.room_type, r.price, r.bed_configuration, hr.details AS cancellation_policy
        FROM hotels h
        LEFT JOIN hotel_images hi ON h.id = hi.hotel_id AND hi.is_main = TRUE
        LEFT JOIN rooms r ON h.id = r.hotel_id
        LEFT JOIN house_rules hr ON h.id = hr.hotel_id AND hr.rule_type = 'Cancellation'
        WHERE 1=1";
$params = [];
$types = '';

if ($search) {
    $query .= " AND (h.city LIKE ? OR h.country LIKE ? OR h.name LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'sss';
}

if ($guests > 0) {
    $query .= " AND r.max_guests >= ?";
    $params[] = $guests;
    $types .= 'i';
}

if (!empty($bed_type)) {
    $bed_conditions = [];
    foreach ($bed_type as $bed) {
        $bed_conditions[] = "r.bed_configuration = ?";
        $params[] = $bed;
        $types .= 's';
    }
    $query .= " AND (" . implode(' OR ', $bed_conditions) . ")";
}

if (!empty($amenities)) {
    foreach ($amenities as $amenity) {
        $query .= " AND FIND_IN_SET(?, h.amenities)";
        $params[] = $amenity;
        $types .= 's';
    }
}

if ($rating > 0) {
    $query .= " AND h.overall_rating >= ?";
    $params[] = $rating;
    $types .= 'd';
}

$count_query = "SELECT COUNT(DISTINCT h.id) FROM hotels h";
if ($guests > 0 || !empty($bed_type)) {
    $count_query .= " LEFT JOIN rooms r ON h.id = r.hotel_id";
}
$count_query .= " " . substr($query, strpos($query, "WHERE"));

$stmt = $conn->prepare($count_query);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
if ($types) {
    if (!$stmt->bind_param($types, ...$params)) {
        die("Bind failed: " . $stmt->error);
    }
}
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}
$result = $stmt->get_result();
$row = $result->fetch_row();
$total_hotels = $row ? $row[0] : 0;
$total_pages = ceil($total_hotels / $hotels_per_page);
$stmt->close();
error_log("Total hotels: $total_hotels, Total pages: $total_pages, Page: $page, Offset: $offset");

$query .= " GROUP BY h.id LIMIT ? OFFSET ?";
$params[] = $hotels_per_page;
$params[] = $offset;
$types .= 'ii';

try {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $hotels = [];
    $weather_api_key = '59dc4404330a3ca6b9ee898631459f3c'; // Added OpenWeatherMap API key
    while ($row = $result->fetch_assoc()) {
        // Fetch weather data for the hotel's city
        $city = urlencode($row['city']);
        $weather_url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$weather_api_key}&units=metric";
        $weather_data = @file_get_contents($weather_url);
        if ($weather_data !== false) {
            $weather = json_decode($weather_data, true);
            if (isset($weather['main']['temp']) && isset($weather['weather'][0]['description'])) {
                $row['weather'] = [
                    'temp' => round($weather['main']['temp']),
                    'description' => ucfirst($weather['weather'][0]['description'])
                ];
            } else {
                $row['weather'] = ['temp' => 'N/A', 'description' => 'Weather data unavailable'];
            }
        } else {
            $row['weather'] = ['temp' => 'N/A', 'description' => 'Weather data unavailable'];
        }
        $hotels[] = $row;
    }
    $stmt->close();
    error_log("Hotels retrieved: " . count($hotels));
} catch (Exception $e) {
    echo "Query failed: " . $e->getMessage();
    exit;
}

function formatLastBooked($minutes)
{
    if ($minutes == 0) {
        return "No recent bookings";
    } elseif ($minutes < 60) {
        return "Last booked {$minutes}min ago";
    } elseif ($minutes < 1440) {
        $hours = floor($minutes / 60);
        return "Last booked {$hours} hour" . ($hours > 1 ? 's' : '') . " ago";
    } elseif ($minutes < 10080) {
        $days = floor($minutes / 1440);
        return "Last booked {$days} day" . ($days > 1 ? 's' : '') . " ago";
    } else {
        return "Last booked a week ago";
    }
}

function generateStars($rating)
{
    $maxStars = 5;
    $fullStars = floor($rating / 2);
    $halfStar = ($rating / 2 - $fullStars >= 0.5) ? 1 : 0;
    $emptyStars = $maxStars - $fullStars - $halfStar;

    $html = '<div class="star">';
    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<i class="fa-solid fa-star"></i>';
    }
    if ($halfStar) {
        $html .= '<i class="fa-solid fa-star-half"></i>';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<i class="fa-regular fa-star"></i>';
    }
    $html .= '</div>';
    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Tour & Travel Booking</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/hotels.css">
    <script src="../script/hotel-mainpage.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="../styles/login-register.css">
    <style>
        .costumer-rating .rating-slider {
            width: 100%;
            margin: 10px 0;
        }

        .costumer-rating .star-display {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .costumer-rating .star-display .star i {
            color: #fec108;
        }

        .costumer-rating .star-display .star i.fa-regular {
            color: #ccc;
        }

        .costumer-rating .rating-value {
            margin-left: 10px;
            font-size: 14px;
            color: #555;
        }

        .top {
            position: absolute !important;
            top: -63px !important;
            left: 1074px;

        }

        .top button,
        .top button:hover {
            background-color: #c4291d !important;
            color: white;
        }

        .weather-info {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>

<body class="body">
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

    <div style="position: relative; width: 100%; height: 100%;">
        <div class="page-container">
            <div class="sidebar">
                <a href="/WEB2-Ebooking/src/index.php"><i class="fa-solid fa-hotel icon"></i>Home</a>
                <a href="/WEB2-Ebooking/src/Hotel Page/hotels.php" style="color: rgb(215, 44, 33);"><i
                        class="fa-solid fa-hotel icon"></i>Hotels</a>
                <a href="/WEB2-Ebooking/src/Cars-Page/cars.php"><i class="fa-solid fa-car icon"></i>Cars</a>
                <a href="/WEB2-Ebooking/src/AboutUs.php"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
            </div>
        </div>
    </div>

    <section class="search-bar">
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="GET" action="">
            <div class="search-input">
                <fieldset>
                    <legend>Where</legend>
                    <input type="text" name="text" id="text" class="same" placeholder="Going To"
                        value="<?php echo htmlspecialchars($search); ?>" list="locations">
                    <datalist id="locations">
                        <?php
                        $locations = $conn->query("SELECT DISTINCT city FROM hotels");
                        if ($locations) {
                            while ($loc = $locations->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($loc['city']) . "\">";
                            }
                        }
                        ?>
                    </datalist>
                </fieldset>
                <fieldset>
                    <legend>CheckIn & CheckOut</legend>
                    <input type="date" name="date" id="date" class="same" min="2025-05-25"
                        value="<?php echo htmlspecialchars($checkin); ?>">
                </fieldset>
                <fieldset>
                    <legend>Guests & Rooms</legend>
                    <input type="number" name="number" id="number" min="1" class="same" value="<?php echo $guests; ?>">
                </fieldset>
                <button type="submit"><i class="fa-solid fa-magnifying-glass loop"></i>Search</button>
            </div>
        </form>
    </section>

    <section class="hotel-body">
        <div class="section1">
            <div class="filter">
                <div class="filter-text">
                    <p id="text1">Filters</p>
                    <p id="text2"><a href="?page=1">Clear all</a></p>
                </div>
                <div class="bed">
                    <p>Bed Type</p>
                    <div class="button-part">
                        <form method="GET" action="">
                            <input type="hidden" name="text" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="hidden" name="date" value="<?php echo htmlspecialchars($checkin); ?>">
                            <input type="hidden" name="number" value="<?php echo $guests; ?>">
                            <input type="hidden" name="rating" value="<?php echo $rating; ?>">
                            <?php foreach ($amenities as $amenity): ?>
                                <input type="hidden" name="amenities[]" value="<?php echo htmlspecialchars($amenity); ?>">
                            <?php endforeach; ?>
                            <table style="width: 100%;">
                                <?php
                                $bed_count = count($bed_types);
                                for ($i = 0; $i < $bed_count; $i += 2):
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="bed_type[]" id="bed_<?php echo $i; ?>"
                                                value="<?php echo htmlspecialchars($bed_types[$i]); ?>" <?php echo in_array($bed_types[$i], $bed_type) ? 'checked' : ''; ?>>
                                            <label
                                                for="bed_<?php echo $i; ?>"><?php echo htmlspecialchars($bed_types[$i]); ?></label>
                                        </td>
                                        <?php if ($i + 1 < $bed_count): ?>
                                            <td>
                                                <input type="checkbox" name="bed_type[]" id="bed_<?php echo $i + 1; ?>"
                                                    value="<?php echo htmlspecialchars($bed_types[$i + 1]); ?>" <?php echo in_array($bed_types[$i + 1], $bed_type) ? 'checked' : ''; ?>>
                                                <label
                                                    for="bed_<?php echo $i + 1; ?>"><?php echo htmlspecialchars($bed_types[$i + 1]); ?></label>
                                            </td>
                                        <?php else: ?>
                                            <td></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                            <button type="submit" style="margin-top: 10px;">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="amenities-s">
                    <p>Amenities</p>
                    <div class="select">
                        <form method="GET" action="">
                            <input type="hidden" name="text" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="hidden" name="date" value="<?php echo htmlspecialchars($checkin); ?>">
                            <input type="hidden" name="number" value="<?php echo $guests; ?>">
                            <input type="hidden" name="rating" value="<?php echo $rating; ?>">
                            <?php foreach ($bed_type as $bed): ?>
                                <input type="hidden" name="bed_type[]" value="<?php echo htmlspecialchars($bed); ?>">
                            <?php endforeach; ?>
                            <?php foreach ($utility_amenities as $index => $amenity): ?>
                                <div class="amenity-item">
                                    <input type="checkbox" name="amenities[]" id="util_<?php echo $index; ?>"
                                        value="<?php echo htmlspecialchars($amenity); ?>" <?php echo in_array($amenity, $amenities) ? 'checked' : ''; ?> class="amenity-checkbox">
                                    <label for="util_<?php echo $index; ?>"
                                        class="amenity-label"><?php echo htmlspecialchars($amenity); ?></label>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" style="margin-top: 10px;">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="costumer-rating">
                    <p>Customer Ratings</p>
                    <div class="select">
                        <form method="GET" action="">
                            <input type="hidden" name="text" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="hidden" name="date" value="<?php echo htmlspecialchars($checkin); ?>">
                            <input type="hidden" name="number" value="<?php echo $guests; ?>">
                            <?php foreach ($bed_type as $bed): ?>
                                <input type="hidden" name="bed_type[]" value="<?php echo htmlspecialchars($bed); ?>">
                            <?php endforeach; ?>
                            <?php foreach ($amenities as $amenity): ?>
                                <input type="hidden" name="amenities[]" value="<?php echo htmlspecialchars($amenity); ?>">
                            <?php endforeach; ?>
                            <div style="position: relative;">
                                <input type="range" name="rating" id="rating-slider" min="0" max="10" step="0.1"
                                    value="<?php echo $rating; ?>" class="rating-slider"
                                    oninput="updateStars(this.value)">
                                <div class="star-display">
                                    <span class="star">
                                        <?php echo generateStars($rating); ?>
                                    </span>
                                    <span class="rating-value"><?php echo number_format($rating, 1); ?>/10</span>
                                </div>
                            </div>
                            <button type="submit" style="margin-top: 10px;">Apply</button>
                        </form>
                        <script>
                            function updateStars(value) {
                                const starDisplay = document.querySelector('.star-display .star');
                                starDisplay.innerHTML = '<?php echo str_replace(["\n", "\r"], '', generateStars(0)); ?>'.replace(/fa-star/g, 'fa-star').replace(/fa-star-half/g, 'fa-star-half').replace(/fa-regular fa-star/g, 'fa-regular fa-star');
                                const stars = Math.floor(value / 2);
                                const halfStar = (value / 2 - stars >= 0.5) ? 1 : 0;
                                const emptyStars = 5 - stars - halfStar;
                                let html = '';
                                for (let i = 0; i < stars; i++) html += '<i class="fa-solid fa-star"></i>';
                                if (halfStar) html += '<i class="fa-solid fa-star-half"></i>';
                                for (let i = 0; i < emptyStars; i++) html += '<i class="fa-regular fa-star"></i>';
                                starDisplay.innerHTML = html;
                                document.querySelector('.rating-value').textContent = `${value}/10`;
                            }

                            document.addEventListener('DOMContentLoaded', () => {
                                updateStars(<?php echo $rating; ?>);
                            });
                        </script>
                    </div>

                    <div style="margin-top: 10px;">
                        <?php if ($rating_counts[5] > 0): ?>
                            <div><span class="star"><?php echo generateStars(10); ?></span> <?php echo $rating_counts[5]; ?>
                                hotels</div>
                        <?php endif; ?>
                        <?php if ($rating_counts[4] > 0): ?>
                            <div><span class="star"><?php echo generateStars(8); ?></span> <?php echo $rating_counts[4]; ?>
                                hotels</div>
                        <?php endif; ?>
                        <?php if ($rating_counts[3] > 0): ?>
                            <div><span class="star"><?php echo generateStars(6); ?></span> <?php echo $rating_counts[3]; ?>
                                hotels</div>
                        <?php endif; ?>
                        <?php if ($rating_counts[0] > 0): ?>
                            <div><span class="star"><?php echo generateStars(2); ?></span> <?php echo $rating_counts[0]; ?>
                                hotels</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <section class="hotel-listings">
            <?php
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                echo '
                 <div class="top">
                 <div class="adCar">
                 <a href="addHotel.php"><button class="addCar">Add new hotel</button></a>
                </div>
                </div>';
            }
            ?>
            <div class="hotel-page page1 active" id="page1">
                <?php $count = 0; ?>
                <?php foreach ($hotels as $hotel): ?>
                    <?php
                    $features = $hotel['amenities'] ? explode(',', $hotel['amenities']) : [];
                    $rating_text = $hotel['overall_rating'] >= 9 ? 'Exceptional' : ($hotel['overall_rating'] >= 8 ? 'Very Good' : 'Good');
                    ?>
                    <div class="box">
                        <div class="section2">
                            <div class="hotel-img">
                                <a href="/WEB2-Ebooking/src/Hotel Page/hotelsView.php?id=<?php echo $hotel['id']; ?>"
                                    target="_blank">
                                    <img src="<?php echo htmlspecialchars($hotel['image_path'] ?: '../images/hotel-photo/default.jpg'); ?>"
                                        alt="Picture of hotel">
                                </a>
                            </div>
                            <div class="hotel-text">
                                <div>
                                    <?php echo generateStars($hotel['overall_rating']); ?>
                                    <p id="style-hotel-p"><?php echo htmlspecialchars($hotel['name']); ?></p>
                                </div>
                                <div>
                                    <p id="text5">
                                        <?php echo htmlspecialchars($hotel['address'] . ', ' . $hotel['city'] . ', ' . $hotel['country']); ?>
                                    </p>
                                    <div class="weather-info">
                                        Weather in <?php echo htmlspecialchars($hotel['city']); ?>: 
                                        <?php echo $hotel['weather']['temp']; ?>°C, <?php echo $hotel['weather']['description']; ?>
                                    </div>
                                    <div class="hotel-offers">
                                        <?php foreach ($features as $feature): ?>
                                            <p><?php echo htmlspecialchars($feature); ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="middle-text">
                                    <p id="text6"><?php echo htmlspecialchars($hotel['room_type']); ?></p>
                                    <p id="text7"><?php echo htmlspecialchars(formatLastBooked($hotel['last_booked'])); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="hotel-button">
                                <div class="parent">
                                    <div class="part1">
                                        <p id="text10"><?php echo $rating_text; ?></p>
                                        <p id="text11">
                                            <output name="reviews-count"
                                                id="reviews-count"><?php echo number_format($hotel['review_count']); ?></output>
                                            reviews
                                        </p>
                                    </div>
                                    <button
                                        id="button"><?php echo number_format($hotel['overall_rating'], 1); ?>/10</button>
                                </div>
                                <div class="price-section">
                                    <div class="price-details">
                                        <p class="current-price">$<?php echo number_format($hotel['price'], 2); ?></p>
                                    </div>
                                    <a href="/WEB2-Ebooking/src/Hotel Page/hotelsView.php?id=<?php echo $hotel['id']; ?>"
                                        class="availability-button">See Availability</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                    if ($count == 2 && $page == 1) {
                        ?>
                        <div class="advertisement">
                            <div class="adv-img">
                                <p id="icon"><i class="fa-solid fa-gift fs-3 text-success"></i></p>
                            </div>
                            <div class="text">
                                <p>Start Exploring The World</p>
                                <p id="text-child">Book Flights Effortless and Earn $50+ for each booking with Booking.com</p>
                            </div>
                            <div id="adv-button">
                                <button>Get Started</button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                <?php endforeach; ?>
                <?php if (empty($hotels)): ?>
                    <p>No hotels found matching your criteria.</p>
                <?php endif; ?>
            </div>

            <div class="bottom" id="box-bottom">
                <div class="bottom-part">
                    <p><a href="?page=<?php echo max(1, $page - 1); ?>&text=<?php echo urlencode($search); ?>&date=<?php echo urlencode($checkin); ?>&number=<?php echo $guests; ?>&rating=<?php echo $rating; ?><?php foreach ($bed_type as $bed)
                                          echo '&bed_type[]=' . urlencode($bed); ?><?php foreach ($amenities as $amenity)
                                                  echo '&amenities[]=' . urlencode($amenity); ?>"><i
                                class="fa-solid fa-arrow-left" id="left-arrow"></i></a></p>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&text=<?php echo urlencode($search); ?>&date=<?php echo urlencode($checkin); ?>&number=<?php echo $guests; ?>&rating=<?php echo $rating; ?><?php foreach ($bed_type as $bed)
                                           echo '&bed_type[]=' . urlencode($bed); ?><?php foreach ($amenities as $amenity)
                                                   echo '&amenities[]=' . urlencode($amenity); ?>"
                            class="page-btn <?php echo $i == $page ? 'active' : ''; ?>"
                            id="page<?php echo $i; ?>-btn"><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <p><a href="?page=<?php echo min($total_pages, $page + 1); ?>&text=<?php echo urlencode($search); ?>&date=<?php echo urlencode($checkin); ?>&number=<?php echo $guests; ?>&rating=<?php echo $rating; ?><?php foreach ($bed_type as $bed)
                                          echo '&bed_type[]=' . urlencode($bed); ?><?php foreach ($amenities as $amenity)
                                                  echo '&amenities[]=' . urlencode($amenity); ?>"><i
                                class="fa-solid fa-arrow-right" id="right-arrow"></i></a></p>
                </div>
            </div>
        </section>
    </section>

    <footer style="margin-top: 150px;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
<?php $conn->close(); ?>
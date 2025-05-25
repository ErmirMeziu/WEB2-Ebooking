<?php
session_start();
include '../db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $hotel_id = intval($_GET['id']);
    $_SESSION['hotel_id'] = $hotel_id;
} elseif (isset($_SESSION['hotel_id']) && is_numeric($_SESSION['hotel_id'])) {
    $hotel_id = intval($_SESSION['hotel_id']);
} else {

    header("Location: hotels.php?error=" . urlencode("Please select a hotel to view details."));
    exit;
}

if ($hotel_id <= 0) {
    header("Location: hotels.php?error=" . urlencode("Invalid hotel ID."));
    exit;
}

try {

    $stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotel = $result->fetch_assoc();
    $stmt->close();
    if (!$hotel) {
        echo "No hotel found with ID $hotel_id.";
        exit;
    }


    $stmt = $conn->prepare("SELECT * FROM rooms WHERE hotel_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    $stmt->close();
    if (empty($rooms)) {
        echo "No rooms found for hotel ID $hotel_id.";
    }

    $stmt = $conn->prepare("SELECT * FROM reviews WHERE hotel_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    $stmt->close();
    if (empty($reviews)) {
        echo "No reviews found for hotel ID $hotel_id.";
    }

    $stmt = $conn->prepare("SELECT * FROM house_rules WHERE hotel_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $house_rules = [];
    while ($row = $result->fetch_assoc()) {
        $house_rules[] = $row;
    }
    $stmt->close();
    if (empty($house_rules)) {
        echo "No house rules found for hotel ID $hotel_id.";
    }

    $stmt = $conn->prepare("SELECT imgurl, is_main FROM hotel_images WHERE hotel_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $main_photos = [];
    $bottom_photos = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['is_main']) {
            $main_photos[] = $row['imgurl'];
        } else {
            $bottom_photos[] = $row['imgurl'];
        }
    }
    $stmt->close();
    if (empty($main_photos) && empty($bottom_photos)) {
        echo "No images found for hotel ID $hotel_id.";
    }
} catch (Exception $e) {
    echo "Query failed: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - <?php echo htmlspecialchars($hotel['name']); ?></title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/hotels.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../styles/hotel-child.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/login-register.css">

    <style>
        .hotel-snd ul ol li {
            list-style-type: none;
            font-size: 14px;
        }

        .hotel-snd ul ol li::before {
            content: '!';
            color: red;
            margin-left: 22px;
        }

        .h2-size {
            font-size: 24px;
        }

        .h5-style {
            margin-left: 5px;
        }

        .btn-style {
            width: 24px;
            height: 24px;
            background-color: rgb(0, 45, 113);
            color: white;
            border: none;
            border-radius: 5px 5px 5px 0;
            margin-right: 5px;
        }

        .p-style {
            font-size: 14px;
            color: rgb(118, 118, 118);
        }

        #hotels {
            color: rgb(215, 44, 33);
        }

        .reserve-btn {
            background-color: #2563eb;
            color: white;
            align-items: center !important;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            text-align: center;
            align-content: center;
        }

        .reserve-btn:hover {
            background-color: #1e40af !important;
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
                <a href="../index.php"><i class="fa-solid fa-hotel icon"></i>Home</a>
                <a href="hotels.php" style="color: rgb(215, 44, 33)"><i class="fa-solid fa-hotel icon"></i>Hotels</a>
                <a href="../Cars-Page/cars.php"><i class="fa-solid fa-car icon"></i>Cars</a>
                <a href="../AboutUs.php"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
            </div>
        </div>
    </div>

    <div class="body-part">
        <div class="sec1">

            <div class="text">
                <p><?php echo htmlspecialchars($hotel['name']); ?></p>
            </div>

            <div class="pin-text">
                <p><i class="fa-solid fa-location-dot"></i>
                    <?php echo htmlspecialchars($hotel['address'] . ', ' . $hotel['city'] . ', ' . $hotel['country']); ?>
                    <a href="https://www.google.com/maps/place/Hotel+Chancellor/@1.3149209,103.8118214,13.59z/data=!4m9!3m8a!1s0x31da199656c10c63:0x7634e84074996b35!5m2!4m1!1i2!8m2!3d1.3011349!4d103.8421518!16s%2Fg%2F11cjj86261?entry=ttu&g_ep=EgoyMDI0MTIwOS4wIKXMDSoASAFQAw%3D%3D"
                        target="_blank"> -Great location - show map</a>
                </p>
                <a href="/WEB2-Ebooking/src/Hotel Page/reservePage.php?hotel_id=<?php echo htmlspecialchars($hotel_id); ?>"
                    target="_blank" id="btn-res" class="reserve-btn">Reserve</a>
            </div>

            <div class="photos">
                <?php foreach ($main_photos as $index => $imgurl): ?>
                    <img src="<?php echo htmlspecialchars($imgurl); ?>" alt="Hotel img" class="photo"
                        id="<?php echo ['first-photo', 'second-photo', 'third-photo'][$index]; ?>">
                <?php endforeach; ?>
                <div class="bottom-photos">
                    <?php foreach ($bottom_photos as $imgurl): ?>
                        <img src="<?php echo htmlspecialchars($imgurl); ?>" alt="Hotel img" class="bottom-pht">
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="some-txt">
                <?php
                $description_paragraphs = !empty($hotel['description']) ? explode("|", $hotel['description']) : [];
                if (empty($description_paragraphs)) {
                    echo '<p>No description available for this hotel.</p>';
                } else {
                    foreach ($description_paragraphs as $index => $paragraph) {
                        $paragraph = trim($paragraph);
                        if ($paragraph === '')
                            continue;
                        echo '<p>' . nl2br(htmlspecialchars($paragraph)) . '</p>';
                        echo '<p> </p>';
                    }
                }
                ?>
                <div id="extra-text" class="hidden">
                    <?php
                    $hidden_paragraphs = !empty($hotel['hidden_description']) ? explode("|", $hotel['hidden_description']) : [];
                    if (empty($hidden_paragraphs)) {
                        echo '<p>No additional information available.</p>';
                    } else {
                        foreach ($hidden_paragraphs as $index => $paragraph) {
                            $paragraph = trim($paragraph);
                            if ($paragraph === '')
                                continue;
                            echo '<p>' . nl2br(htmlspecialchars($paragraph)) . '</p>';
                            echo '<p> </p>';
                        }
                        $rating_text = !empty($hotel['location_rating'])
                            ? 'The location has been rated at: <strong>' . htmlspecialchars($hotel['location_rating']) . '</strong>.'
                            : '';
                        if ($rating_text !== '') {
                            echo '<p>' . $rating_text . '</p>';
                            echo '<p> </p>';
                        }
                    }
                    ?>
                </div>
                <button class="toggle-btn" id="toggle-btn">Show More</button>
            </div>
        </div>

        <div class="sec2">
            <div class="reviews">
                <div class="txt">
                    <p id="second" style="font-size: 16px; color: black; font-weight: 600;">
                        Total reviews: <?php echo htmlspecialchars($hotel['review_count']); ?> reviews
                    </p>
                </div>
                <div class="btn">
                    <button><?php echo htmlspecialchars($hotel['overall_rating']); ?></button>
                </div>
            </div>

            <div class="location">
                <div class="txt">
                    <p id="third">Location rating</p>
                </div>
                <div class="btn">
                    <button><?php echo htmlspecialchars($hotel['location_rating']); ?></button>
                </div>
            </div>

            <div class="map-container">
                <iframe src="<?php echo htmlspecialchars($hotel['map_embed_url']); ?>" width="100%" height="300"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                <button class="show-on-map-btn"><a href="<?php echo htmlspecialchars($hotel['map_link_url']); ?>"
                        target="_blank">Show on map</a></button>
            </div>
        </div>
    </div>

    <div class="body-part2">
        <br>
        <hr><br>
        <h2 id="avb" class="h2-size">Availability</h2>

        <table class="room-table">
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Number of Guests</th>
                    <th>Price (SGD)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $index => $room): ?>
                    <tr draggable="true" id="room<?php echo $index + 1; ?>">
                        <td>
                            <span class="expand-icon" id="number-<?php echo $index + 1; ?>"><?php echo $index + 1; ?></span>
                            <strong><?php echo htmlspecialchars($room['room_type']); ?></strong><br>
                            <?php echo htmlspecialchars($room['bed_configuration']); ?>
                            <i
                                class="fa-solid fa-<?php echo strpos($room['bed_configuration'], 'single') !== false ? 'user-group' : 'bed'; ?>"></i>
                        </td>
                        <td class="guest-info">
                            <i class="fa-solid fa-user-group"></i> x <?php echo htmlspecialchars($room['max_guests']); ?>
                            <i class="fa-solid fa-circle-info info-icon"></i>
                        </td>
                        <td class="price">
                            $<?php echo number_format($room['price'], 2); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size">Guest review</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>
        <div class="guest-reviews">
            <div class="btn">
                <button><?php echo htmlspecialchars($hotel['overall_rating']); ?></button>
            </div>
            <div class="gst-txt">
                <p id="txt-first">Pleasant -</p>
                <p id="txt-second"><?php echo htmlspecialchars($hotel['review_count']); ?> reviews</p>
            </div>
        </div>
        <div class="reviews-container">
            <div class="categories">
                <?php foreach ($reviews as $review): ?>
                    <div class="category">
                        <div class="category-title">
                            <span><?php echo htmlspecialchars($review['category']); ?></span>
                            <span>↓</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-<?php echo $review['rating'] >= 7 ? 'blue' : 'red'; ?>"
                                style="width: <?php echo $review['rating'] * 10; ?>%;"></div>
                        </div>
                        <div class="value"><?php echo htmlspecialchars($review['rating']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size">House rules</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>
        <p id="somep"><?php echo htmlspecialchars($hotel['name']); ?> takes special requests - add in the next step!</p>

        <div class="house-rules">
            <?php foreach ($house_rules as $rule): ?>
                <div class="rule">
                    <div class="icon<?php echo $rule['rule_type'] == 'Check-in' ? '' : '1'; ?>">
                        <?php echo $rule['rule_type'] == 'Check-in' ? '➡️' : ($rule['rule_type'] == 'Check-out' ? '⬅️' : ($rule['rule_type'] == 'Children and beds' ? '👶' : ($rule['rule_type'] == 'Pets' ? '🐕' : ($rule['rule_type'] == 'This property accepts' ? '💳' : ($rule['rule_type'] == 'Age restriction' ? '⛔' : 'ℹ'))))); ?>
                    </div>
                    <div class="details">
                        <h4><?php echo htmlspecialchars($rule['rule_type']); ?></h4>
                        <p><?php echo nl2br(htmlspecialchars($rule['details'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer style="margin-top: 70px;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

    <script>
        const audio = document.getElementById("audio");
        const audioIcon = document.getElementById("audio-icon");
        audioIcon.addEventListener("click", function () {
            audio.play();
        });
        $('#btn-res').on('click', function () {
            console.log('Reserve link clicked, navigating to:', $(this).attr('href'));
        });
    </script>
    <script src="../script/hotel1.js"></script>
</body>

</html>
<?php $conn->close(); ?>
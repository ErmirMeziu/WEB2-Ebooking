<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: /WEB2-Ebooking/src/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Add New Hotel</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/hotels.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .form-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #fafafa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #34495e;
            margin-bottom: 5px;
        }

        .form-group .input-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        .multi-input .input-group {
            margin-bottom: 15px;
            padding: 10px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            flex: 1;
        }

        .add-button,
        .remove-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            min-width: 80px;
        }

        .add-button {
            background: #2ecc71;
            color: white;
        }

        .add-button:hover {
            background: #27ae60;
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
        }

        .remove-btn:hover {
            background: #c0392b;
        }

        .submit-btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            width: 100%;
            font-size: 16px;
        }

        .submit-btn:hover {
            background: #2980b9;
        }

        @media (max-width: 600px) {
            .form-container {
                margin: 20px;
                padding: 15px;
            }

            .form-group input,
            .form-group textarea {
                font-size: 13px;
            }

            .submit-btn {
                font-size: 14px;
            }

            .input-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }

            .input-wrapper input,
            .input-wrapper textarea {
                width: 100%;
                max-width: none;
            }

            .input-wrapper .remove-btn {
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <section class="form-container">
        <h2>Add New Hotel</h2>

        <?php
        include '../db.php';

        $hotelId = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("Form data: " . print_r($_POST, true));

            $name = $_POST['name'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $description = $_POST['description'] ?? null;
            $hidden_description = $_POST['hidden_description'] ?? null;
            $location_rating = (float) ($_POST['location_rating'] ?? 0.0);
            $overall_rating = (float) ($_POST['overall_rating'] ?? 0.0);
            $review_count = (int) ($_POST['review_count'] ?? 0);
            $map_embed_url = $_POST['map_embed_url'] ?? null;
            $map_link_url = $_POST['map_link_url'] ?? null;
            $room_types = $_POST['room_type'] ?? [];
            $max_guests = $_POST['max_guests'] ?? [];
            $bed_configurations = $_POST['bed_configuration'] ?? [];
            $prices = $_POST['price'] ?? [];
            $categories = $_POST['category'] ?? [];
            $ratings = $_POST['rating'] ?? [];
            $rule_types = $_POST['rule_type'] ?? [];
            $rule_details = $_POST['details'] ?? [];

            if (!$conn) {
                die("Database connection failed: " . mysqli_connect_error());
            }

            $hotelSlug = str_replace(' ', '-', strtolower(trim($name)));
            $hotelDir = $_SERVER['DOCUMENT_ROOT'] . "/WEB2-Ebooking/src/images/Hotels/$hotelSlug/";
            if (!is_dir($hotelDir)) {
                mkdir($hotelDir, 0755, true);
            }

            $images = [];
            $is_main_values = $_POST['is_main'] ?? [];
            $has_main = false;
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['name'] as $key => $imageName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['images']['tmp_name'][$key];
                        $baseName = pathinfo($imageName, PATHINFO_FILENAME);
                        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
                        $uniqueName = $baseName . '.' . $extension;
                        $counter = 1;
                        while (file_exists($hotelDir . $uniqueName)) {
                            $uniqueName = $baseName . "_$counter." . $extension;
                            $counter++;
                        }
                        $destination = $hotelDir . $uniqueName;
                        $relativePath = "/WEB2-Ebooking/src/images/Hotels/$hotelSlug/$uniqueName";
                        if (move_uploaded_file($tmpName, $destination)) {
                            $is_main = isset($is_main_values[$key]) ? 1 : 0;
                            if (!$has_main && $key == 0 && !isset($is_main_values[$key])) {
                                $is_main = 1;
                                $has_main = true;
                            }
                            $images[] = [
                                'path' => $relativePath,
                                'is_main' => $is_main
                            ];
                        }
                    }
                }
            }

            $stmt = $conn->prepare("INSERT INTO hotels (name, address, city, country, description, hidden_description, overall_rating, location_rating, review_count, map_embed_url, map_link_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die("Prepare failed for hotels table: " . $conn->error);
            }
            $stmt->bind_param("ssssssddiss", $name, $address, $city, $country, $description, $hidden_description, $overall_rating, $location_rating, $review_count, $map_embed_url, $map_link_url);
            if (!$stmt->execute()) {
                die("Execute failed for hotels table: " . $stmt->error);
            }
            $hotelId = $conn->insert_id;
            $stmt->close();

            if (!$hotelId) {
                echo "<script>alert('Error adding hotel.');</script>";
                exit;
            }

            foreach ($images as $image) {
                if (!empty($image['path'])) {
                    $stmt = $conn->prepare("INSERT INTO hotel_images (hotel_id, imgurl, is_main) VALUES (?, ?, ?)");
                    if ($stmt === false) {
                        die("Prepare failed: " . $conn->error);
                    }
                    $is_main = $image['is_main'];
                    $stmt->bind_param("isi", $hotelId, $image['path'], $is_main);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            foreach ($room_types as $index => $room_type) {
                if (!empty($room_type)) {
                    $max_guest_value = (int) ($max_guests[$index] ?? 1);
                    $price_value = (float) ($prices[$index] ?? 0.0);
                    $bed_config = $bed_configurations[$index] ?? null;

                    $stmt = $conn->prepare("INSERT INTO rooms (hotel_id, room_type, bed_configuration, max_guests, price) VALUES (?, ?, ?, ?, ?)");
                    if ($stmt === false) {
                        error_log("Prepare failed for rooms: " . $conn->error);
                        echo "Error preparing rooms query.";
                        continue;
                    }
                    $stmt->bind_param("issid", $hotelId, $room_type, $bed_config, $max_guest_value, $price_value);
                    if (!$stmt->execute()) {
                        error_log("Execute failed for rooms: " . $stmt->error);
                        echo "Error executing rooms query.";
                    } else {
                        error_log("Inserted room for hotel ID $hotelId: $room_type, $price_value");
                    }
                    $stmt->close();
                } else {
                    error_log("Empty room type at index $index");
                }
            }

            foreach ($categories as $index => $category) {
                if (!empty($category)) {
                    $rating_value = (float) ($ratings[$index] ?? 0.0);
                    $stmt = $conn->prepare("INSERT INTO reviews (hotel_id, category, rating) VALUES (?, ?, ?)");
                    $stmt->bind_param("isd", $hotelId, $category, $rating_value);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            foreach ($rule_types as $index => $rule_type) {
                if (!empty($rule_type) && !empty($rule_details[$index])) {
                    $stmt = $conn->prepare("INSERT INTO house_rules (hotel_id, rule_type, details) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $hotelId, $rule_type, $rule_details[$index]);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            $conn->close();
            echo "<script>alert('Hotel added successfully!'); window.location.href='/WEB2-Ebooking/src/Hotel Page/hotels.php';</script>";
            exit();
        }
        ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Hotel Details</h3>
                <div class="form-group">
                    <label for="name">Hotel Name *</label>
                    <input type="text" id="name" name="name" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="address">Address *</label>
                    <input type="text" id="address" name="address" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="city">City *</label>
                    <input type="text" id="city" name="city" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="country">Country *</label>
                    <input type="text" id="country" name="country" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="hidden_description">Hidden Description</label>
                    <textarea id="hidden_description" name="hidden_description" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="location_rating">Location Rating (0.0 - 10.0)</label>
                    <input type="number" id="location_rating" name="location_rating" step="0.1" min="0.0" max="10.0"
                        value="0.0">
                </div>
                <div class="form-group">
                    <label for="overall_rating">Overall Rating (0.0 - 10.0)</label>
                    <input type="number" id="overall_rating" name="overall_rating" step="0.1" min="0.0" max="10.0"
                        value="0.0">
                </div>
                <div class="form-group">
                    <label for="review_count">Review Count</label>
                    <input type="number" id="review_count" name="review_count" min="0" value="0">
                </div>
                <div class="form-group">
                    <label for="map_embed_url">Map Embed URL</label>
                    <textarea id="map_embed_url" name="map_embed_url" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="map_link_url">Map Link URL</label>
                    <input type="text" id="map_link_url" name="map_link_url">
                </div>
                <div class="form-group">
                    <label>Images</label>
                    <div class="multi-input" id="image-inputs">
                        <div class="input-group">
                            <div class="input-wrapper">
                                <input type="file" name="images[]" accept="image/jpeg,image/png,image/gif" required>
                                <label><input type="checkbox" name="is_main[0]" value="1"> Main Image</label>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-image" class="add-button">Add Image</button>
                </div>
            </div>

            <div class="form-section dynamic-section">
                <h3>Rooms</h3>
                <div id="rooms-container" class="multi-input">
                    <div class="input-group room-group">
                        <div class="form-group">
                            <label for="room_type_0">Room Type *</label>
                            <div class="input-wrapper">
                                <input type="text" id="room_type_0" name="room_type[0]" maxlength="100" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="max_guests_0">Max Guests *</label>
                            <div class="input-wrapper">
                                <input type="number" id="max_guests_0" name="max_guests[0]" min="1" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bed_configuration_0">Bed Configuration</label>
                            <div class="input-wrapper">
                                <input type="text" id="bed_configuration_0" name="bed_configuration[0]" maxlength="255">
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price_0">Price (per night) *</label>
                            <div class="input-wrapper">
                                <input type="number" id="price_0" name="price[0]" step="0.01" min="0" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-room" class="add-button">Add Another Room</button>
            </div>

            <div class="form-section dynamic-section">
                <h3>Reviews</h3>
                <div id="reviews-container" class="multi-input">
                    <div class="input-group review-group">
                        <div class="form-group">
                            <label for="category_0">Category *</label>
                            <div class="input-wrapper">
                                <input type="text" id="category_0" name="category[0]" maxlength="100" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rating_0">Rating (0.0 - 10.0) *</label>
                            <div class="input-wrapper">
                                <input type="number" id="rating_0" name="rating[0]" step="0.1" min="0.0" max="10.0"
                                    required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-review" class="add-button">Add Another Review</button>
            </div>

            <div class="form-section dynamic-section">
                <h3>House Rules</h3>
                <div id="house_rules-container" class="multi-input">
                    <div class="input-group rule-group">
                        <div class="form-group">
                            <label for="rule_type_0">Rule Type *</label>
                            <div class="input-wrapper">
                                <input type="text" id="rule_type_0" name="rule_type[0]" maxlength="100" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="details_0">Details *</label>
                            <div class="input-wrapper">
                                <textarea id="details_0" name="details[0]" rows="2" required></textarea>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-rule" class="add-button">Add Another Rule</button>
            </div>

            <button type="submit" class="submit-btn">Submit Hotel <i class="fa-solid fa-plus"></i></button>
        </form>
    </section>

    <footer style="margin-top: 50px; background-color: white;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

    <script>
        $(document).ready(function () {
            $('#add-image').click(function () {
                let index = $('#image-inputs .input-group').length;
                $('#image-inputs').append(`
                    <div class="input-group">
                        <div class="input-wrapper">
                            <input type="file" name="images[]" accept="image/jpeg,image/png,image/gif">
                            <label><input type="checkbox" name="is_main[${index}]" value="1"> Main Image</label>
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    </div>
                `);
            });

            $('#add-room').click(function () {
                let index = $('#rooms-container .input-group').length;
                $('#rooms-container').append(`
                    <div class="input-group room-group">
                        <div class="form-group">
                            <label for="room_type_${index}">Room Type *</label>
                            <div class="input-wrapper">
                                <input type="text" id="room_type_${index}" name="room_type[${index}]" maxlength="100" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="max_guests_${index}">Max Guests *</label>
                            <div class="input-wrapper">
                                <input type="number" id="max_guests_${index}" name="max_guests[${index}]" min="1" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bed_configuration_${index}">Bed Configuration</label>
                            <div class="input-wrapper">
                                <input type="text" id="bed_configuration_${index}" name="bed_configuration[${index}]" maxlength="255">
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price_${index}">Price (per night) *</label>
                            <div class="input-wrapper">
                                <input type="number" id="price_${index}" name="price[${index}]" step="0.01" min="0" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('#add-review').click(function () {
                let index = $('#reviews-container .input-group').length;
                $('#reviews-container').append(`
                    <div class="input-group review-group">
                        <div class="form-group">
                            <label for="category_${index}">Category *</label>
                            <div class="input-wrapper">
                                <input type="text" id="category_${index}" name="category[${index}]" maxlength="100" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rating_${index}">Rating (0.0 - 10.0) *</label>
                            <div class="input-wrapper">
                                <input type="number" id="rating_${index}" name="rating[${index}]" step="0.1" min="0.0" max="10.0" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('#add-rule').click(function () {
                let index = $('#house_rules-container .input-group').length;
                $('#house_rules-container').append(`
                    <div class="input-group rule-group">
                        <div class="form-group">
                            <label for="rule_type_${index}">Rule Type *</label>
                            <div class="input-wrapper">
                                <input type="text" id="rule_type_${index}" name="rule_type[${index}]" maxlength="100" required>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="details_${index}">Details *</label>
                            <div class="input-wrapper">
                                <textarea id="details_${index}" name="details[${index}]" rows="2" required></textarea>
                                <button type="button" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.remove-btn', function () {
                $(this).closest('.input-group').remove();
            });

            $(document).on('change', 'input[name^="is_main"]', function () {
                if ($(this).is(':checked')) {
                    $('input[name^="is_main"]').not(this).prop('checked', false);
                }
            });

            // Reindex room fields before submission
            $('form').on('submit', function () {
                $('#rooms-container .room-group').each(function (index) {
                    $(this).find('input[name^="room_type"]').attr('name', `room_type[${index}]`);
                    $(this).find('input[name^="max_guests"]').attr('name', `max_guests[${index}]`);
                    $(this).find('input[name^="bed_configuration"]').attr('name', `bed_configuration[${index}]`);
                    $(this).find('input[name^="price"]').attr('name', `price[${index}]`);
                });
            });
        });
    </script>
</body>

</html>
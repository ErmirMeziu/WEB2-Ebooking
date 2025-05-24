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
    <title>GeoTrip - Add New Car</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/addcar.css">
    <link rel="stylesheet" href="../styles/cars.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <section class="add-car-form">
        <h2>Add New Car</h2>

        <?php
        include '../db.php';

        $carId = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $type = $_POST['type'];
            if ($type === 'Other' && !empty($_POST['other-type'])) {
                $type = $_POST['other-type'];
            }
            $seats = (int) $_POST['seats'];
            $price = (float) $_POST['price'];
            $reviews = (int) $_POST['reviews'];
            $reviewScore = (float) $_POST['reviewscore'];
            $details = $_POST['details'] ?? [];
            $extras = $_POST['extras'] ?? [];
            $otherDetails = $_POST['other-details'] ?? [];
            $otherExtras = $_POST['other-extras'] ?? [];
            $numberOfDoors = (int) $_POST['number_of_doors'];
            $passengerCapacity = (int) $_POST['passenger_capacity'];
            $suitcaseCapacity = (int) $_POST['suitcase_capacity'];

            $carSlug = str_replace(' ', '-', strtolower(trim($name)));
            $carDir = $_SERVER['DOCUMENT_ROOT'] . "/WEB2-Ebooking/src/images/Cars/$carSlug/";
            if (!is_dir($carDir)) {
                mkdir($carDir, 0755, true);
            }

            $images = [];
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['name'] as $key => $imageName) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['images']['tmp_name'][$key];
                        $baseName = pathinfo($imageName, PATHINFO_FILENAME);
                        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
                        $uniqueName = $baseName . '.' . $extension;
                        $counter = 1;
                        while (file_exists($carDir . $uniqueName)) {
                            $uniqueName = $baseName . "_$counter." . $extension;
                            $counter++;
                        }
                        $destination = $carDir . $uniqueName;
                        $relativePath = "/WEB2-Ebooking/src/images/Cars/$carSlug/$uniqueName";
                        if (move_uploaded_file($tmpName, $destination)) {
                            $images[] = $relativePath;
                        }
                    }
                }
            }

            $stmt = $conn->prepare("INSERT INTO cars (name, type, seats, price, oldprice, discount, reviews, reviewscore) VALUES (?, ?, ?, ?, NULL, 0, ?, ?)");
            $stmt->bind_param("ssidid", $name, $type, $seats, $price, $reviews, $reviewScore);
            $stmt->execute();
            $carId = $conn->insert_id;
            $stmt->close();

            if (!$carId) {
                echo "<script>alert('Error adding car.');</script>";
                exit;
            }

            foreach ($images as $imgurl) {
                if (!empty($imgurl)) {
                    $stmt = $conn->prepare("INSERT INTO carimages (carid, imgurl) VALUES (?, ?)");
                    $stmt->bind_param("is", $carId, $imgurl);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            foreach ($details as $index => $detail) {
                if (!empty($detail)) {
                    $finalDetail = ($detail === 'Other' && !empty($otherDetails[$index])) ? $otherDetails[$index] : $detail;
                    $stmt = $conn->prepare("INSERT INTO cardetails (carid, details) VALUES (?, ?)");
                    $stmt->bind_param("is", $carId, $finalDetail);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            foreach ($extras as $index => $extra) {
                if (!empty($extra)) {
                    $finalExtra = ($extra === 'Other' && !empty($otherExtras[$index])) ? $otherExtras[$index] : $extra;
                    $stmt = $conn->prepare("INSERT INTO carextras (name, car_id) VALUES (?, ?)");
                    $stmt->bind_param("si", $finalExtra, $carId);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            $transmissionType = "Automatic Transmission";
            $airConditioning = "Air Conditioning";
            $stmt = $conn->prepare("INSERT INTO car_specs (car_id, air_conditioning, number_of_doors, transmission_type, passenger_capacity, suitcase_capacity) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isissi", $carId, $airConditioning, $numberOfDoors, $transmissionType, $passengerCapacity, $suitcaseCapacity);
            $stmt->execute();
            $stmt->close();

            echo "<script>alert('Car added successfully!'); window.location.href='addcar.php';</script>";
            $conn->close();
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Car Name</label>
                <input type="text" name="name" id="name" maxlength="255" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="type-select" required>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" class="other-type-input" name="other-type" maxlength="50"
                    placeholder="Enter custom type" style="display: none;">
            </div>
            <div class="form-group">
                <label for="seats">Seats</label>
                <input type="number" name="seats" id="seats" value="5" min="1" required>
            </div>
            <div class="form-group">
                <label for="price">Price (US$) </label>
                <input type="number" step="0.01" name="price" id="price" min="0" required>
            </div>
            <div class="form-group">
                <label for="reviews">Reviews </label>
                <input type="number" name="reviews" id="reviews" value="0" min="0" required>
            </div>
            <div class="form-group">
                <label for="reviewscore">Review Score </label>
                <input type="number" step="0.1" name="reviewscore" id="reviewscore" min="0" max="5" required>
            </div>
            <div class="form-group">
                <label>Images</label>
                <div class="multi-input" id="image-inputs">
                    <div>
                        <input type="file" name="images[]" accept="image/jpeg,image/png,image/gif" required>
                        <button type="button" class="remove-btn">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-btn" id="add-image">Add Image</button>
            </div>
            <div class="form-group">
                <label>Details</label>
                <div class="multi-input" id="detail-inputs">
                    <div class="input-group">
                        <select name="details[]" class="detail-select" required>
                            <option value="1 Large bag">1 Large bag</option>
                            <option value="1 Small bag">1 Small bag</option>
                            <option value="2 Small bags">2 Small bags</option>
                            <option value="3 Small bags">3 Small bags</option>
                            <option value="Benzin">Benzin</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="text" class="other-detail-input" name="other-details[]" maxlength="255"
                            style="display: none;">
                        <button type="button" class="remove-btn">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-btn" id="add-detail">Add Detail</button>
            </div>
            <div class="form-group">
                <label>Extras <i class="fa-solid fa-plus"></i></label>
                <div class="multi-input" id="extra-inputs">
                    <div class="input-group">
                        <select name="extras[]" class="extra-select" required>
                            <option value="Airbag">Airbag</option>
                            <option value="Bluetooth">Bluetooth</option>
                            <option value="Radio">Radio</option>
                            <option value="Air Conditioning">Air Conditioning</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="text" class="other-extra-input" name="other-extras[]" maxlength="255"
                            style="display: none;">
                        <button type="button" class="remove-btn">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-btn" id="add-extra">Add Extra</button>
            </div>
            <div class="form-group">
                <label for="number_of_doors">Number of Doors </label>
                <input type="number" name="number_of_doors" id="number_of_doors" value="5" min="1" required>
            </div>
            <div class="form-group">
                <label for="passenger_capacity">Passenger Capacity </label>
                <input type="number" name="passenger_capacity" id="passenger_capacity" value="5" min="1" required>
            </div>
            <div class="form-group">
                <label for="suitcase_capacity">Suitcase Capacity</label>
                <input type="number" name="suitcase_capacity" id="suitcase_capacity" value="2" min="1" required>
            </div>
            <button type="submit">Add Car <i class="fa-solid fa-plus"></i></button>
        </form>
    </section>

    <footer style="margin-top: 50px; background-color: white;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

    <script>
        $(document).ready(function () {
            $('#add-image').click(function () {
                $('#image-inputs').append(`
                        <div>
                            <input type="file" name="images[]" accept="image/jpeg,image/png,image/gif">
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    `);
            });

            $('#add-detail').click(function () {
                $('#detail-inputs').append(`
                        <div class="input-group">
                            <select name="details[]" class="detail-select" required>
                                <option value="Automatic">Automatic</option>
                                <option value="1 Large bag">1 Large bag</option>
                                <option value="1 Small bag">1 Small bag</option>
                                <option value="2 Small bags">2 Small bags</option>
                                <option value="3 Small bags">3 Small bags</option>
                                <option value="Benzin">Benzin</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" class="other-detail-input" name="other-details[]" maxlength="255" style="display: none;">
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    `);
            });

            $('#add-extra').click(function () {
                $('#extra-inputs').append(`
                        <div class="input-group">
                            <select name="extras[]" class="extra-select" required>
                                <option value="Airbag">Airbag</option>
                                <option value="Bluetooth">Bluetooth</option>
                                <option value="Radio">Radio</option>
                                <option value="Air Conditioning">Air Conditioning</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" class="other-extra-input" name="other-extras[]" maxlength="255" style="display: none;">
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    `);
            });

            $(document).on('change', '.type-select', function () {
                const $otherInput = $(this).siblings('.other-type-input');
                if ($(this).val() === 'Other') {
                    $otherInput.show().prop('required', true);
                } else {
                    $otherInput.hide().prop('required', false).val('');
                }
            });

            $(document).on('change', '.detail-select', function () {
                const $otherInput = $(this).siblings('.other-detail-input');
                if ($(this).val() === 'Other') {
                    $otherInput.show().prop('required', true);
                } else {
                    $otherInput.hide().prop('required', false).val('');
                }
            });

            $(document).on('change', '.extra-select', function () {
                const $otherInput = $(this).siblings('.other-extra-input');
                if ($(this).val() === 'Other') {
                    $otherInput.show().prop('required', true);
                } else {
                    $otherInput.hide().prop('required', false).val('');
                }
            });

            $(document).on('click', '.remove-btn', function () {
                $(this).parent().remove();
            });
        });
    </script>
</body>

</html>
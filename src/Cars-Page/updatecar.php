<?php
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: /WEB2-Ebooking/src/index.php");
    exit();
}

require_once '../db.php';

$carId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$car = null;
$carImages = [];
$carDetails = [];
$carExtras = [];
$carSpecs = null;

if ($carId > 0) {
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $car = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT imgurl FROM carimages WHERE carid = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $carImages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $stmt = $conn->prepare("SELECT details FROM cardetails WHERE carid = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $carDetails = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $stmt = $conn->prepare("SELECT name FROM carextras WHERE car_id = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $carExtras = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM car_specs WHERE car_id = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $carSpecs = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$car) {
        echo "<script>alert('Car not found.'); window.location.href='cars.php';</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    if ($type === 'Other' && !empty($_POST['other-type'])) {
        $type = $_POST['other-type'];
    }
    $seats = (int) $_POST['seats'];
    $oldPrice = (float) $_POST['oldprice'];
    $discount = (int) $_POST['discount'];
    $price = $oldPrice - ($oldPrice * $discount / 100);
    $reviews = (int) $_POST['reviews'];
    $reviewScore = (float) $_POST['reviewscore'];
    $details = $_POST['details'] ?? [];
    $extras = $_POST['extras'] ?? [];
    $otherDetails = $_POST['other-details'] ?? [];
    $otherExtras = $_POST['other-extras'] ?? [];
    $numberOfDoors = (int) $_POST['number_of_doors'];
    $passengerCapacity = (int) $_POST['passenger_capacity'];
    $suitcaseCapacity = (int) $_POST['suitcase_capacity'];

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("UPDATE cars SET name = ?, type = ?, seats = ?, price = ?, oldprice = ?, discount = ?, reviews = ?, reviewscore = ? WHERE id = ?");
        $stmt->bind_param("ssiddidii", $name, $type, $seats, $price, $oldPrice, $discount, $reviews, $reviewScore, $carId);
        $stmt->execute();
        $stmt->close();

        $carSlug = str_replace(' ', '-', strtolower(trim($name)));
        $carDir = $_SERVER['DOCUMENT_ROOT'] . "/WEB2-Ebooking/src/images/Cars/$carSlug/";
        if (!is_dir($carDir)) {
            mkdir($carDir, 0755, true);
        }

        if (!empty($_FILES['images']['name'][0])) {
            $stmt = $conn->prepare("DELETE FROM carimages WHERE carid = ?");
            $stmt->bind_param("i", $carId);
            $stmt->execute();
            $stmt->close();

            $images = [];
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

            foreach ($images as $imgurl) {
                if (!empty($imgurl)) {
                    $stmt = $conn->prepare("INSERT INTO carimages (carid, imgurl) VALUES (?, ?)");
                    $stmt->bind_param("is", $carId, $imgurl);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        $stmt = $conn->prepare("DELETE FROM cardetails WHERE carid = ?");
        $stmt->bind_param("i", $carId);
        $stmt->execute();
        $stmt->close();

        foreach ($details as $index => $detail) {
            if (!empty($detail)) {
                $finalDetail = ($detail === 'Other' && !empty($otherDetails[$index])) ? $otherDetails[$index] : $detail;
                $stmt = $conn->prepare("INSERT INTO cardetails (carid, details) VALUES (?, ?)");
                $stmt->bind_param("is", $carId, $finalDetail);
                $stmt->execute();
                $stmt->close();
            }
        }

        $stmt = $conn->prepare("DELETE FROM carextras WHERE car_id = ?");
        $stmt->bind_param("i", $carId);
        $stmt->execute();
        $stmt->close();

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
        $stmt = $conn->prepare("UPDATE car_specs SET air_conditioning = ?, number_of_doors = ?, transmission_type = ?, passenger_capacity = ?, suitcase_capacity = ? WHERE car_id = ?");
        $stmt->bind_param("sissii", $airConditioning, $numberOfDoors, $transmissionType, $passengerCapacity, $suitcaseCapacity, $carId);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo "<script>alert('Car updated successfully!'); window.location.href='cars.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error updating car: " . addslashes($e->getMessage()) . "'); window.location.href='cars.php';</script>";
    }
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
        <h2>Update Car</h2>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Car Name</label>
                <input type="text" name="name" id="name" maxlength="255"
                    value="<?php echo htmlspecialchars($car['name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="type-select" required>
                    <option value="Sedan" <?php echo ($car['type'] ?? '') === 'Sedan' ? 'selected' : ''; ?>>Sedan</option>
                    <option value="SUV" <?php echo ($car['type'] ?? '') === 'SUV' ? 'selected' : ''; ?>>SUV</option>
                    <option value="Other" <?php echo !in_array($car['type'] ?? '', ['Sedan', 'SUV']) ? 'selected' : ''; ?>>Other</option>
                </select>
                <input type="text" class="other-type-input" name="other-type" maxlength="50"
                    placeholder="Enter custom type"
                    value="<?php echo !in_array($car['type'] ?? '', ['Sedan', 'SUV']) ? htmlspecialchars($car['type'] ?? '') : ''; ?>"
                    style="display: <?php echo !in_array($car['type'] ?? '', ['Sedan', 'SUV']) ? 'block' : 'none'; ?>;">
            </div>
            <div class="form-group">
                <label for="seats">Seats</label>
                <input type="number" name="seats" id="seats"
                    value="<?php echo htmlspecialchars($car['seats'] ?? '5'); ?>" min="1" required>
            </div>
            <div class="form-group">
                <label for="oldprice">Old Price (US$)</label>
                <input type="number" step="0.01" name="oldprice" id="oldprice"
                    value="<?php echo htmlspecialchars($car['oldprice'] ?? '0'); ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="discount">Discount (%)</label>
                <input type="number" name="discount" id="discount"
                    value="<?php echo htmlspecialchars($car['discount'] ?? '0'); ?>" min="0" max="100" required>
                <p id="new-price-display" style="margin-top: 5px; font-weight: bold;">New Price (US$):
                    <?php echo htmlspecialchars($car['price'] ?? '0'); ?>
                </p>
            </div>
            <div class="form-group">
                <label for="reviews">Reviews</label>
                <input type="number" name="reviews" id="reviews"
                    value="<?php echo htmlspecialchars(isset($car['reviews']) ? $car['reviews'] : '0'); ?>" min="0"
                    required>
            </div>
            <div class="form-group">
                <label for="reviewscore">Review Score</label>
                <input type="number" step="0.1" name="reviewscore" id="reviewscore"
                    value="<?php echo htmlspecialchars(isset($car['reviewscore']) ? $car['reviewscore'] : '0'); ?>"
                    min="0" max="5" required>
            </div>
            <div class="form-group">
                <label>Images</label>
                <div class="multi-input" id="image-inputs">
                    <?php foreach ($carImages as $index => $image): ?>
                        <div>
                            <img src="<?php echo htmlspecialchars($image['imgurl']); ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 150px; margin-bottom: 10px; border-radius: 5px;">
                            <input type="file" name="images[]" accept="image/jpeg,image/png,image/gif">
                            <span>Current: <?php echo htmlspecialchars(basename($image['imgurl'])); ?></span>
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($carImages)): ?>
                        <div>
                            <input type="file" name="images[]" accept="image/jpeg,image/png,image/gif" required>
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-btn" id="add-image">Add Image</button>
            </div>
            <div class="form-group">
                <label>Details</label>
                <div class="multi-input" id="detail-inputs">
                    <?php foreach ($carDetails as $index => $detail): ?>
                        <div class="input-group">
                            <select name="details[]" class="detail-select" required>
                                <option value="1 Large bag" <?php echo $detail['details'] === '1 Large bag' ? 'selected' : ''; ?>>1 Large bag</option>
                                <option value="1 Small bag" <?php echo $detail['details'] === '1 Small bag' ? 'selected' : ''; ?>>1 Small bag</option>
                                <option value="2 Small bags" <?php echo $detail['details'] === '2 Small bags' ? 'selected' : ''; ?>>2 Small bags</option>
                                <option value="3 Small bags" <?php echo $detail['details'] === '3 Small bags' ? 'selected' : ''; ?>>3 Small bags</option>
                                <option value="Benzin" <?php echo $detail['details'] === 'Benzin' ? 'selected' : ''; ?>>Benzin
                                </option>
                                <option value="Diesel" <?php echo $detail['details'] === 'Diesel' ? 'selected' : ''; ?>>Diesel
                                </option>
                                <option value="Other" <?php echo !in_array($detail['details'], ['1 Large bag', '1 Small bag', '2 Small bags', '3 Small bags', 'Benzin', 'Diesel']) ? 'selected' : ''; ?>>Other
                                </option>
                            </select>
                            <input type="text" class="other-detail-input" name="other-details[]" maxlength="255"
                                value="<?php echo !in_array($detail['details'], ['1 Large bag', '1 Small bag', '2 Small bags', '3 Small bags', 'Benzin', 'Diesel']) ? htmlspecialchars($detail['details']) : ''; ?>"
                                style="display: <?php echo !in_array($detail['details'], ['1 Large bag', '1 Small bag', '2 Small bags', '3 Small bags', 'Benzin', 'Diesel']) ? 'block' : 'none'; ?>;">
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($carDetails)): ?>
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
                    <?php endif; ?>
                </div>
                <button type="button" class="add-btn" id="add-detail">Add Detail</button>
            </div>
            <div class="form-group">
                <label>Extras</label>
                <div class="multi-input" id="extra-inputs">
                    <?php foreach ($carExtras as $index => $extra): ?>
                        <div class="input-group">
                            <select name="extras[]" class="extra-select" required>
                                <option value="Airbag" <?php echo $extra['name'] === 'Airbag' ? 'selected' : ''; ?>>Airbag
                                </option>
                                <option value="Bluetooth" <?php echo $extra['name'] === 'Bluetooth' ? 'selected' : ''; ?>>
                                    Bluetooth</option>
                                <option value="Radio" <?php echo $extra['name'] === 'Radio' ? 'selected' : ''; ?>>Radio
                                </option>
                                <option value="Air Conditioning" <?php echo $extra['name'] === 'Air Conditioning' ? 'selected' : ''; ?>>Air Conditioning</option>
                                <option value="Other" <?php echo !in_array($extra['name'], ['Airbag', 'Bluetooth', 'Radio', 'Air Conditioning']) ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <input type="text" class="other-extra-input" name="other-extras[]" maxlength="255"
                                value="<?php echo !in_array($extra['name'], ['Airbag', 'Bluetooth', 'Radio', 'Air Conditioning']) ? htmlspecialchars($extra['name']) : ''; ?>"
                                style="display: <?php echo !in_array($extra['name'], ['Airbag', 'Bluetooth', 'Radio', 'Air Conditioning']) ? 'block' : 'none'; ?>;">
                            <button type="button" class="remove-btn">Remove</button>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($carExtras)): ?>
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
                    <?php endif; ?>
                </div>
                <button type="button" class="add-btn" id="add-extra">Add Extra</button>
            </div>
            <div class="form-group">
                <label for="number_of_doors">Number of Doors</label>
                <input type="number" name="number_of_doors" id="number_of_doors"
                    value="<?php echo htmlspecialchars($carSpecs['number_of_doors'] ?? '5'); ?>" min="1" required>
            </div>
            <div class="form-group">
                <label for="passenger_capacity">Passenger Capacity</label>
                <input type="number" name="passenger_capacity" id="passenger_capacity"
                    value="<?php echo htmlspecialchars($carSpecs['passenger_capacity'] ?? '5'); ?>" min="1" required>
            </div>
            <div class="form-group">
                <label for="suitcase_capacity">Suitcase Capacity</label>
                <input type="number" name="suitcase_capacity" id="suitcase_capacity"
                    value="<?php echo htmlspecialchars($carSpecs['suitcase_capacity'] ?? '2'); ?>" min="1" required>
            </div>
            <button type="submit">Update Car</button>
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

            function calculateNewPrice() {
                const oldPrice = parseFloat($('#oldprice').val()) || 0;
                const discount = parseInt($('#discount').val()) || 0;
                const newPrice = oldPrice - (oldPrice * discount / 100);
                $('#new-price-display').text('New Price (US$): ' + newPrice.toFixed(2));
            }

            $('#oldprice, #discount').on('input', calculateNewPrice);
            calculateNewPrice();
        });
    </script>
</body>

</html>
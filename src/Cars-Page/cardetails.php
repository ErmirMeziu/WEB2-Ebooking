<!DOCTYPE html>
<html lang="en">

<head>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Tour & Travel Booking</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/carspage.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/cars.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../styles/login-register.css">
    <script src="../script/cars-page.js" defer></script>
    <script src="../script/login-register.js" defer></script>
    <style>
        #cars {
            color: rgb(215, 44, 33);
        }
    </style>
</head>

<body>

    <?php
    require_once __DIR__ . '/carclass.php';
    require_once '../db.php';
    session_start();

    $carid = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
    $stmt->bind_param("i", $carid);
    $stmt->execute();
    $carData = $stmt->get_result()->fetch_assoc();

    if (!$carData) {
        die("Car not found.");
    }

    $stmt = $conn->prepare("SELECT * FROM car_specs WHERE car_id = ?");
    $stmt->bind_param("i", $carid);
    $stmt->execute();
    $specs = $stmt->get_result()->fetch_assoc();

    $images = [];
    $result = $conn->query("SELECT imgurl FROM carimages WHERE carid = $carid");
    while ($img = $result->fetch_assoc()) {
        $images[] = $img['imgurl'];
    }

    $features = [
        $specs['air_conditioning'] => "../images/Cars/AirConditioning.png",
        $specs['number_of_doors'] . " Doors" => "../images/Cars/Doors.png",
        $specs['transmission_type'] => "../images/Cars/Automatike.webp"
    ];

    $morefeatures = [];
    $result = $conn->query("SELECT name FROM carextras WHERE car_id = $carid");
    while ($row = $result->fetch_assoc()) {
        $morefeatures[] = $row['name'];
    }

    $car = new CarDetails(
        $carid,
        $carData['name'],
        $carData['price'],
        $images,
        $specs['passenger_capacity'] ?? 0,
        $specs['suitcase_capacity'] ?? 0,
        $features,
        $morefeatures
    );

    $cars = allcars($conn);
    shuffle($cars);
    $cars = array_slice($cars, 0, 6);

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
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
            <div class="price4">
                <div style="display: flex; justify-content: space-between;">
                    <h1><?= $car->getname() ?></h1>
                    <form action="removecar.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this car?');">
                        <input type="hidden" name="car_id" value="<?= $carid ?>">
                        <button type="submit" class="btnrezervo" style="background-color: #c4291d;">Remove Car</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="price4">
                <h1><?= $car->getname() ?></h1>
            </div>
        <?php } ?>

    <section class="all">
        <div class="container20">
            <div class="slide20">
                <?php foreach ($car->getimages() as $image): ?>
                    <div class="item" style="background-image: url(<?= $image ?>);"></div>
                <?php endforeach; ?>
            </div>
            <div class="button">
                <button class="prev2"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="next2"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        <div class="right2">
            <div class="car-features">
                <h3>Car features</h3>
                <?php foreach ($car->features as $name => $img): ?>
                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                        <img src="<?= $img ?>" alt="<?= $name ?>" width="30" height="30" style="margin-right: 10px;">
                        <p style="margin: 0;"><?= $name ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="Capacity">
                <h3>Capacity</h3>
                <p><i class="fa-solid fa-person" style="margin-right: 17px;"></i> <?= $car->seats ?> Passengers</p>
                <p><i class="fa-solid fa-suitcase" style="margin-right: 15px;"></i><?= $car->suitcase ?> Suitcase</p>
            </div>
            <div class="Extra">
                <h3>Extra</h3>
                <div class="extra-button">
                    <?php foreach ($car->morefeatures as $more): ?>
                        <button><?= $more ?></button>
                    <?php endforeach; ?>
                </div>
                <div class="rezervo">
                    <div>
                        <h3 style="color: #393939;">Price</h3>
                        <b style="color: #393939; font-size: 25px;"><span id="dailyCost"><?= $car->price ?></span>€ / <span style="color: orange;">DAY</span></b>
                    </div>
                    <button class="btnrezervo" onclick="rezervo()">Book Now</button>
                </div>
            </div>
        </div>
    </section>

    <section class="car_container">
        <h1 style="padding: 30px 0 20px 0; width: 87%; color: #393939;">Other Cars You Might Like</h1>
        <div class="container12 goTop">
            <?php foreach ($cars as $car): ?>
                <div class="card5">
                    <div class="slider">
                        <div class="slides">
                            <?php foreach ($car->images as $img): ?>
                                <a href="cardetails.php?id=<?= $car->id ?>">
                                    <img class="slide" src="<?= $img ?>" alt="Image">
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <button class="prev" onclick="prevSlide()">&#10094;</button>
                        <button class="next" onclick="nextSlide()">&#10095;</button>
                    </div>
                    <div class="badge">600Kms included. After that $15/Kms</div>
                    <div class="card-body">
                        <a href="cardetails.php?id=<?= $car->id ?>" style="text-decoration: none; color: black;">
                            <div>
                                <div class="card-title"><?= $car->name ?></div>
                                <p class="paragraph"><?= $car->type ?> | AC | <?= $car->seats ?> Seats</p>
                                <div class="card-details">
                                    <?php foreach ($car->details as $detail): ?>
                                        <div class="detail"><?= $detail ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="price-section">
                                    <div class="price-section2">
                                        <div class="discount"><?= $car->discount ?>% Off</div>
                                        <div class="price">US$<?= $car->price ?>
                                            <span class="old-price">US$<?= $car->oldPrice ?></span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="reviews">Exceptional <br><?= $car->reviews ?> reviews</div>
                                        <div class="score"><?= $car->reviewScore ?></div>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
                                    <div class="Detajet">
                                        <button style="width: 80%;">More</button>
                                        <form action="removecar.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this car?');" style="width: 20%;">
                                            <input type="hidden" name="car_id" value="<?= $car->id ?>">
                                            <button type="submit" style="width: 100%; background-color: #e74c3c;">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="Detajet">
                                        <button style="width: 100%;">More</button>
                                    </div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>
<script src="../script/cars.js" defer></script>
</html>
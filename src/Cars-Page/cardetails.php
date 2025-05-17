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

    <div class="container15">
        <div class="pick">
            <p>Pick up location</p>
            <h3>Los Angeles International Airport</h3>
            <input type="date" id="pickup-input">
            <h5 id="pickup-date"></h5>
        </div>
        <div class="pick">
            <p>Drop off location</p>
            <h3>Los Angeles International Airport</h3>
            <input type="date" id="dropoff-input">
            <h5 id="dropoff-date"></h5>
        </div>
        <div class="pick">
            <p>Duration</p>
            <h4 id="duration">0 Day(s)</h4>
        </div>
        <div class="pick">
            <p>Total</p>
            <h4 id="total-cost">00.00 €</h4>
        </div>
    </div>

    <br>
    <hr style="background-color: lightgray;height: 2px;">
    <div class="price4">
        <h1><?= $car->getname() ?></h1>
        <h1><span id="dailyCost"><?= $car->price ?></span>€ / <span style="color: orange;">DAY</span></h1>
    </div>

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
                    <p>Press the button to book it!</p>
                    <button class="btnrezervo" onclick="rezervo()">Book Now</button>
                </div>
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Booking completed successfully!</h2>
                        <p>Thank you for booking.</p>
                        <button class="btn-ok" onclick="closeModal()">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer style="margin-top: 100px;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
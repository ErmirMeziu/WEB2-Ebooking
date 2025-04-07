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
        class Car {
            public $id, $name, $price, $images, $seats, $suitcase, $features, $morefeatures;

            public function __construct($id, $name, $price, $images, $seats, $suitcase, $features, $morefeatures) {
                $this->id = $id;
                $this->name = $name;
                $this->price = $price;
                $this->images = $images;
                $this->seats = $seats;
                $this->suitcase = $suitcase;
                $this->features = $features;
                $this->morefeatures = $morefeatures;
            }
        }

        $cars = [
            new Car(0, "BMW 520d xDrive", 259.2, 
                [
                    "../images/Cars/bmw-520d/bmw-520d1.jpg",
                    "../images/Cars/bmw-520d/bmw-520d2.jpg",
                    "../images/Cars/bmw-520d/bmw-520d3.jpg"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Radio", "Air Condition"]
            ),
            new Car(1, "Skoda Scala", 64,
                [
                    "../images/Cars/skoda-skala/skoda-skala1.jpg",
                    "../images/Cars/skoda-skala/skoda-skala2.jpg",
                    "../images/Cars/skoda-skala/skoda-skala3.jpg"
                ],
                4, 1,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Radio", "Air Condition"]
            ),
            new Car(2, "BMW 320d xDrive", 98,
                [
                    "../images/Cars/bmw-320d/bmw320d1.jpg",
                    "../images/Cars/bmw-320d/bmw320d2.jpg",
                    "../images/Cars/bmw-320d/bmw320d3.jpg"
                ],
                5, 2, 
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Radio", "Air Condition"]
            ),
            new Car(3, "Audi A4", 72,
                [
                    "../images/Cars/audiA4/audiA4-1.jpg",
                    "../images/Cars/audiA4/audiA4-2.jpg",
                    "../images/Cars/audiA4/audiA4-3.jpg"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Air Condition"]
            ),
            new Car(4, "Skoda Rapid", 68,
                [
                    "../images/Cars/skoda-rapid/skoda-rapid1.jpg",
                    "../images/Cars/skoda-rapid/skoda-rapid2.jpg",
                    "../images/Cars/skoda-rapid/skoda-rapid3.jpg"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Air Condition"]
            ),
            new Car(5, "Mercedes-Benz GLE 400d", 348,
                [
                    "../images/Cars/gle400d/gle400D1.jpg",
                    "../images/Cars/gle400d/gle400D2.jpg",
                    "../images/Cars/gle400d/gle400D3.jpg"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Radio", "Air Condition"]
            ),
            new Car(6, "BMW X5 xDrive", 230,
                [
                    "../images/Cars/bmwX5/bmwX5-1.jpg",
                    "../images/Cars/bmwX5/bmwX5-2.jpg",
                    "../images/Cars/bmwX5/bmwX5-3.jpg"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Radio", "Air Condition"]
            ),
            new Car(7, "Golf 8", 63,
                [
                    "../images/Cars/golf8/g8-1.jpg",
                    "../images/Cars/golf8/g8-2.jpg",
                    "../images/Cars/golf8/g8-3.jpg"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Airbag", "Bluetooth", "Radio", "Air Condition"]
            ),
            new Car(8, "Audi Q8", 396,
                [
                    "../images/Cars/audiQ8/audiQ8-1.jpg",
                    "../images/Cars/audiQ8/audiQ8-2.jpg",
                    "../images/Cars/audiQ8/audiQ8-3.webp"
                ],
                5, 2,
                [
                    ["../images/Cars/AirConditioning.png", "Air Conditioning"],
                    ["../images/Cars/Doors.png", "5 Doors"],
                    ["../images/Cars/Automatike.webp", "Transmission Automatic"],
                ],
                ["Bluetooth", "Air Condition"]
            )
        ];        
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;

        if (!isset($cars[$id])) {
            echo "Car not found.";
            exit;
        }

        $car = $cars[$id];
    ?>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <section id="all">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/login_register.php'); ?>

        <script>
            setTimeout(() => {
                const script = document.createElement('script');
                script.src = '/WEB2-Ebooking/src/script/login-register.js';
                document.body.appendChild(script);
            }, 50);
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
        <h1><?= $car->name ?></h1>
        <h1><span id="dailyCost"><?= $car->price ?></span>€ / <span style="color: orange;">DAY</span></h1>
    </div>

    <div class="video-overlay"></div>
    <div class="video">
        <video width="100%" height="100%" controls>
            <source src="<?= $car->video ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <section class="all">
        <div class="container20">
            <div class="slide20">
                <?php for ($i = 0; $i < count($car->images); $i++): ?>
                    <div class="item" style="background-image: url(<?= $car->images[$i] ?>);"></div>
                <?php endfor; ?>
            </div>
            <div class="button">
                <button class="prev2"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="next2"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        <div class="right2">
            <div class="car-features">
                <h3>Car features</h3>
                <?php for($i = 0; $i < count($car->features); $i++): ?>
                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                        <img src="<?= $car->features[$i][0] ?>" alt="" width="30" height="30" style="margin-right: 10px;">
                        <p style="margin: 0;"><?= $car->features[$i][1] ?></p>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="Capacity">
                <h3>Capacity</h3>
                <p><i class="fa-solid fa-person" style="margin-right: 17px;"></i> <?= $car->seats ?> Passengers</p>
                <p><i class="fa-solid fa-suitcase" style="margin-right: 15px;"></i><?= $car->suitcase ?> Suitcase</p>
            </div>
            <div class="Extra">
                <h3>Extra</h3>
                <div class="extra-button">
                    <?php for($i = 0; $i < count($car->morefeatures); $i++): ?>
                        <button><?= $car->morefeatures[$i] ?></button>
                <?php endfor; ?>
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
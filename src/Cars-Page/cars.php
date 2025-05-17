<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Tour & Travel Booking</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/cars.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/login-register.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">


    <script src="../script/cars.js" defer></script>

    <style>
        #cars {
            color: rgb(215, 44, 33);
        }
    </style>
</head>

<?php
    require_once __DIR__ . '/carclass.php';
    include '../db.php'; 

    function addcars($conn, $visible) {
        $cars = [];
        $query = "SELECT * FROM cars WHERE $visible";
        $result = $conn->query($query);

        while ($eachrow = $result->fetch_assoc()) {
            $carid = $eachrow['id'];

            $details = [];
            $eachdetail = $conn->query("SELECT details FROM cardetails WHERE carid = $carid");
            while ($d = $eachdetail->fetch_assoc()) {
                $details[] = $d['details'];
            }

            $images = [];
            $eachimage = $conn->query("SELECT imgurl FROM carimages WHERE carid = $carid");
            while ($img = $eachimage->fetch_assoc()) {
                $images[] = $img['imgurl'];
            }

            $cars[] = (object)[
                'id' => $eachrow['id'],
                'name' => $eachrow['name'],
                'type' => $eachrow['type'],
                'seats' => $eachrow['seats'],
                'price' => $eachrow['price'],
                'oldPrice' => $eachrow['oldprice'],
                'discount' => $eachrow['discount'],
                'reviews' => $eachrow['reviews'],
                'reviewScore' => $eachrow['reviewscore'],
                'details' => $details,
                'images' => $images
            ];
        }
        return $cars;
    }

    $cars = addcars($conn, "id <= 6");
    $hiddenCars = addcars($conn, "id > 6");
?>

<body>
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

    <section>
        <div class="container-video">
        </div>
        <div class="home">
            <video class="background-video" autoplay muted loop style="margin-top:76px;">
                <source src="../Video/Car.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <div class="home-text">
                <h1>Starts Your Trip With GeoTrip</h1>
                <p>Take a little break from the work stress of everyday. Discover plan trip and explore beautiful
                    <br>
                    destinations.
                </p>
            </div>
            <div class="search">
                <form action="" method="post" class="search-bar">
                    <fieldset class="where-date">
                        <legend>Where</legend>
                        <input type="text" name="going-to" id="going-to" placeholder="Going To">
                    </fieldset>
                    <fieldset class="where-date">
                        <legend>Choose Date</legend>
                        <input type="date" name="date" id="date" min="2025-01-01">
                    </fieldset>
                    <fieldset class="memb">
                        <legend>Members</legend>
                        <input type="number" name="members" id="members" min="0">
                    </fieldset>
                </form>
                <button><i class="fa-solid fa-magnifying-glass loop"></i>Search</button>
            </div>
        </div>
    </section>

    <div class="text">
        <h1>
            Out Awesome Vehicles
        </h1>
        <p>Cicero famously orated against his political opponent Lucius Sergius Catilina.</p>
    </div>

    <section class="car_container">
        <div class="container12 goTop">
            <?php foreach ($cars as $car): ?>
                <div class="card5">
                    <div class="slider">
                        <div class="slides">
                            <?php foreach ($car->images as $img): ?>
                                <a href="cardetails.php?id=<?= $car->id?>">
                                    <img class="slide" src="<?= $img ?>" alt="Image">
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <button class="prev" onclick="prevSlide()">&#10094;</button>
                        <button class="next" onclick="nextSlide()">&#10095;</button>
                    </div>
                    <div class="badge">600Kms included. After that $15/Kms</div>
                    <div class="card-body">
                        <a href="cardetails.php?id=<?= $car->id?>" style="text-decoration: none; color: black;">
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
                                <div class="Detajet">
                                    <button style="width: 100%;">More</button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="toHide">
                <?php foreach ($hiddenCars as $car): ?>
                    <div class="card5 goTop">
                        <div class="slider">
                            <div class="slides">
                                <?php foreach ($car->images as $img): ?>
                                    <a href="cardetails.php?id=<?= $car->id?>">
                                        <img class="slide" src="<?= $img ?>" alt="Image">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <button class="prev" onclick="prevSlide()">&#10094;</button>
                            <button class="next" onclick="nextSlide()">&#10095;</button>
                        </div>
                        <div class="badge">600Kms included. After that $15/Kms</div>
                        <div class="card-body">
                            <a href="cardetails.php?id=<?= $car->id?>" style="text-decoration: none; color: black;">
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
                                    <div class="Detajet">
                                        <button style="width: 100%;">More</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <button class="view-more">VIEW MORE</button></div>
    </section>

    <abbr title="Go up button">
        <a href="#" class="gotopbtn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <path fill="#ffffff"
                    d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2 160 448c0 17.7 14.3 32 32 32s32-14.3 32-32l0-306.7L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" />
            </svg>
        </a>
    </abbr>

    <footer style="margin-top: 50px; background-color: white;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
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
    
    $cars = allcars($conn);
?>

<body>
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
        </div>
    </section>

    <section>
        <div class="text">
            <h1>Our Awesome Vehicles</h1>
            <p>Cicero famously orated against his political opponent Lucius Sergius Catilina.</p>
        </div>
    </section>

    <section class="car_container" style="position: relative;">
        <?php
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            echo '
            <div class="top">
            <div class="adCar">
                <a href="/WEB2-Ebooking/src/Cars-Page/addcar.php"><button class="addCar"><i class="fa-solid fa-plus"></i></button></a>';

            echo '
                <a href=""><button class="deleteCar"><i class="fa-solid fa-minus"></i></button></a>
            </div>
            </div>';
        }
        ?>
        <div class="container12">
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
        <abbr title="Go up button"><a href="#" class="gotopbtn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="#ffffff" d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2 160 448c0 17.7 14.3 32 32 32s32-14.3 32-32l0-306.7L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" /></svg></a></abbr>

    <footer style="margin-top: 30px; background-color: white;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
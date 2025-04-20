<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GeoTrip - Tour & Travel Booking</title>

    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/login-register.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">

    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <script src="script/home.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .home-text {
            color: white;
            text-align: center;
        }

        #home {
            color: rgb(215, 44, 33);
        }
    </style>


</head>

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

    <div style="position: relative;" style="width: 100%; height: 100%;">
        <div class="page-container">
            <div class="sidebar">
                <a href="index.php" style="color: rgb(215, 44, 33);"><i class="fa-solid fa-hotel icon"></i>Home</a>
                <a href="/Hotel Page/hotels.php"><i class="fa-solid fa-hotel icon"></i>Hotels</a>
                <a href="Cars-Page/cars.php"><i class="fa-solid fa-car icon"></i>Cars</a>
                <a href="AboutUs.php"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
            </div>
        </div>
    </div>

    <section>
        <div class="home">
            <div class="home-text">
                <h1>Starts Your Trip With GeoTrip</h1>
                <p>Take a little break from the work stress of everyday. Discover plan trip and explore
                    beautiful
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
                    <button><i class="fa-solid fa-magnifying-glass loop"></i>Search</button>
                </form>
            </div>
        </div>

        <?php
        class VacationDiscount
        {
            public $title;
            public $discountPercentage;
            public $imagePath;
            public $valid;

            public function __construct($title, $discountPercentage, $imagePath, $valid)
            {
                $this->title = $title;
                $this->discountPercentage = $discountPercentage;
                $this->imagePath = $imagePath;
                $this->valid = $valid;
            }
        }
        $offers = [
            new VacationDiscount("30% Off On Summer <br> Vacation", 30, "images/adds/destination-sales.webp", "Valid 31 March 2025"),
            new VacationDiscount("20% Off On Domestic <br> Holiday", 20, "images/adds/destination-sales.webp", "Valid 31 March 2025"),
            new VacationDiscount("40% Off On Winter <br> Holiday", 40, "images/adds/destination-sales.webp", "Valid 31 March 2025")
        ];

        usort($offers, function ($a, $b) {
            return $b->discountPercentage > $a->discountPercentage;
        });
        ?>

        <div class="sales-container">
            <?php foreach ($offers as $offer): ?>
                <div class="sales">
                    <div class="image">
                        <img src="<?= $offer->imagePath ?>" alt="destination photo" width="80" height="80">
                    </div>
                    <div class="offpercent">
                        <h4><?= $offer->title ?></h4>
                        <p><small><?= $offer->valid ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="rental">

        <?php

        abstract class Rental
        {
            public $imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews;
            public function __construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews)
            {
                $this->imagePath = $imagePath;
                $this->name = $name;
                $this->details = $details;
                $this->discount = $discount;
                $this->price = $price;
                $this->numberOfStars = $numberOfStars;
                $this->review = $review;
                $this->numberOfReviews = $numberOfReviews;
            }

            abstract public function getRentalType();
        }
        class House extends Rental
        {
            const TYPE = 'House';

            public function __construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews)
            {
                parent::__construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews);
            }

            public function getRentalType()
            {
                return self::TYPE;
            }
        }

        class Villa extends Rental
        {
            const TYPE = 'Villa';

            public function __construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews)
            {
                parent::__construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews);
            }

            public function getRentalType()
            {
                return self::TYPE;
            }
        }

        class Apartment extends Rental
        {
            const TYPE = 'Apartment';

            public function __construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews)
            {
                parent::__construct($imagePath, $name, $details, $discount, $price, $numberOfStars, $review, $numberOfReviews);
            }

            public function getRentalType()
            {
                return self::TYPE;
            }
        }


        $rentals = [
            new House("images/property/property1.webp", "Haven Group Real Estate", ["3 Beds", "3 Baths", "2100 sqft"], 15, 492, 5, 4.6, 142),
            new Villa("images/property/property2.webp", "Brick Lane Reality", ["3 Beds", "3 Baths", "2100 sqft"], 16, 430, 3, 4.3, 201),
            new House("images/property/property3.webp", "Exclesior Real Estate", ["3 Beds", "3 Baths", "2100 sqft"], 11, 512, 4, 4.4, 101)
        ]
            ?>
        <div class="top">
            <h4>Featured Rental In Australia</h4>
            <a href="Hotel Page/hotels.php"><button>More <i class="fa-solid fa-arrow-trend-up ms-2"></i></button></a>
        </div>
        <div id="card-container" class="card-container" style="color: rgb(5,38,78); height: 450px;">
            <div class="card-different responsive">
                <img src="images/property/property-different.png" alt="Jackson ville">
                <h4>
                    Discover great deals on hotels around the world <br>
                    <a href="Hotel Page/hotels.php"><button>Go Now</button></a>
                </h4>
            </div>
            <?php foreach ($rentals as $rental): ?>

                <div class="card responsive">
                    <div class="image">
                        <img src="<?= $rental->imagePath ?>" alt="">
                    </div>
                    <div class="card-container1">
                        <div class="head">
                            <button style="width: auto; padding: 3px 7px;"><?= $rental->getRentalType() ?></button>
                            <h5><?= $rental->name ?></h5>
                        </div>
                        <div class="property-same" style="position: relative; top: 7px;">
                            <?php foreach ($rental->details as $detail): ?>
                                <div><a href=""> <?= $detail ?> </a></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="end">
                            <div class="left">
                                <button><?= $rental->discount ?>% Off</button>
                                <h4>From <b>$<?= $rental->price ?></b></h4>
                            </div>
                            <div class="right">
                                <p style="position: relative; top: 5px; right: 2px; ">
                                    <?php for ($i = 0; $i < $rental->numberOfStars; $i++): ?>
                                        <i class="fa-sharp fa-solid fa-star fa-sm" style="color: #ffc800;"></i>
                                    <?php endfor; ?>
                                </p>
                                <h5> <?= $rental->review ?> <span>(<?= $rental->numberOfReviews ?> reviews)</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section>
        <div class="top">
            <h4>Browse Popular Destinations</h4>
            <button>More<i class="fa-solid fa-arrow-trend-up ms-2"></i></button>

        </div>
        <div class="container4">
            <div class="card1 responsive">
                <img src="images/destinations/Los Angelos.webp" alt="">
                <div class="container2">
                    <div class="text1">

                        <h2>Los Angeles</h2>
                    </div>
                    <div class="button3">
                        <button>Discover</button>
                    </div>
                </div>
            </div>
            <div class="card1 responsive">
                <img src="images/destinations/Chicago.webp" alt="">
                <div class="container2">
                    <div class="text1">
                        <h2>Chicago</h2>
                    </div>
                    <div class="button3">
                        <button>Discover</button>
                    </div>
                </div>

            </div>
            <div class="card1 responsive">
                <img src="images/destinations/Las Vegas.webp" alt="">
                <div class="container2">
                    <div class="text1">
                        <h2>Las Vegas</h2>
                    </div>
                    <div class="button3">
                        <button>Discover</button>
                    </div>
                </div>

            </div>
            <div class="card1 responsive">

                <img src="images/destinations/New Orleans.webp" alt="">
                <div class="container2">
                    <div class="text1">
                        <h2>New Orleans</h2>
                    </div>
                    <div class="button3">
                        <button>Discover</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="app">
        <nav class="app-container">
            <nav class="left">
                <nav class="download">
                    <img src="images/download-photo/app-link.png" style="width: 60px; height: 60px;" alt=""
                        id="downloaded">
                    <nav class="download-app">
                        <h4><mark style="background-color: rgb(255,230,229);">Download App Now!</mark></h4>
                        <p>Use code <span style="color: orangered;">WELCOME</span> and get <span
                                style="color: rgb(69,171,118);">FLAT 20%</span>
                            OFF on your first<br>domestic flight booking</p>
                    </nav>
                </nav>
                <nav class="mobile">
                    <form action="" method="post">
                        <label for="mobile-number">+91 - </label>
                        <input type="text" name="mobile-number" id="mobile-number" placeholder="Enter Mobile Number">
                    </form>
                    <button>Get App Link</button>
                </nav>
            </nav>
            <nav class="right">
                <nav class="playstore">
                    <i class="fa-brands fa-google-play text-light fs-1"></i>
                    <nav class="same">
                        <p class="pragraph" style="color: #cacee4; font-weight: 500">GET IT ON </p>
                        <p>Google Play</span></p>
                    </nav>
                </nav>
                <nav class="appstore">
                    <i class="fa-brands fa-apple text-light fs-1"></i>
                    <nav class="same">
                        <p class="pragraph" style="color: #cacee4; font-weight: 500;">DOWNLOAD ON THE </p>
                        <p>App Store</p>
                    </nav>
                </nav>
            </nav>
        </nav>
    </section>

    <section class="destinations">
        <?php
        abstract class Car
        {
            public $imagePath, $name, $numberOfSeats, $details, $discount, $price, $oldPrice, $numberOfReviews, $reviewScore;
            protected $type;

            public function __construct($imagePath, $name, $numberOfSeats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore)
            {
                $this->imagePath = $imagePath;
                $this->name = $name;
                $this->numberOfSeats = $numberOfSeats;
                $this->details = $details;
                $this->discount = $discount;
                $this->oldPrice = $oldPrice;
                $this->numberOfReviews = $numberOfReviews;
                $this->reviewScore = $reviewScore;
                $this->calculatePrice();
            }

            private function calculatePrice()
            {
                $this->price = $this->oldPrice - $this->discount / 100 * $this->oldPrice;
            }

            public function setDiscount($discount)
            {
                $this->discount = $discount;
                $this->calculatePrice();
            }

            abstract public function getCarType();


            public function __destruct()
            {
                echo "The car object {$this->name} is being destroyed.\n";
            }

        }

        class SUV extends Car
        {
            public function __construct($imagePaths, $name, $numberOfSeats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore, $fourWheelDrive = true)
            {
                parent::__construct($imagePaths, $name, $numberOfSeats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore);
                $this->type = "SUV";
            }
            public function getCarType()
            {
                return $this->type;
            }

        }

        class Sedan extends Car
        {
            public function __construct($imagePaths, $name, $numberOfSeats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore, $fourWheelDrive = true)
            {
                parent::__construct($imagePaths, $name, $numberOfSeats, $details, $discount, $oldPrice, $numberOfReviews, $reviewScore);
                $this->type = "Sedan";
            }
            public function getCarType()
            {
                return $this->type;
            }
        }

        $cars = [
            new SUV("images/Cars/audiQ8/audiQ8-1.jpg", "Audi Q8", 5, ["Automatic", "1 Large bag", "1 Small bag"], 12, 450, 3219, 4.8),
            new Sedan("images/Cars/bmw-520d/bmw-520d1.jpg", "BMW 520d xDrive", 4, ["Automatic", "1 Large bag", "1 Small bag"], 19, 370, 3014, 4.9),
            new SUV("images/Cars/gle400d/gle400D1.jpg", "Mercedes-Benz GLE 400d", 5, ["Automatic", "1 Large bag", "1 Small bag"], 20, 435, 3014, 4.4)
        ]
            ?>


        <div class="top">
            <h4>Featured Rental Cars</h4>
            <a href="Cars-Page/cars.php">
                <button>More <i class="fa-solid fa-arrow-trend-up ms-2"></i></button>
            </a>
        </div>
        <div class="cars">

            <?php foreach ($cars as $car): ?>
                <div class="card5">
                    <div style="height: 50%">
                        <img src="<?= $car->imagePath ?>" alt="">
                    </div>

                    <div class="card-body">
                        <div>
                            <div class="card-title"><?= $car->name ?></div>
                            <p class="paragraph"><?= $car->getCarType() ?> | AC | <?= $car->numberOfSeats ?> Seats</p>
                            <div class="card-details">
                                <?php foreach ($car->details as $detail): ?>
                                    <div class="detail"><?= $detail ?></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="price-section">
                                <div class="price-section2">
                                    <div class="discount"><?= $car->discount ?>% Off</div>
                                    <div class="price" style="font-size: 18px;"> US$<?= $car->price ?> <span
                                            class="old-price">US$<?= $car->oldPrice ?></span></div>
                                </div>
                                <div class="rating">
                                    <div class="reviews">Exceptional <br><?= $car->numberOfReviews ?> reviews</div>
                                    <div class="score"><?= $car->reviewScore ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

            <div class="routes-different routes-different-image responsive">
                <img src="images/routes/tr-4.webp" alt="Discover deals">
                <h4>
                    Discover great deals on cars around the world <br>
                    <a href="Cars-Page/cars.php"><button>Go Now</button></a>
                </h4>
            </div>
        </div>
    </section>

    <section class="international-routes-container ">
        <div class="top">
            <h4>All International Routes</h4>
            <!-- <button>More <i class="fa-solid fa-arrow-trend-up ms-2"></i></button> -->
        </div>

        <div class="buttons">
            <button>Flights To Popular Countries</button>
            <button class="button-different">Flights To Popular Destinations</button>
            <button class="button-different">Popular Flights</button>
            <button class="button-different">Popular Airlines</button>
        </div>
        <div class="international-routes">
            <div class="all-flights">
                <table>
                    <thead>
                        <tr>
                            <th>Flight To France</th>
                            <th>Flight To South Korea</th>
                            <th>Flight To Thailand</th>
                            <th>Flight To Liverpool</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Flight To Turkey</td>
                            <td>Flight To Spain</td>
                            <td>Flight To New York</td>
                            <td>Flight To Indonesia</td>
                        </tr>
                        <tr>
                            <td>Flight To Japan</td>
                            <td>Flight To Mexico</td>
                            <td>Flight To Russia</td>
                            <td>Flight To China</td>
                        </tr>
                        <tr>
                            <td>Flight To Italy</td>
                            <td>Flight To Austria</td>
                            <td>Flight To Vietnam</td>
                            <td>Flight To Zarmeny</td>
                        </tr>
                        <tr>
                            <td>Flight To Poland</td>
                            <td>Flight To Canada</td>
                            <td>Flight To Denver</td>
                            <td>Flight To Portugal</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section>
        <div class="home1">
            <div class="home2">
                <h4>Subscribe & Get </h4>
                <h4>Special discount with GeoTrip.com</h4>
                <div class="home-search1">
                    <div class="input1">
                        <input type="email" placeholder="Enter your email">
                    </div>
                    <div class="button1">
                        <input type="submit" value="Submit ">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <abbr title="Go up button">
        <a href="#" class="gotopbtn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <path fill="#ffffff"
                    d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2 160 448c0 17.7 14.3 32 32 32s32-14.3 32-32l0-306.7L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" />
            </svg>
        </a>
    </abbr>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

</body>

</html>
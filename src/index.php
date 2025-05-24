<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>GeoTrip - Tour & Travel Booking</title>

    <link rel="icon" href="images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="styles/navbar.css" />
    <link rel="stylesheet" href="styles/footer.css" />
    <link rel="stylesheet" href="styles/site_review.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="styles/home.css" />
    <link rel="stylesheet" href="styles/login-register.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" />

    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <script src="script/home.js" defer></script>
    <script src="script/site_review.js" defer></script>

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

<?php


session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $rating = floatval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO site_reviews (user_id, rating, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $user_id, $rating, $comment);
        $stmt->execute();
        $stmt->close();


        header('Location: index.php?review_success=1');
        exit;
    } else {

        header('Location: index.php?error=1');
        exit;
    }
}

require_once __DIR__ . '/Cars-Page/carclass.php';
include 'db.php';

function getThreeCars($conn)
{
    $cars = [];
    $result = $conn->query("SELECT * FROM cars LIMIT 3");

    while ($row = $result->fetch_assoc()) {
        $carid = $row['id'];

        // Merr detajet
        $details = [];
        $detailResult = $conn->query("SELECT details FROM cardetails WHERE carid = $carid");
        while ($d = $detailResult->fetch_assoc()) {
            $details[] = $d['details'];
        }

        $images = [];
        $imageResult = $conn->query("SELECT imgurl FROM carimages WHERE carid = $carid");
        while ($img = $imageResult->fetch_assoc()) {
            $images[] = $img['imgurl'];
        }

        $car = new CarList(
            $images,
            $row['name'],
            $row['type'],
            $row['seats'],
            $details,
            $row['discount'],
            $row['oldprice'],
            $row['reviews'],
            $row['reviewscore']
        );

        $cars[] = $car;
    }

    return $cars;
}

$cars = getThreeCars($conn);

function getRentalsFromDB($conn)
{
    $rentals = [];

    $result = $conn->query("SELECT * FROM rentals LIMIT 3");

    while ($row = $result->fetch_assoc()) {
        $details = array_filter([$row['detail1'], $row['detail2'], $row['detail3']]);

        switch ($row['type']) {
            case 'House':
                $rentals[] = new House(
                    $row['imagePath'],
                    $row['name'],
                    $details,
                    $row['discount'],
                    $row['price'],
                    $row['numberOfStars'],
                    $row['review'],
                    $row['numberOfReviews']
                );
                break;
            case 'Villa':
                $rentals[] = new Villa(
                    $row['imagePath'],
                    $row['name'],
                    $details,
                    $row['discount'],
                    $row['price'],
                    $row['numberOfStars'],
                    $row['review'],
                    $row['numberOfReviews']
                );
                break;
            case 'Apartment':
                $rentals[] = new Apartment(
                    $row['imagePath'],
                    $row['name'],
                    $details,
                    $row['discount'],
                    $row['price'],
                    $row['numberOfStars'],
                    $row['review'],
                    $row['numberOfReviews']
                );
                break;
        }
    }

    return $rentals;
}

$rentals = getRentalsFromDB($conn);

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
                        <img src="<?= htmlspecialchars($rental->imagePath) ?>" alt="">
                    </div>
                    <div class="card-container1">
                        <div class="head">
                            <button
                                style="width: auto; padding: 3px 7px;"><?= htmlspecialchars($rental->getRentalType()) ?></button>
                            <h5><?= htmlspecialchars($rental->name) ?></h5>
                        </div>
                        <div class="property-same" style="position: relative; top: 7px;">
                            <?php foreach ($rental->details as $detail): ?>
                                <div><a href=""><?= htmlspecialchars($detail) ?></a></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="end">
                            <div class="left">
                                <button><?= htmlspecialchars($rental->discount) ?>% Off</button>
                                <h4>From <b>$<?= htmlspecialchars($rental->price) ?></b></h4>
                            </div>
                            <div class="right">
                                <p style="position: relative; top: 5px; right: 2px;">
                                    <?php for ($i = 0; $i < $rental->numberOfStars; $i++): ?>
                                        <i class="fa-sharp fa-solid fa-star fa-sm" style="color: #ffc800;"></i>
                                    <?php endfor; ?>
                                </p>
                                <h5><?= htmlspecialchars($rental->review) ?>
                                    <span>(<?= htmlspecialchars($rental->numberOfReviews) ?> reviews)</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                            <div class="card-title"><?= $car->getName() ?></div>
                            <p class="paragraph"><?= $car->getCarType() ?> | AC | <?= $car->numberOfSeats ?> Seats</p>
                            <div class="card-details">
                                <?php
                                for ($i = 0; $i < 3 && $i < count($car->details); $i++): ?>
                                    <div class="detail"><?= htmlspecialchars($car->details[$i]) ?></div>
                                <?php endfor; ?>
                            </div>
                            <div class="price-section">
                                <div class="price-section2">
                                    <div class="discount"><?= $car->discount ?>% Off</div>
                                    <div class="price" style="font-size: 18px;">
                                        US$<?= $car->price ?>
                                        <span class="old-price">US$<?= $car->oldPrice ?></span>
                                    </div>
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

    <section id="reviews-section" class="reviews-wrapper">
        <button id="toggle-review-form" class="toggle-form-btn">Add a Review</button>

        <div id="review-modal" class="review-modal hidden">
            <div class="modal-content">
                <span id="close-modal" class="close-btn">&times;</span>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form id="site-review-form">
                        <h4>Submit Your Review</h4>

                        <div class="rating-container">
                            <label for="rating">Rating:</label>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star" data-value="<?= $i ?>">★</span>
                                <?php endfor; ?>
                                <input type="hidden" id="rating" name="rating" required>
                            </div>
                        </div>

                        <label for="comment">Your Review:</label>
                        <textarea id="comment" name="comment" required placeholder="Share your experience..."
                            rows="5"></textarea>

                        <button type="submit" class="submit-btn">Submit Review</button>
                    </form>
                    <p id="review-message"></p>
                <?php else: ?>
                    <p class="login-message">Please <a>log in</a> to leave a
                        review.</p>
                <?php endif; ?>
            </div>
        </div>
        <h3 class="reviews-title">Loving Reviews By Our Customers</h3>
        <p class="reviews-subtitle">Cicero famously orated against his political opponent Lucius Sergius Catilina.</p>
        <div class="reviews-grid">
            <?php
            $result = $conn->query("
            SELECT sr.rating, sr.comment, sr.created_at, u.name
            FROM site_reviews sr
            JOIN users u ON sr.user_id = u.id
            WHERE sr.status = 'approved'
            ORDER BY sr.created_at DESC
        ");

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    ?>
                    <div class="review-card">
                        <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
                        <div class="review-header">
                            <div class="review-photo">
                                <i class="fas fa-user-circle fa-3x"></i>
                            </div>
                            <div class="review-meta">
                                <h4 class="review-name"><?php echo htmlspecialchars($row['name']); ?></h4>
                                <p class="review-country">United States</p>
                                <div class="review-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $row['rating'] ? 'filled' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="review-comment"><?php echo htmlspecialchars($row['comment']); ?></p>
                    </div>
                    <?php
                endwhile;
            else:
                echo "<p class='no-reviews'>No reviews yet. Be the first to share your thoughts!</p>";
            endif;
            ?>
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Tour & Travel Booking</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/hotels.css">
    <script src="../script/hotel-mainpage.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="../styles/login-register.css">

    <style>
        #hotels {
            color: rgb(215, 44, 33);
        }
    </style>

</head>

<body class="body">

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
                <a href="/WEB2-Ebooking/src/index.php"><i class="fa-solid fa-hotel icon"></i>Home</a>
                <a href="/WEB2-Ebooking/src/Hotel Page/hotels.php" style="color: rgb(215, 44, 33);"><i
                        class="fa-solid fa-hotel icon"></i>Hotels</a>
                <a href="/WEB2-Ebooking/src/Cars-Page/cars.php"><i class="fa-solid fa-car icon"></i>Cars</a>
                <a href="/WEB2-Ebooking/src/AboutUs.php"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
            </div>
        </div>
    </div>

    <section class="search-bar">
        <div class="search-input">
            <fieldset>
                <legend>Where</legend>
                <input type="text" name="text" id="text" class="same" placeholder="Going To" list="locations"
                    list="locations"> <!--Kushti list-->
                <datalist id="locations">
                    <option value="Paris">
                    <option value="New York">
                    <option value="London">
                    <option value="Tokyo">
                    <option value="Dubai">
                    <option value="Rome">
                    <option value="Sydney">
                    <option value="Los Angeles">
                </datalist>
            </fieldset>

            <fieldset>
                <legend>CheckIn & CheckOut</legend>
                <input type="date" name="date" id="date" class="same" min="2025-01-01">
            </fieldset>

            <fieldset>
                <legend>Guests & Rooms</legend>
                <input type="number" name="number" id="number" min="1" class="same">
            </fieldset>

            <button><i class="fa-solid fa-magnifying-glass loop"></i>Search</button>
        </div>
    </section>

    <section class="hotel-body">
        <div class="section1">
            <div class="filter">
                <div class="filter-text">
                    <p id="text1">Filters</p>
                    <p id="text2">Clear all</p>
                </div>
                <div class="filter-text">
                    <p id="text3">Showing 180 Hotels</p>
                </div>
            </div>
            <hr>
            <div class="bed">
                <p>Bed Type</p>
                <div class="button-part">
                    <table style="width: 100%;">
                        <tr>
                            <td> 1 Double Bed</td>
                            <td>2 Beds</td>
                        </tr>
                        <tr>
                            <td>1 Single Bed</td>
                            <td>3 Beds</td>
                        </tr>
                        <tr>
                            <td> King Bed</td>
                            <td>Kid Bed</td>
                        </tr>
                    </table>

                </div>
            </div>
            <hr>
            <div class="pop-filter">
                <p>Popular Filters</p>
                <div class="select">
                    <form action="" method="post">
                        <input type="checkbox" name="check" id="check">
                        <label for="check">Free Cancellation Available</label>
                        <br>
                        <input type="checkbox" name="check1" id="check1">
                        <label for="check1">Book</label>
                        <br>
                        <input type="checkbox" name="check2" id="check2">
                        <label for="check2">Pay At Hotel Available</label>
                        <br>
                        <input type="checkbox" name="check4" id="check4">
                        <label for="check4">Free Breakfast Included</label>
                    </form>
                </div>
            </div>
            <hr>
            <div class="amenities-s">
                <p>Amenities</p>
                <div class="select">
                    <form action="" method="post">
                        <input type="checkbox" name="check5" id="check5">
                        <label for="check5">Free Wifi</label>
                        <br>
                        <input type="checkbox" name="check6" id="check6">
                        <label for="check6">3 Breakfast included</label>
                        <br>
                        <input type="checkbox" name="check7" id="check7">
                        <label for="check7">Air Conditioning</label>
                        <br>
                        <input type="checkbox" name="check8" id="check8">
                        <label for="check8">Pool</label>
                        <br>
                        <input type="checkbox" name="check9" id="check9">
                        <label for="check9">Free Parking</label>
                    </form>
                </div>
            </div>
            <hr>
            <div class="fun-things">
                <p>Fun things To Do</p>
                <div class="select">
                    <form action="" method="post">
                        <input type="checkbox" name="check10" id="check10">
                        <label for="check10">Beach</label>
                        <br>
                        <input type="checkbox" name="check11" id="check11">
                        <label for="check11">Fitness center</label>
                        <br>
                        <input type="checkbox" name="check12" id="check12">
                        <label for="check12">Cycling</label>
                        <br>
                        <input type="checkbox" name="check13" id="check13">
                        <label for="check13">Animation Show</label>
                        <br>
                        <input type="checkbox" name="check14" id="check14">
                        <label for="check14">Shopping center</label>
                    </form>
                </div>
            </div>
            <hr>
            <div class="costumer-rating">
                <p>Customer Ratings</p>
                <div class="select">
                    <form action="" method="post">
                        <div style="position: relative; bottom: 1.5px;">
                            <input type="radio" name="radio" id="radio1"><br>
                            <input type="radio" name="radio" id="radio2"><br>
                            <input type="radio" name="radio" id="radio3"><br>
                            <input type="radio" name="radio" id="radio4"><br>
                        </div>

                        <div class="star">
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p style="position: relative; left: 100px;">48</p>
                        </div>

                        <div class="star" id="position">
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star-half"></i></p>
                            <p style="position: relative; left: 100px;">20</p>
                        </div>

                        <div class="star" id="position2">
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p style="position: relative; left: 122px;">32</p>
                        </div>

                        <div class="star" id="position3">
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p><i class="fa-solid fa-star"></i></p>
                            <p style="position: relative; left: 148px;">8</p>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="sec2-parent">
            <div class="top-element">
                <p id="text">Showing 280 Search Results</p>

                <div class="input" style="background-color: #041625;">
                    <form action="">
                        <input type="number" name="lowest" id="lowest" class="lowest" placeholder="lowest" min="0"
                            step="50"> <!--Kushti (step)-->
                        <input type="number" name="lowest" id="highest" class="highest" placeholder="highest" min="0"
                            step="50">
                    </form>
                    <input type="submit" value="Submit" id="submit" class="submit"> <!--Kushti (value)-->
                </div>
            </div>

            <?php
            class HotelListing
            {
                public $name;
                public $location;
                public $imagePath;
                public $stars;
                public $features;
                public $roomType;
                public $lastBooked;
                public $cancellationPolicy;
                public $promo;
                public $rating;
                public $reviewCount;
                public $originalPrice;
                public $currentPrice;
                public $taxInfo;
                public $discount;
                private $link;
            
                public function __construct($name, $location, $imagePath, $stars, $features, $roomType, $lastBooked, $cancellationPolicy, $promo, $rating, $reviewCount, $originalPrice, $currentPrice, $taxInfo, $discount,$link)
                {
                    $this->name = $name;
                    $this->location = $location;
                    $this->imagePath = $imagePath;
                    $this->stars = $stars;
                    $this->features = $features;
                    $this->roomType = $roomType;
                    $this->lastBooked = $lastBooked;
                    $this->cancellationPolicy = $cancellationPolicy;
                    $this->promo = $promo;
                    $this->rating = $rating;
                    $this->reviewCount = $reviewCount;
                    $this->originalPrice = $originalPrice;
                    $this->currentPrice = $currentPrice;
                    $this->taxInfo = $taxInfo;
                    $this->discount = $discount;
                    $this->link = $link;

                }
                public function __getLink(){
                    return $this->link;
                }
                public function repeated(){
                    ?>
                 <div class="box">
                    <div class="section2">
                        <div class="hotel-img">
                            <a href="<?= $this->__getLink()?>" target="_blank"><img src="<?= $this->imagePath ?>"
                                    alt="Picture of hotel">
                            </a>
                        </div>
                        <div class="hotel-text">
                            <div class="star">
                                <?php for($i=0;$i<$this->stars;$i++):?>
                                    <p><i class="fa-solid fa-star"></i></p>
                                <?php endfor;?>
                            </div>
                            <p id="style-hotel-p"><?= $this->name ?></p>
                            <p id="text5"><?= $this->location ?></p>
                            <div class="hotel-offers">
                                <?php foreach ($this->features as $feature): ?>
                                    <p><?= $feature ?></p>
                                <?php endforeach; ?>
                            </div>
                            <div class="middle-text">
                                <p id="text6"><?= $this->roomType ?></p>
                                <p id="text7"><?= $this->lastBooked ?></p>
                            </div>
                            <div class="bottom-text">
                                <p id="text8"><?= $this->cancellationPolicy ?></p>
                                <p id="text9"><?= $this->promo ?></p>
                            </div>
                        </div>
                        <div class="hotel-button">
                            <div class="parent">
                                <div class="part1">
                                    <p id="text10">Exceptional</p>
                                    <p id="text11">
                                        <output name="reviews-count" id="reviews-count"><?= number_format($this->reviewCount) ?></output> reviews
                                    </p>
                                </div>
                                <button id="button"><?= $this->rating ?></button>
                            </div>
                            <div class="price-section">
                                <div class="discount-badge">
                                    <p><?= $this->discount ?></p>
                                </div>
                                <div class="price-details">
                                    <p class="original-price">US$<?= $this->originalPrice ?></p>
                                    <p class="current-price">$<?= $this->currentPrice ?></p>
                                    <p class="additional-info"><?= $this->taxInfo ?></p>
                                </div>
                                <button class="availability-button">See Availability</button>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                    
                }
            }

            $hotelsPage1 = [
                new HotelListing(
                    "Hotel Chancellor@Orchard",
                    "Waterloo and Southwark. 9.8 km from Delhi Airport",
                    "../images/hotel-photo/hotel-1.jpg",
                    5,
                    ["Parking", "Wifi", "Eating", "Cooling", "Pet"],
                    "Luxury Suite with Balcony",
                    "Last booked 25min ago",
                    "Free Cancellation, till 1 hour of Pick up",
                    "Login & get additional \$15 Off Using Visa card",
                    4.8,
                    3014,
                    120,
                    102,
                    "+ \$22 taxes & Fees<br>For 2 Nights",
                    "15% Off",
                    "hotel Chancellor.php"
                ),
                new HotelListing(
                    "Dorsett Singapore", 
                    "Waterloo and Southwark. 9.8 km from Delhi Airport.", 
                    "../images/hotel-photo/hotel-2.jpg", 
                    4, 
                    ["Wifi", "Eating", "Pet"], 
                    "Deluxe Suite with Partial Ocean View", 
                    "Last booked 3 hours ago", 
                    "Free Cancellation, till 1 hour of Pick up", 
                    "Login & get additional \$15 Off Using Visa card", 
                    3.6, 
                    2514, 
                    89, 
                    80, 
                    "+ \$42 taxes & Fees<br>For 4 Nights", 
                    "7% Off",
                    "hotel Dorsett.php"
                ),
                new HotelListing(
                    "Royal Plaza on Scotts", 
                    "Waterloo and Southwark. 9.8 km from Delhi Airport.", 
                    "../images/hotel-photo/hotel-3.jpg", 
                    5, 
                    ["Wifi", "Eating", "Pet", "Laundry"], 
                    "Superior King Room", 
                    "Last booked a day ago", 
                    "Free Cancellation, till 1 hour of Pick up", 
                    "Login & get additional \$25 Off Using Visa card", 
                    4.2, 
                    1514, 
                    101, 
                    88, 
                    "+ \$12 taxes & Fees<br>For 2 Nights", 
                    "13% Off",
                    "hotel royal plaza.php"
                ),
                new HotelListing(
                    "Siloso Beach Resort - Sentosa", 
                    "51 Imbiah Walk, Singapore 099538.", 
                    "../images/hotel-photo/hotel-4.jpg", 
                    3, 
                    ["Wifi", "Eating", "Pet"], 
                    "Basic King Room", 
                    "Last booked a week ago", 
                    "Free Cancellation, till 2 hour of Pick up", 
                    "Login & get additional \$25 Off Using Visa card", 
                    3.2, 
                    514, 
                    70, 
                    65, 
                    "+ \$32 taxes & Fees<br>For 3 Nights", 
                    "25% Off",
                    "siloso beach resort.php"
                ),
                new HotelListing(
                    "Value Hotel Balestier", 
                    "218 Balestier Rd, Singapore 329684.", 
                    "../images/hotel-photo/hotel-5.jpg", 
                    3, 
                    ["Wifi", "Eating", "Laundry"], 
                    "Standard Room", 
                    "Last booked a day ago", 
                    "Free Cancellation, till 4 hour of Pick up", 
                    "Login & get additional \$7 Off Using Visa card", 
                    4.4, 
                    514, 
                    80, 
                    75, 
                    "+ \$12 taxes & Fees<br>For 2 Nights", 
                    "15% Off",
                    ""
                ),
                new HotelListing(
                    "Vigara Hotel Lavender",
                    "Waterloo and Southwark. 9.8 km from Delhi Airport.",
                    "../images/hotel-photo/hotel-6.jpg",
                    5, // Full 5 stars
                    ["Wifi", "Eating", "Pet", "Laundry"],
                    "Superior King Room",
                    "Last booked a day ago",
                    "Free Cancellation, till 1 hour of Pick up",
                    "Login & get additional \$25 Off Using Visa card",
                    5.0, // Rating
                    7514, // Reviews
                    301, // Original Price
                    280, // Current Price
                    "+ \$12 taxes & Fees<br>For 2 Nights",
                    "13% Off",
                    ""
                )
                ];
            $hotelsPage2 = [
                new HotelListing(
                    "Supreme Luxury",
                    "Velika plaza BB, 85360 Ulcinj Montenegro.",
                    "../images/hotel-photo/Supreme Luxury.jpg",
                    3,
                    ["Wifi", "View", "Parking", "Balcony"],
                    "SUPREME Luxury features accommodation with balcony",
                    "Last booked 1 hours ago",
                    "Free Cancellation, till 1 hour of Pick up",
                    "Login & get additional \$15 Off Using Visa card",
                    8.9,
                    125,
                    89,
                    80,
                    "+ \$42 taxes & Fees<br>For 4 Nights",
                    "7% Off",
                    ""
                ),
                new HotelListing(
                    "Meris",
                    "ada bojana L58, 85360 Ulcinj, Montenegro.",
                    "../images/hotel-photo/Meris.jpg",
                    5,
                    ["Wifi", "Eating", "See", "Balcony"],
                    "Old Town Ulcinj is 17 km from the chalet",
                    "Last booked a day ago",
                    "Free Cancellation, till 1 hour of Pick up",
                    "Login & get additional \$25 Off Using Visa card",
                    9.8,
                    29,
                    121,
                    90,
                    "+ \$12 taxes & Fees<br>For 2 Nights",
                    "13% Off",
                    ""
                ),
                new HotelListing(
                    "Hotel Kleopatra",
                    "Pinjesh BB, 85360 Ulcinj, Montenegro.",
                    "../images/hotel-photo/Hotel Kleopatra.jpg",
                    3,
                    ["Wifi", "Food", "Caffe"],
                    "Guests can enjoy traditional cuisine",
                    "Last booked a week ago",
                    "Free Cancellation, till 2 hour of Pick up",
                    "Login & get additional \$25 Off Using Visa card",
                    8.0,
                    171,
                    50,
                    35,
                    "+ \$32 taxes & Fees<br>For 3 Nights",
                    "22% Off",
                    ""
                ),
                new HotelListing(
                    "Apartments Mediteran",
                    "Pinjes bb, 85360 Ulcinj, Montenegro",
                    "../images/hotel-photo/Apartments Mediteran.jpg",
                    4,
                    ["Bath", "Eating", "Wifi"],
                    "Standard Room",
                    "Last booked a day ago",
                    "Free Cancellation, till 4 hour of Pick up",
                    "Login & get additional \$7 Off Using Visa card",
                    8.7,
                    235,
                    90,
                    65,
                    "+ \$12 taxes & Fees<br>For 2 Nights",
                    "15% Off",
                    ""
                ),
                new HotelListing(
                    "Apart-Hotel President",
                    "MEHMET GJYLI 64, 85360 Ulcinj, Montenegro.",
                    "../images/hotel-photo/Apart-Hotel.jpg",
                    5,
                    ["Wifi", "Eating", "Pet", "Laundry"],
                    "Delux Double Room",
                    "Last booked a hour ago",
                    "Free Cancellation, till 1 hour of Pick up",
                    "Login & get additional \$25 Off Using Visa card",
                    9.0,
                    566,
                    301,
                    270,
                    "+ \$12 taxes & Fees<br>For 2 Nights",
                    "13% Off",
                    ""
                ),
            ];
            $hotelsPage3 = [
                new HotelListing(
                    "Days Hotel",
                    "One Deira Plaza Gold Souk Metro Station Al Corniche - 111 , 119303 Dubai.",
                    "../images/hotel-photo/Days Hotel.jpg",
                    3.5, // 3 full stars + 1 half star
                    ["Bath", "View", "Wifi"],
                    "Deluxe Queen with Skyline View",
                    "Last booked a day ago",
                    "Free Cancellation,till 4 hour of Pick up",
                    "Login & get additional \$7 Off Using Visa card",
                    8.1,
                    14789,
                    140,
                    120,
                    "+ \$12 taxes & Fees<br>For 2 Nights",
                    "15% Off",
                    ""
                ),
                new HotelListing(
                    "Millennium Airport Hotel Dubai",
                    "Airport Road, Casablanca Street, Al Garhoud, Garhoud, Dubai, United Arab Emirates",
                    "../images/hotel-photo/Millennium.jpg",
                    3.5, // 3 full stars + 1 half star
                    ["Pet", "Wifi", "View"],
                    "Deluxe Twin Room",
                    "Last booked a hour ago",
                    "Free Cancellation,till 4 hour of Pick up",
                    "Login & get additional \$7 Off Using Visa card",
                    8.2,
                    10570,
                    290,
                    265,
                    "+ \$42 taxes & Fees<br>For 2 Nights",
                    "15% Off",
                    ""
                )
                ];

            ?>
        <section>
            <div class="hotel-page page1" id="page1">
            <?php $count = 0; ?>
                <?php foreach ($hotelsPage1 as $hotel): ?>
                    <?= $hotel->repeated();
                    $count++ ;?>
                    <?php
                    if ($count == 2) {
                        ?>
                             <div class="advertisement">
                                <div class="adv-img">
                                    <p id="icon"><i class="fa-solid fa-gift fs-3 text-success"></i></p>
                                </div>
                                <div class="text">
                                    <p>Start Exploring The World</p>
                                    <p id="text-child">Book Flights Effortless and Earn $50+ for each booking with Booking.com</p>
                                </div>
                                <div id="adv-button">
                                    <button>Get Started</button>
                                </div>
                            </div>
                        <?php
                    }
                    ?>
                <?php endforeach; ?>
            </div>

            <div class="hotel-page page2" style="display: none;" id="page2">
                <?php foreach ($hotelsPage2 as $hotel): ?>
                    <?= $hotel->repeated();?>
                <?php endforeach; ?>
            </div>

            <div class="hotel-page page3" style="display: none;" id="page2">
            <?php foreach ($hotelsPage3 as $hotel): ?>
                    <?= $hotel->repeated() ?>
                <?php endforeach; ?>
            </div>

            <div class="bottom" id="box-bottom">
                    <div class="bottom-part">
                        <p><i class="fa-solid fa-arrow-left" id="left-arrow"></i></p>
                        <a style="background-color: rgb(205,44,34); color: white; cursor: pointer" id="page1-btn"
                            class="page-btn">1</a>
                        <a id="page2-btn" class="page-btn">2</a>
                        <a id="page3-btn" class="page-btn">3</a>
                        <p><i class="fa-solid fa-arrow-right" id="right-arrow"></i></p>
                    </div>
                </div>
            </div> 
    </section>

    <footer style=" margin-top: 150px;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
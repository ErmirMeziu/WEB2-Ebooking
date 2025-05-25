<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Tour & Travel Booking</title>
    <link rel="icon" href="/WEB2-Ebooking/src/images/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/navbar.css">
    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/footer.css">
    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/login-register.css">
    <link rel="stylesheet" href="/WEB2-Ebooking/src/styles/AboutUs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <script src="/WEB2-Ebooking/src/script/aboutus.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #about_us {
            color: rgb(215, 44, 33);
        }
    </style>
</head>

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

    <div style="position: relative; width: 100%; height: 100%;">
        <div class="page-container">
            <div class="sidebar">
                <a href="index.php"><i class="fa-solid fa-hotel icon"></i>Home</a>
                <a href="Hotel Page/hotels.php"><i class="fa-solid fa-hotel icon"></i>Hotels</a>
                <a href="Cars-Page/cars.php"><i class="fa-solid fa-car icon"></i>Cars</a>
                <a href="AboutUs.php" style="color: rgb(215, 44, 33);"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
            </div>
        </div>
    </div>

    <abbr title="Go up button">
        <a href="#About-GeoTrip" class="gotopbtn" id="gotopbtn">
            <i class="fa-solid fa-arrow-up fa-sm"></i>
        </a>
    </abbr>

    <section class="about-us">
        <div class="videocontainer">
            <video autoplay muted loop id="myVideo">
                <source src="//s202.q4cdn.com/757635260/files/videos/home-bg-final.mp4" type="video/mp4">
            </video>
        </div>
    </section>

    <section class="about-section" id="About-GeoTrip">
        <div class="about-container">
            <i class="fa-solid fa-list list1"></i>

            <div class="page-container1">
                <div class="sidebar1">
                    <a href="#About-GeoTrip">About GeoTrip</a>
                    <a href="#Travel">Travel</a>
                    <a href="#News">News</a>
                    <a href="#Message">Message</a>
                </div>
            </div>

            <h1>About GeoTrip</h1>
            <h2>(we love to help you travel) <i class="fa-solid fa-volume-high audio-icon" id="audio-icon"></i></h2>
            <audio id="audio" src="/WEB2-Ebooking/src/Video/Audio1.mp3" preload="auto"></audio>
            <h3>OUR MISSION</h3>
            <p>
                GeoTrip is a SaaS-based web solution focused on simplifying travel discovery, planning, and booking
                processes for personal and business travelers, particularly those seeking local and unique experiences.
                GeoTrip organizes travel in one place in the cloud, making it instantly searchable and available
                wherever the user goes.
            </p>
            <p>At its core, GeoTrip offers advanced mapping and route planning tools that empower users to create both
                simple and complex multi-destination itineraries. The platform also incorporates top-tier itinerary
                creation and calendar scheduling features, ensuring every trip is as smooth and efficient as possible.
            </p>
            <p>
                GeoTrip's Travel site revolutionizes personalized travel planning by providing users with fast and
                unparalleled experiences. It allows users to easily tailor their search criteria at a city, state, or
                country level, delivering personalized travel options in just seconds while helping users discover
                hidden gems.
            </p>
            <p>
                In essence, GeoTrip is revolutionizing travel planning through its robust mapping tools, intuitive
                itinerary builders, scheduling features, and AI-powered travel assistant. By putting complete control in
                the hands of its users, GeoTrip makes exploring new destinations faster, easier, and more enjoyable.
                Since its launch, over 100,000 trips have been created by users who trust GeoTrip to deliver memorable
                travel experiences.
            </p>
            <p>Based in Denver, Colorado, GeoTrip is a self-funded startup driven by innovation and passion for travel.
                The company is now preparing for its first round of seed funding to further refine its platform and
                leverage its cutting-edge Travel Chat AI, setting a new standard for personalized travel planning.
            </p>
        </div>
    </section>

    <section class="about-us-body" id="Travel">
        <div class="container1">
            <h2>Your Travel All-In-One-Place with GeoTrip</h2>

            <div class="features">
                <div class="feature">
                    <h4>Dream about your trip</h4>
                    <img src="/WEB2-Ebooking/src/images/aboutUs/icon1.png" alt="Bucket List Icon">
                    <p>Check out our curated bucket lists and itineraries for inspiration.</p>
                </div>
                <div class="feature">
                    <h4>Explore your places</h4>
                    <img src="/WEB2-Ebooking/src/images/aboutUs/icon2.png" alt="Travel Content Icon">
                    <p>Visit the latest in daily travel content from all over the web.</p>
                </div>
                <div class="feature">
                    <h4>Share with others</h4>
                    <img src="/WEB2-Ebooking/src/images/aboutUs/icon3.png" alt="Save Places Icon">
                    <p>Find and save places to share with friends and family.</p>
                </div>
            </div>

            <div class="features">
                <div class="feature">
                    <h4>Plan Your Route</h4>
                    <img src="/WEB2-Ebooking/src/images/aboutUs/icon4.png" alt="Plan Your Route Icon">
                    <p>Create & save your plans, travel methods, and accommodations.</p>
                </div>
                <div class="feature">
                    <h4>Book Your Travel</h4>
                    <img src="/WEB2-Ebooking/src/images/aboutUs/icon5.png" alt="Book Travel Icon">
                    <p>Add your booked travel plans and dates to your calendar.</p>
                </div>
                <div class="feature">
                    <h4>Enjoy Your Destination</h4>
                    <img src="/WEB2-Ebooking/src/images/aboutUs/icon6.png" alt="Enjoy Destination Icon">
                    <p>Travel, explore, and enjoy. Our mobile app is there for your needs.</p>
                </div>
            </div>
        </div>

        <div class="button-container">
            <a href="index.php" class="button">Create New Trip</a>
            <a href="Hotel Page/hotels.php" class="button">Explore Destinations</a>
        </div>
    </section>

    <?php
    // Read news items from news.json using fread()
    $news_file = $_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/data/news.json';
    $news_data = [];
    $news_items = [];
    $last_updated = '';

    if (file_exists($news_file)) {
        $file = fopen($news_file, 'r');
        if ($file) {
            $content = fread($file, filesize($news_file));
            $news_data = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "<p>Error: Invalid JSON format in news file. " . json_last_error_msg() . "</p>";
            } else {
                $news_items = isset($news_data['news']) ? $news_data['news'] : [];
                $last_updated = isset($news_data['last_updated']) ? $news_data['last_updated'] : 'Unknown';
            }
            fclose($file);
        } else {
            echo "<p>Error: Unable to open news file.</p>";
        }
    } else {
        echo "<p>Error: News file does not exist.</p>";
    }
    ?>

    <section class="news-section" id="News">
        <h1>News</h1>
        <p class="last-updated">Last Updated: <?php echo htmlspecialchars($last_updated); ?></p>
        <div class="news-grid">
            <?php if (!empty($news_items)): ?>
                <?php foreach ($news_items as $index => $item): ?>
                    <div class="news-item">
                        <img src="/WEB2-Ebooking/src/<?php echo htmlspecialchars($item['image']); ?>" alt="News <?php echo $index + 1; ?>">
                        <h2>
                            <a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank">
                                <?php echo htmlspecialchars($item['title']); ?>
                            </a>
                        </h2>
                        <p><?php echo htmlspecialchars($item['date']); ?> | GeoTrip<?php echo isset($item['source']) ? ' ' . htmlspecialchars($item['source']) : ''; ?></p>
                        <p><?php echo htmlspecialchars($item['summary']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No news available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Form -->
    <div class="forma" style="max-width: 500px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
    <form action="/WEB2-Ebooking/src/send_email.php" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column;">
        
        <label for="user-name-field" style="margin-bottom: 8px; font-weight: bold; color: #333333; margin-top: 15px;">Your Name:</label>
        <input type="text" id="user-name-field" name="user-name" required
               style="padding: 10px; border: 1px solid #cccccc; border-radius: 6px; font-size: 16px;">

        <label for="user-email-field" style="margin-bottom: 8px; font-weight: bold; color: #333333; margin-top: 15px;">Your Email:</label>
        <input type="email" id="user-email-field" name="user-email" required
               style="padding: 10px; border: 1px solid #cccccc; border-radius: 6px; font-size: 16px;">

        <label for="user-message-field" style="margin-bottom: 8px; font-weight: bold; color: #333333; margin-top: 15px;">Your Message:</label>
        <textarea id="user-message-field" name="user-message" rows="4" required
                  style="padding: 10px; border: 1px solid #cccccc; border-radius: 6px; font-size: 16px; resize: vertical; min-height: 100px;"></textarea>

        <button type="submit" class="button-show" id="send-message"
                style="margin-top: 20px; padding: 12px 20px; background-color: #007BFF; color: #ffffff; border: none; border-radius: 6px; font-size: 16px; cursor: pointer;">
            Send Message
        </button>
    </form>
</div>


    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>
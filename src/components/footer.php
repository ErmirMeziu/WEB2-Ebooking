<?php
$footerLinks = [
    "The Navigation" => [
        "Talent Marketplace",
        "Payroll Services",
        "Direct Contracts",
        "Hire Worldwide",
        "Hire in the USA"
    ],
    "Our Resources" => [
        "Free Business Tools",
        "Affiliate Program",
        "Success Stories",
        "Upwork Reviews",
        "Help & Support"
    ],
    "The Company" => [
        "About Us",
        "Leadership",
        "Contact Us",
        "Investor Relations",
        "Trust, Safety & Security"
    ]
];

$partners = [
    "mytrip.webp",
    "tripadv.webp",
    "goibibo.webp"
];

$terms = ["Terms of Service", "Privacy Policy", "Cookies"];
?>

<div class="footer-container">
    <div class="footer-section">
        <img src="/WEB2-Ebooking/src/images/footer-photos/logo.webp" alt="">
        <p>We make your dream more beautiful & enjoyable with lots of happiness.</p>
        <div class="social-links">
            <a href="#"><i class='bx bxl-facebook-circle'></i></a>
            <a href="#"><i class='bx bxl-linkedin-square'></i></a>
            <a href="#"><i class='bx bxl-github'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
        </div>
    </div>

    <div class="footer-list">
        <?php foreach ($footerLinks as $sectionTitle => $links): ?>
            <div class="footer-section">
                <h3><?= htmlspecialchars($sectionTitle) ?></h3>
                <ul>
                    <?php foreach ($links as $link): ?>
                        <li><a href="#"><?= htmlspecialchars($link) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="footer-section">
        <h3>Payment Methods</h3>
        <div class="paymentmethods">
            <img src="/WEB2-Ebooking/src/images/footer-photos/payment.webp" alt="">
        </div>
        <h3>Our Partners</h3>
        <div class="ourpartners">
            <?php foreach ($partners as $partner): ?>
                <div class="partner1">
                    <a><img src="/WEB2-Ebooking/src/images/footer-photos/<?= $partner ?>" alt=""></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<hr>

<div class="footer-bottom">
    <div class="copy">&copy; <u>2024 GeoTrip. Design by GeoTrip</u></div>
    <div class="Terms">
        <?php foreach ($terms as $term): ?>
            <a href="#"><?= htmlspecialchars($term) ?></a>
        <?php endforeach; ?>
    </div>
</div>
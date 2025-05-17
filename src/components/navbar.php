<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<img src="/WEB2-Ebooking/src/images/navbar-photos/uebLogo.webp" alt="ueb-logo">

<ul id="lista-navbar">
    <li><a href="/WEB2-Ebooking/src/index.php" id="home"><i class="fa-solid fa-house icon"></i>Home</a></li>
    <li><a href="/WEB2-Ebooking/src/Hotel Page/hotels.php" id="hotels"><i class="fa-solid fa-hotel icon"></i>Hotels</a>
    </li>
    <li><a href="/WEB2-Ebooking/src/Cars-page/cars.php" id="cars"><i class="fa-solid fa-car icon"></i>Cars</a></li>
    <li><a href="/WEB2-Ebooking/src/AboutUs.php" id="about_us"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
    </li>
</ul>

<div class="login-register">
    <?php if (isset($_SESSION['user_name'])): ?>
        <p style="margin-right: 20px;">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
        <a href="/WEB2-Ebooking/src/user/user.php"><i class="fa-solid fa-user"
                style="color: white; font-size: 25px"></i></a>
        <a href="/WEB2-Ebooking/src/components/logout.php" class="log-out">Log Out</i></a>
    <?php else: ?>
        <button class="sign-in1" id="sign-in">Sign in/Sign up</button>
    <?php endif; ?>

    <i class="fa-solid fa-list list" style="margin-left: 40px;"></i>
</div>
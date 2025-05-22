<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$navbarItems = [
    ["name" => "Home", "href" => "/WEB2-Ebooking/src/index.php", "id" => "home", "icon" => "fa-house"],
    ["name" => "Hotels", "href" => "/WEB2-Ebooking/src/Hotel Page/hotels.php", "id" => "hotels", "icon" => "fa-hotel"],
    ["name" => "Cars", "href" => "/WEB2-Ebooking/src/Cars-page/cars.php", "id" => "cars", "icon" => "fa-car"],
    ["name" => "About Us", "href" => "/WEB2-Ebooking/src/AboutUs.php", "id" => "about_us", "icon" => "fa-circle-info"]
];
?>

<img src="/WEB2-Ebooking/src/images/navbar-photos/uebLogo.webp" alt="ueb-logo">

<ul id="lista-navbar">
    <?php foreach ($navbarItems as $item): ?>
        <li>
            <a href="<?= $item['href'] ?>" id="<?= $item['id'] ?>">
                <i class="fa-solid <?= $item['icon'] ?> icon"></i><?= htmlspecialchars($item['name']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="login-register">
    <?php if (isset($_SESSION['user_name'])): ?>
        <p style="margin-right: 20px;">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
        <a href="/WEB2-Ebooking/src/user/user.php"><i class="fa-solid fa-user"
                style="color: white; font-size: 25px"></i></a>
        <a href="/WEB2-Ebooking/src/components/logout.php" class="log-out">Log Out</a>
    <?php else: ?>
        <button class="sign-in1" id="sign-in">Sign in/Sign up</button>
    <?php endif; ?>

    <i class="fa-solid fa-list list" style="margin-left: 40px;"></i>
</div>
<?php
function createTable($conn, $sql, $tableName)
{
    if (!mysqli_query($conn, $sql)) {
        echo "Something went wrong...";
    }
    ;
}


$tables = [
    "cars" => "CREATE TABLE IF NOT EXISTS cars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        type VARCHAR(50),
        seats INT,
        price DECIMAL(10,2),
        oldprice DECIMAL(10,2),
        discount INT,
        reviews INT,
        reviewscore DECIMAL(3,1)
    )",

    "hotel_bookings" => "CREATE TABLE IF NOT EXISTS hotel_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hotel_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    total_price DECIMAL(10,2) DEFAULT 0.00,
    rooms INT DEFAULT 1,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
    )",

    "carimages" => "CREATE TABLE IF NOT EXISTS carimages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        carid INT NOT NULL,
        imgurl VARCHAR(255) NOT NULL,
        FOREIGN KEY (carid) REFERENCES cars(id) ON DELETE CASCADE
    )",

    "cardetails" => "CREATE TABLE IF NOT EXISTS cardetails (
        id INT AUTO_INCREMENT PRIMARY KEY,
        carid INT NOT NULL,
        details VARCHAR(255) NOT NULL,
        FOREIGN KEY (carid) REFERENCES cars(id) ON DELETE CASCADE
    )",

    "carextras" => "CREATE TABLE IF NOT EXISTS carextras (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        car_id INT NOT NULL,
        FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
    )",

    "car_specs" => "CREATE TABLE IF NOT EXISTS car_specs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        car_id INT NOT NULL UNIQUE,
        air_conditioning VARCHAR(50),
        number_of_doors INT,
        transmission_type VARCHAR(50),
        passenger_capacity INT,
        suitcase_capacity INT,
        FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
    )",

    "users" => "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        surname VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(20),
        birthdate DATE,
        gender VARCHAR(10),
        bio TEXT,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "rentals" => "CREATE TABLE IF NOT EXISTS rentals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type ENUM('House', 'Villa', 'Apartment') NOT NULL,
        imagePath VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        detail1 VARCHAR(100),
        detail2 VARCHAR(100),
        detail3 VARCHAR(100),
        discount INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        numberOfStars INT NOT NULL,
        review DECIMAL(3,1) NOT NULL,
        numberOfReviews INT NOT NULL
    )",

    "car_rentals" => "CREATE TABLE IF NOT EXISTS car_rentals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        car_id INT NOT NULL,
        rental_start DATE NOT NULL,
        rental_end DATE NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        total_price DECIMAL(10,2) DEFAULT 0.00,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
    )",

    "hotels" => "CREATE TABLE IF NOT EXISTS hotels (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        address VARCHAR(255),
        city VARCHAR(100),
        country VARCHAR(100),
        description TEXT,
        hidden_description TEXT,
        overall_rating DECIMAL(3,1),
        location_rating DECIMAL(3,1),
        review_count INT,
        map_embed_url TEXT,
        map_link_url TEXT
    )",

    "rooms" => "CREATE TABLE IF NOT EXISTS rooms (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT,
        room_type VARCHAR(100),
        bed_configuration VARCHAR(255),
        max_guests INT,
        price DECIMAL(10,2),
        FOREIGN KEY (hotel_id) REFERENCES hotels(id)
    )",

    "reviews" => "CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT NOT NULL,
        category VARCHAR(100) NOT NULL,
        rating DECIMAL(3,1) NOT NULL,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id)
    )",

    "house_rules" => "CREATE TABLE IF NOT EXISTS house_rules (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT NOT NULL,
        rule_type VARCHAR(100) NOT NULL,
        details TEXT NOT NULL,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id)
    )",

    "hotel_images" => "CREATE TABLE IF NOT EXISTS hotel_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT NOT NULL,
        imgurl VARCHAR(255) NOT NULL,
        is_main BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
    )",

    "site_reviews" => "CREATE TABLE IF NOT EXISTS site_reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        rating DECIMAL(3,1) NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status ENUM('pending', 'approved', 'deleted') NOT NULL DEFAULT 'pending',
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )"
];

foreach ($tables as $name => $sql) {
    createTable($conn, $sql, $name);
}
?>
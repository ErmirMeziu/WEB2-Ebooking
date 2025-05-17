<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTrip - Tour & Travel Booking</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/hotels.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../styles/hotel-child.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/login-register.css">
    <link rel="stylesheet" href="../styles/hotel-table-design.css">

    <style>
        .hotel-snd ul ol li {
            list-style-type: none;
            font-size: 14px;
        }

        .hotel-snd ul ol li::before {
            content: '!';
            color: red;
            margin-left: 22px;
        }

        .h2-size {
            font-size: 24px;
        }

        .h5-style {
            margin-left: 5px;
        }

        .btn-style {
            width: 24px;
            height: 24px;
            background-color: rgb(0, 45, 113);
            color: white;
            border: none;
            border-radius: 5px 5px 5px 0;
            margin-right: 5px;
        }

        .p-style {
            font-size: 14px;
            color: rgb(118, 118, 118);
        }

        #hotels {
            color: rgb(215, 44, 33);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const showPriceButton = document.getElementsByClassName('btn btn-primary');
            for (let button of showPriceButton) {
                button.addEventListener('click', function () {
                    alert("To see available rooms and prices, please enter your check-in and check-out dates.");
                });
            }
        });
    </script>

</head>

<body class="body">
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
                <a href="../index.html"><i class="fa-solid fa-hotel icon"></i>Home</a>
                <a href="hotels.html" style="color: rgb(215, 44, 33)"><i class=" fa-solid fa-hotel
                    icon"></i>Hotels</a>
                <a href="../Flights Page/flights.html"><i class="fa-solid fa-jet-fighter icon"></i>Flights</a>
                <a href="../Cars-Page/cars.html"><i class="fa-solid fa-car icon"></i>Cars</a>
                <a href="../AboutUs.html"><i class="fa-solid fa-circle-info icon"></i>About Us</a>
            </div>
        </div>
    </div>

    <section class="search-bar">
        <div class="search-input">
            <fieldset>
                <legend>Where</legend>
                <input type="text" name="text" id="text" class="same" placeholder="Hotel Chancellor@Orchard">
            </fieldset>

            <fieldset>
                <legend>CheckIn & CheckOut</legend>
                <input type="date" name="date" id="date" class="same" min="2025-01-01">
            </fieldset>

            <fieldset>
                <legend>Guests & Rooms</legend>
                <input type="number" name="number" id="number" min="1" max="15" class="same"> <!--Kushti (min,max)-->
            </fieldset>

            <button><i class="fa-solid fa-magnifying-glass loop"></i>Search</button>
        </div>
    </section>



    <div class="body-part">
        <div class="sec1">
            <div class="btn-first" style="width: 100%;">
                <a href="">
                    <p>Overview</p>
                </a>
                <a href="">
                    <p id="long">Apartament Info & Price</p>
                </a>
                <a href="">
                    <p>Facilities</p>
                </a>
                <a href="">
                    <p>House rule</p>
                </a>
                <a href="">
                    <p>Guest reviews</p>
                </a>
            </div>

            <div class="text">
                <p>Dorsett Singapore</p>
            </div>

            <div class="pin-text">
                <p><i class="fa-solid fa-location-dot"></i> 333 New Bridge Road, Chinatown, 088765 Singapore, Singapore
                    <a href="https://www.google.com/maps/place/Dorsett+Singapore/@1.2797261,103.8400574,21z/data=!3m1!5s0x31da19720bc174d3:0x5567a6aae82827e3!4m10!3m9!1s0x31da196df7b97401:0xd275512f78f0874c!5m3!1s2025-01-04!4m1!1i2!8m2!3d1.2798721!4d103.840238!16s%2Fg%2F1pt_15s89?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D"
                        target="_blank"> -Great location - show map</a>
                </p>
                <button id="btn-res">Reserve</button>
            </div>

            <div class="photos">
                <img src="../images/Hotel Dorsett/Outside.jpg" alt="Hotel img" class="photo" id="first-photo">
                <img src="../images/Hotel Dorsett/Bufe.jpg" alt="Hotel img" class="photo" id="second-photo">
                <img src="../images/Hotel Dorsett/Inside room.jpg" alt="Hotel img" class="photo" id="third-photo">
                <div class="bottom-photos">
                    <img src="../images/Hotel Dorsett/Bathroom.jpg" alt="Hotel img" class="bottom-pht">
                    <img src="../images/Hotel Dorsett/Room.jpg" alt="Hotel img" class="bottom-pht">
                    <img src="../images/Hotel Dorsett/WorkPlace.jpg" alt="Hotel img" class="bottom-pht">
                    <img src="../images/Hotel Dorsett/View.jpg" alt="Hotel img" class="bottom-pht">
                    <img src="../images/Hotel Dorsett/Room2.jpg" alt="Hotel img" class="bottom-pht">
                </div>
            </div>

            <div class="some-txt">
                <p>You might be eligible for a Genius discount at Dorsett Singapore.
                    To check if a Genius discount is available for your selected dates sign in.</p><br>
                <p>Genius discounts at this property are subject to book dates, stay dates and other available deals.
                </p><br>
                <p> Directly above Outram Park MRT Station, the 4-star Dorsett Singapore offers easy access to the
                    city's popular attractions.
                    The hotel houses a 30-metre outdoor pool, a hot tub and a fitness centre. Free WiFi is available in
                    all rooms.</p><br>
                <p>Dorsett Singapore is a 10-minute walk from the vibrant streets of Chinatown. It is just 2 train stops
                    from nightlife options
                    and restaurants at Clarke Quay. The iconic Orchard shopping hub is also an easy drive away. Guests
                    can visit the many quaint
                    cafes at Tiong Bahru, Duxton Hill and Club Street, located a 15-minute walk away.</p><br>
                <p>Guests can approach the 24-hour front desk for currency exchange, concierge and laundry services.</p>
                <br>

                <div id="extra-text" class="hidden">
                    <p>All non-smoking, the air-conditioned guest rooms all come with a 40-inch flat-screen TV and
                        minibar.
                        En suite bathrooms are equipped with a shower or bathtub.</p><br>
                    <p>Couples particularly like the location — they rated it 8.9 for a two-person trip.</p>
                </div>

                <button class="toggle-btn" id="toggle-btn">Show More</button>
            </div>
        </div>

        <div class="sec2">
            <div class="reviews">
                <div class="txt">
                    <p id="first">Good</p>
                    <p id="second">3321 reviews</p>
                </div>
                <div class="btn">
                    <button>7.5</button>
                </div>
            </div>

            <div class="location">
                <div class="txt">
                    <p id="third">Great location!</p>
                </div>
                <div class="btn">
                    <button>8.9</button>
                </div>
            </div>

            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.8135746808155!2d103.8399887!3d1.2798721!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da196df7b97401%3A0xd275512f78f0874c!2sDorsett%20Singapore!5e0!3m2!1sen!2ssg!4v1693005872123!5m2!1sen!2ssg"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <a href="https://www.google.com/maps/place/Dorsett+Singapore/@1.2797261,103.8400574,21z/data=!3m1!5s0x31da19720bc174d3:0x5567a6aae82827e3!4m10!3m9!1s0x31da196df7b97401:0xd275512f78f0874c!5m3!1s2025-01-04!4m1!1i2!8m2!3d1.2798721!4d103.840238!16s%2Fg%2F1pt_15s89?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D"
                    target="_blank" class="show-on-map-btn">
                    Show on map
                </a>
            </div>


            <div class="property">
                <p id="imp">Property highlights</p>
                <ul>
                    <li>
                        <i class="fa-solid fa-wheelchair"></i>
                        <div>
                            <h4>Accessibility</h4>
                            <p>Lift, Facilities for disabled guests</p>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-square-parking"></i>
                        <div>
                            <h4>Parking</h4>
                            <p>Private parking, On-site parking</p>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-person-swimming"></i>
                        <div>
                            <h4>Swimming pool</h4>
                            <p>Private, Outdoor swimming pool</p>
                        </div>
                    </li>
                </ul>

                <div class="bottom-btn">
                    <button>Reserve</button><br>
                    <button class="bottom-btn1"><i class="fa-regular fa-heart heart"></i> Save the property</button>
                </div>
            </div>
        </div>
    </div>

    <div class="body-part2">
        <br>
        <hr><br>
        <h2 id="avb" class="h2-size">Availability</h2>

        <table class="hotel-room-table">
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Number of Guests</th>
                    <th>Price for 3 Nights</th>
                    <th>Your Choices</th>
                    <th>Select Room</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 -->
                <tr>
                    <td class="room-type"><a>Double Room</a>
                        <p>Beds: 1 extra-large double bed or</p>
                        <p> 2 single beds</p>
                        <ul class="amenities">
                            <li><i class="fas fa-wifi"></i> Free WiFi</li>
                            <li><i class="fas fa-shower"></i> Private bathroom</li>
                            <li><i class="fas fa-snowflake"></i> Air conditioning</li>
                        </ul>
                    </td>
                    <td class="guest-info"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-user"></i></td>
                    <td class="price">
                        <p class="money">€409</p>
                        <p class="table-txt">Includes taxes and charges</p>
                    </td>
                    <td class="choices">
                        <ul style="list-style-type:circle;">
                            <li><strong>Non-refundable</strong></li>
                            <li>Pay in advance</li>
                        </ul>
                    </td>
                    <td class="select-room">
                        <select>
                            <option value="0">0</option>
                            <option value="1">1 (€409)</option>
                        </select>
                    </td>
                </tr>
                <!-- Row 2 -->
                <tr>
                    <td class="room-type">
                        <a>Dorsett King Room</a><br>
                        <p>1 extra-large double bed </p>
                        <ul class="amenities">
                            <li><i class="fas fa-ruler-combined icon-highlight"></i> 22 m<sup>2 </sup></li>
                            <li><i class="fas fa-city icon-highlight"></i> City view </li>
                            <li><i class="fas fa-snowflake icon-highlight"></i> Air conditioning</li>
                            <li><i class="fas fa-bath icon-highlight"></i> Ensuite bathroom</li>
                            <li><i class="fas fa-tv icon-highlight"></i> Flat-screen TV</li>
                            <li><i class="fas fa-wifi icon-highlight"></i> Free WiFi</li>
                            <li><i class="fas fa-check-circle icon-highlight"></i> Free toiletries</li>
                            <li><i class="fas fa-check-circle icon-highlight"></i> Shower</li>
                            <li><i class="fas fa-check-circle icon-highlight"></i> Bathrobe</li>
                            <li><i class="fas fa-lock icon-highlight"></i> Safety deposit box</li>
                            <li><i class="fas fa-bath icon-highlight"></i> Bidet & Toilet</li>
                            <li><i class="fas fa-bed icon-highlight"></i> Linen</li>
                            <li><i class="fas fa-tv icon-highlight"></i> Satellite channels</li>
                            <li><i class="fas fa-wheelchair icon-highlight"></i> Wheelchair accessible</li>
                        </ul>
                    </td>
                    <td class="guest-info"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-user"></i></td>
                    <td class="price">
                        <p class="money">€387</p>
                        <p class="table-txt">+€ 85 taxes and charges</p>
                        <button class="table-btn">9% off</button>
                    </td>
                    <td class="choices">
                        <ul style="list-style-type:circle;">
                            <li><strong>Partially refundable</strong></li>
                            <li>Pay online now</li>
                        </ul>
                    </td>
                    <td class="select-room">
                        <select>
                            <option value="0">0</option>
                            <option value="1">1 (€387)</option>
                            <option value="2">2 (€774)</option>
                            <option value="3">3 (€1,161)</option>
                            <option value="4">4 (€1,548)</option>
                        </select>
                    </td>
                </tr>
                <!-- Row 3 -->
                <tr>
                    <td class="room-type">
                        <a href="">Splash Room</a>
                        <p>1 extra-large double bed</p>
                        <ul class="amenities">
                            <li><i class="fas fa-wifi"></i> Free WiFi</li>
                            <li><i class="fas fa-tv"></i> Flat-screen TV</li>
                            <li><i class="fas fa-snowflake"></i> Air conditioning</li>
                            <li><i class="fas fa-shower"></i> Private bathroom</li>
                        </ul>
                    </td>
                    <td class="guest-info"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-user"></i></td>
                    <td class="price">
                        <p class="money">€495</p>
                        <p class="table-txt">+€ 108 taxes and charges</p>
                        <button class="table-btn">27% off</button><br>
                        <button class="table-btn" style="width: 120px;">Early 2025 Deal</button>
                    </td>
                    <td class="choices">
                        <ul style="list-style-type:circle;">
                            <li><strong>Partially refundable</strong></li>
                            <li>Pay online now</li>
                        </ul>
                    </td>
                    <td class="select-room">
                        <select>
                            <option value="0">0</option>
                            <option value="1">1 (€495)</option>
                            <option value="2">2 (€991)</option>
                            <option value="3">3 (€1,486)</option>
                            <option value="4">4 (€1,981)</option>
                            <option value="5">5 (€2,447)</option>
                            <option value="6">6 (€2,972)</option>
                        </select>
                    </td>
                </tr>
                <!-- Row 4 -->
                <tr>
                    <td class="room-type">
                        <a href="">Deluxe Room</a>
                        <p>1 extra-large double bed</p>
                        <ul class="amenities">
                            <li><i class="fas fa-wifi"></i> Free WiFi</li>
                            <li><i class="fas fa-shower"></i> Ensuite bathroom</li>
                            <li><i class="fas fa-coffee"></i> Electric kettle</li>
                            <li><i class="fas fa-city"></i> City view</li>
                        </ul>
                    </td>
                    <td class="guest-info"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-user"></i></td>
                    <td class="price">
                        <p class="money">€445</p>
                        <p class="table-txt">+€ 97 taxes and charges</p>
                        <button class="table-btn">9% off</button><br>
                    </td>
                    <td class="choices">
                        <ul style="list-style-type:circle;">
                            <li><strong>Partially refundable</strong></li>
                            <li>Pay online now</li>
                        </ul>
                    </td>
                    <td class="select-room">
                        <select>
                            <option value="0">0</option>
                            <option value="1">1 (€445)</option>
                            <option value="2">2 (€890)</option>
                        </select>
                    </td>
                </tr>
                <!-- Row 5 -->
                <tr>
                    <td class="room-type">
                        <a href="">Loft Room</a>
                        <p>1 extra-large double bed</p>
                        <ul class="amenities">
                            <li><i class="fas fa-wifi"></i> Free WiFi</li>
                            <li><i class="fas fa-tv"></i> Flat-screen TV</li>
                            <li><i class="fas fa-snowflake"></i> Air conditioning</li>
                            <li><i class="fas fa-bath"></i> Ensuite bathroom</li>
                        </ul>
                    </td>
                    <td class="guest-info"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-user"></i></td>
                    <td class="price">
                        <p class="money">€588</p>
                        <p class="table-txt">+€ 129 taxes and charges</p>
                        <button class="table-btn">27% off</button><br>
                        <button class="table-btn" style="width: 120px;">Early 2025 Deal</button>
                    </td>
                    <td class="choices">
                        <ul style="list-style-type:circle;">
                            <li><strong>Partially refundable</strong></li>
                            <li>Pay online now</li>
                        </ul>
                    </td>
                    <td class="select-room">
                        <select>
                            <option value="0">0</option>
                            <option value="1">1 (€588)</option>
                            <option value="2">2 (€1,177)</option>
                            <option value="3">3 (€1,765)</option>
                            <option value="4">4 (€2,353)</option>
                            <option value="5">5 (€2,941)</option>
                            <option value="6">6 (€3,530)</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size">Guest review</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>
        <div class="guest-reviews">
            <div class="btn">
                <button>7.5</button>
            </div>
            <div class="gst-txt">
                <p id="txt-first">Good -</p>
                <p id="txt-second">3321 reviews</p>
            </div>
        </div>
        <div class="reviews-container">
            <div class="categories">
                <div class="category">
                    <div class="category-title">
                        <span>Staff</span>
                        <span>&darr;</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 80%;"></div>
                    </div>
                    <div class="value">8.2</div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <span>Facilities</span>
                        <span>&darr;</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 74%;"></div>
                    </div>
                    <div class="value">7.5</div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <span>Cleanliness</span>
                        <span>&darr;</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 79%;"></div>
                    </div>
                    <div class="value">7.9</div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <span>Comfort</span>
                        <span>&darr;</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 79%;"></div>
                    </div>
                    <div class="value">7.9</div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <span>Value for money</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 82%;"></div>
                    </div>
                    <div class="value">8.2</div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <span>Free WiFi</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 77%;"></div>
                    </div>
                    <div class="value">7.7</div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <span>Location</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar bar-blue" style="width: 84%;"></div>
                    </div>
                    <div class="value">8.4</div>
                </div>
            </div>
        </div>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size">Travellers are asking</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>

        <div class="ask">
            <div class="ask-first">
                <ol>
                    <li>
                        Is the swimming pool open?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">There is a swimming pool at Dorsett Singapore.
                            It will be open during your stay.</p>
                    </li>
                    <hr>
                    <li>
                        Do they serve breakfast?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">Yes, they serve breakfast.</p>
                    </li>
                    <hr>
                    <li>
                        Is there a restaurant?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">Yes, the hotel has a fine-dining restaurant.</p>
                    </li>
                    <hr>
                    <li>
                        Is there a spa?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">Yes, a full-service spa is available.</p>
                    </li>
                    <hr>
                    <li>
                        Can I park there?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">Public parking is possible at a location nearby (reservation is not needed)
                            and charges may be applicable.</p>
                    </li>
                </ol>
            </div>

            <div class="ask-first">
                <ol style="list-style-type: upper-roman;">
                    <li>
                        What restaurants, attractions, and public transport options are nearby?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">To find out what’s near Dorsett Singapore, click the link below. <a
                                href="#hotel-sorroun">See property surroundings</a></p>
                    </li>
                    <hr>
                    <li>
                        Are there rooms with a private bathroom?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">There are still rooms available with a private bathroom.
                            For example: Dorsett King Room
                        </p>
                    </li>
                    <hr>
                    <li>
                        Are there rooms with a hot tub?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">Dorsett Singapore doesn't have rooms with a hot tub..</p>
                    </li>
                    <hr>
                    <li>
                        Is there an airport shuttle service?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">Airport shuttle service is not available at Dorsett Singapore.</p>
                    </li>
                    <hr>
                    <li>
                        What are the check-in and check-out times?
                        <span class="arrow">&#x25BC;</span>
                        <p class="answer">✓ Check-in from 15:00 <br>
                            ✓ Check-out until 11:00</p>
                    </li>
                </ol>
            </div>

            <div class="ask-first">
                <div class="ask-txt">
                    <h3>Still lloking?</h3>
                    <button>Ask a question</button>
                    <p>We have an instant answer to most questions</p>
                </div>
            </div>
        </div>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size" id="hotel-sorroun">Hotel surroundings</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>

        <div class="nearby-container">
            <div class="nearby-grid">
                <!-- Column 1 -->
                <div>
                    <h3><i class="fas fa-map-marker-alt"></i> What's nearby</h3>
                    <ul>
                        <li>Sek Kho Club <span class="distance">100 m</span></li>
                        <li>Doggu X14 <span class="distance">350 m</span></li>
                        <li>Kiew Lam Club <span class="distance">400 m</span></li>
                        <li>Duxton Plain Park <span class="distance">550 m</span></li>
                        <li>Seng Wee Holdings <span class="distance">600 m</span></li>
                        <li>Exercise Corner, Duxton Plain Park <span class="distance">650 m</span></li>
                        <li>Gurney Dog Run <span class="distance">750 m</span></li>
                        <li>Tsla <span class="distance">800 m</span></li>
                        <li>Playground, BLK 6 Everton Park <span class="distance">950 m</span></li>
                        <li>88 Karaoke Pub <span class="distance">1.2 km</span></li>
                    </ul>
                </div>

                <!-- Column 2 -->
                <div>
                    <h3><i class="fas fa-landmark"></i> Top attractions</h3>
                    <ul>
                        <li>Singapore City Gallery <span class="distance">2.1 km</span></li>
                        <li>Statue of Sir Stamford Raffles <span class="distance">2.1 km</span></li>
                        <li>Asian Civilisations Museum <span class="distance">2.4 km</span></li>
                        <li>National Gallery Singapore <span class="distance">3.1 km</span></li>
                        <li>Singapore Art Museum <span class="distance">3.2 km</span></li>
                        <li>ArtScience Museum <span class="distance">3.4 km</span></li>
                        <li>National Orchid Garden <span class="distance">3.7 km</span></li>
                        <li>Cloud Forest <span class="distance">4 km</span></li>
                        <li>S.E.A. Aquarium <span class="distance">4 km</span></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div>
                    <h3><i class="fas fa-umbrella-beach"></i> Beaches in the neighbourhood</h3>
                    <ul>
                        <li>East Coast Beach <span class="distance">7 km</span></li>
                        <li>Palawan Beach <span class="distance">7 km</span></li>
                        <li>Siloso Beach <span class="distance">8 km</span></li>
                        <li>Tanjong Beach <span class="distance">8 km</span></li>
                    </ul>

                    <h3><i class="fas fa-train"></i> Public transport</h3>
                    <ul>
                        <li>Train • Somerset MRT Station <span class="distance">400 m</span></li>
                        <li>Metro • Somerset <span class="distance">450 m</span></li>
                        <li>Metro • Dhoby Ghaut MRT Station <span class="distance">500 m</span></li>
                        <li>Train • Little India MRT Station <span class="distance">1.9 km</span></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div>
                    <h3><i class="fas fa-utensils"></i> Restaurants & cafes</h3>
                    <ul>
                        <li>Restaurant • Golden Seafood <span class="distance">8 m</span></li>
                        <li>Cafe/bar • Papa Gayo <span class="distance">8 m</span></li>
                        <li>Cafe/bar • So High Social Club <span class="distance">50 m</span></li>
                    </ul>

                    <h3><i class="fas fa-tree"></i> Natural beauty</h3>
                    <ul>
                        <li>Lake • Marina Reservoir <span class="distance">5 km</span></li>
                    </ul>

                    <h3><i class="fas fa-plane"></i> Closest airports</h3>
                    <ul>
                        <li>Seletar Airport <span class="distance">14 km</span></li>
                        <li>Changi Airport <span class="distance">19 km</span></li>
                        <li>Hang Nadim International Airport <span class="distance">35 km</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size">Facilities of Hotel Chancellor@Orchard</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>
        <p id="su-p">Most popular facilities</p>
        <div class="popular-facilities">
            <ul>
                <li><i class="fa-solid fa-person-swimming"></i> Outdoor swimming pool</li>
                <li><i class="fa-solid fa-wifi"></i> Free WiFi</li>
                <li><i class="fa-solid fa-ban-smoking"></i> Non-smoking rooms</li>
                <li><i class="fa-solid fa-square-parking"></i> Private parking</li>
                <li><i class="fa-solid fa-utensils"></i> Restaurant</li>
                <li><i class="fa-solid fa-clock"></i> 24-hour front desk</li>
                <li><i class="fa-solid fa-bell-concierge"></i> Room service</li>
                <li><i class="fa-solid fa-wheelchair"></i> Facilities for disabled guests</li>
                <li><i class="fa-solid fa-tree"></i> Terrace</li>
                <li><i class="fa-solid fa-mug-saucer"></i> Breakfast</li>
            </ul>
        </div>

        <div class="hotel-fac">

            <div class="hotel-snd">
                <h3><i class="fa-solid fa-user"></i> Great for your stay</h3>
                <ul>
                    <li>Restaurant</li>
                    <li>Parking</li>
                    <li>Private bathroom</li>
                    <li>Free WiFi</li>
                    <li>Air conditioning</li>
                    <li>Flat-screen TV</li>
                    <li>Facilities for disabled guests</li>
                    <li>Outdoor swimming pool</li>
                    <li>Room service</li>
                    <li>Tour desk</li>
                </ul>

                <h3><i class="fa-solid fa-bath"></i> Bathroom</h3>
                <ul>
                    <li>Towels</li>
                    <li>Private bathroom</li>
                    <li>Toilet</li>
                    <li>Hairdryer</li>
                    <li>Shower</li>
                </ul>

                <h3><i class="fa-solid fa-bed"></i> Bedroom</h3>
                <ul>
                    <li>Linen</li>
                    <li>Wardrobe or closet</li>
                </ul>

                <h3><i class="fa-brands fa-slack"></i> Outdoors</h3>
                <ul>
                    <li>Outdoor furniture</li>
                    <li>Sun terrace</li>
                    <li>Terrace</li>
                </ul>

                <h3><i class="fa-solid fa-kitchen-set"></i> Kitchen</h3>
                <ul>
                    <li>Tumble dryer</li>
                </ul>

                <h3><i class="fa-solid fa-bed"></i> Room Amenities</h3>
                <ul>
                    <li>Clothes rack</li>
                </ul>

                <h3><i class="fa-solid fa-football"></i> Activities</h3>
                <ul>
                    <li>Children's playground</li>
                </ul>

                <h3><i class="fa-solid fa-couch"></i> Living Area</h3>
                <ul>
                    <li>Desk</li>
                </ul>

                <h3><i class="fa-solid fa-burger"></i> Food & Drink</h3>
                <ul>
                    <li>Restaurant</li>
                    <li>Vending machines</li>
                </ul>

            </div>
            <div class="hotel-snd">
                <h3><i class="fa-solid fa-laptop"></i> Media & Technology</h3>
                <ul>
                    <li>Flat-screen TV</li>
                    <li>Telephone</li>
                </ul>

                <h3><i class="fa-solid fa-square-parking"></i> Parking</h3>
                <ul>
                    <li>Private parking is possible on site (reservation <br> is not needed) and costs S$ 10 per day.
                    </li>
                </ul>

                <h3><i class="fa-solid fa-circle-info"></i> Reception services</h3>
                <ul>
                    <li>Private check-in/check-out</li>
                    <li>Concierge service</li>
                    <li>Luggage storage</li>
                    <li>Tour desk</li>
                    <li>Currency exchange</li>
                    <li>24-hour front desk</li>
                </ul>

                <h3><i class="fa-solid fa-people-group"></i> Entertainment and family services</h3>
                <ul>
                    <li>Kids' outdoor play equipment</li>
                </ul>

                <h3><i class="fa-solid fa-soap"></i> Cleaning services</h3>
                <ul>
                    <li>Daily housekeeping</li>
                    <li>Dry cleaning
                        <ol>
                            <li>Additional charge</li>
                        </ol>
                    </li>
                    <li>Laundry
                        <ol>
                            <li>Additional charge</li>
                        </ol>
                    </li>
                </ul>

                <h3><i class="fa-solid fa-briefcase"></i>Business facilities</h3>
                <ul>
                    <li>Fax/photocopying
                        <ol>
                            <li>Additional charge</li>
                        </ol>
                    </li>
                    <li>Meeting/banquet facilities
                        <ol>
                            <li>Additional charge</li>
                        </ol>
                    </li>
                </ul>

                <h3><i class="fa-solid fa-lock"></i> Safety & security</h3>
                <ul>
                    <li>Fire extinguishers</li>
                    <li>CCTV outside property</li>
                    <li>CCTV in common areas</li>
                    <li>Smoke alarms</li>
                    <li>Security alarm</li>
                    <li>Key card access</li>
                    <li>Key access</li>
                    <li>24-hour security</li>
                    <li>Safety deposit box</li>
                </ul>
            </div>

            <div class="hotel-snd">
                <h3><i class="fa-solid fa-wifi"></i> Internet</h3>
                <ul>
                    <li>WiFi is available in all areas and is free of charge.</li>
                </ul>

                <h3><i class="fa-solid fa-info"></i> General</h3>
                <ul>
                    <li>Minimarket on site</li>
                    <li>Vending machine (snacks)</li>
                    <li>Vending machine (drinks)</li>
                    <li>Designated smoking area</li>
                    <li>Air conditioning</li>
                    <li>Non-smoking throughout</li>
                    <li>Soundproofing</li>
                    <li>Carpeted</li>
                    <li>Soundproof rooms</li>
                    <li>Lift</li>
                    <li>Facilities for disabled guests</li>
                    <li>Non-smoking rooms</li>
                    <li>Room service</li>
                </ul>
                <h3><i class="fa-solid fa-person-swimming"></i> Outdoor swimming pool <p id="free">Free!</p>
                </h3>
                <ul>
                    <li>Open all year</li>
                    <li>Pool with view</li>
                    <li>Fence around pool</li>
                </ul>

                <h3><i class="fa-solid fa-wheelchair"></i> Accessibility</h3>
                <ul>
                    <li>Toilet with grab rails</li>
                    <li>Wheelchair accessible</li>
                    <li>Upper floors accessible by elevator</li>
                </ul>

                <h3><i class="fa-solid fa-dumbbell"></i> Wellness</h3>
                <ul>
                    <li>Fitness</li>
                    <li>Fitness centre</li>
                </ul>

                <h3><i class="fa-regular fa-comments"></i> Languages spoken</h3>
                <ul>
                    <li>English</li>
                    <li>Indonesian</li>
                    <li>Malay</li>
                    <li>Alabanian</li>
                    <li>Filipino</li>
                    <li>Chinese</li>
                </ul>


            </div>

        </div>

        <br><br>
        <div class="gs-btn">
            <h2 class="h2-size">Similar properties you might like</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>
        <p id="somep">Travellers like you also liked these properties</p>

        <div class="slider-container">
            <button class="prev">&lt;</button>
            <div class="recommendations-wrapper">
                <div class="recommendations">
                    <!--1-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel1-recommendation.jpg"
                                alt="Hotel Grand Pacific"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Grand Pacific</h5>
                        <div class="h-review">
                            <button class="btn-style">7.2</button>
                            <p class="p-style">Good - 1896 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">0.8km from centre</p>
                        </div>
                    </div>
                    <!--2-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel2-recommendation.jpg" alt=""></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Royal Queens</h5>
                        <div class="h-review">
                            <button class="btn-style">7.7</button>
                            <p class="p-style">Good - 3023 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">0.8km from centre</p>
                        </div>
                    </div>
                    <!--3-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel3-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Bencoolen Singapore</h5>
                        <div class="h-review">
                            <button class="btn-style">6.3</button>
                            <p class="p-style">Review score - 141 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">1km from centre</p>
                        </div>
                    </div>
                    <!--4-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel4-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Mi Rochor</h5>
                        <div class="h-review">
                            <button class="btn-style">7.9</button>
                            <p class="p-style">Good - 2787 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">1.5km from centre</p>
                        </div>
                    </div>
                    <!--5-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel5-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Metropolitan YMCA Singapore</h5>
                        <div class="h-review">
                            <button class="btn-style">6.8</button>
                            <p class="p-style">Review score - 182 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">4.1km from centre</p>
                        </div>
                    </div>
                    <!--6-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel6-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Royal</h5>
                        <div class="h-review">
                            <button class="btn-style">6.9</button>
                            <p class="p-style">Review score - 740 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">3.1km from centre</p>
                        </div>
                    </div>
                    <!--7-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel7-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Village Hotel Albert Court by Far East</h5>
                        <div class="h-review">
                            <button class="btn-style">7.6</button>
                            <p class="p-style">Good - 1102 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">1.5km from centre</p>
                        </div>
                    </div>
                    <!--8-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel8-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">V Hotel Bencoolen</h5>
                        <div class="h-review">
                            <button class="btn-style">7.5</button>
                            <p class="p-style">Good - 3579 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">1km from centre</p>
                        </div>
                    </div>
                    <!--9-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel9-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Boss</h5>
                        <div class="h-review">
                            <button class="btn-style">6.7</button>
                            <p class="p-style">Review score - 11578 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">1.9km from centre</p>
                        </div>
                    </div>
                    <!--10-->
                    <div class="hotel-rec">
                        <div class="routes-image"><img src="../images/Hotel1/Hotel10-recommendation.jpg"
                                alt="Jackson ville"></div>
                        <div class="h-review">
                            <p id="somep">Hotel</p>
                            <ul>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <h5 class="h5-style">Hotel Mono</h5>
                        <div class="h-review">
                            <button class="btn-style">7.3</button>
                            <p class="p-style">Good - 547 reviws</p>
                        </div>
                        <div class="h-review">
                            <ul>
                                <li><i class="fa-solid fa-location-dot"></i></li>
                            </ul>
                            <p class="p-style" style="margin-top: 5px;">1.1km from centre</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="next">&gt;</button>
        </div>

        <br>
        <div class="gs-btn">
            <h2 class="h2-size">House rules</h2>
            <button id="gst-btn"><a href="#avb">See Availability</a></button>
        </div>
        <p id="somep">Hotel Chancellor@Orchard takes special requests - add in the next step!</p>


        <div class="house-rules">
            <div class="rule">
                <div class="icon">➡️</div>
                <div class="details">
                    <h4>Check-in</h4>
                    <p>From 15:00</p>
                </div>
            </div>
            <div class="rule">
                <div class="icon1">⬅️</div>
                <div class="details">
                    <h4>Check-out</h4>
                    <p>Until 12:00</p>
                </div>
            </div>
            <div class="rule">
                <div class="icon1">ℹ</div>
                <div class="details">
                    <h4>Cancellation/ prepayment</h4>
                    <p>Cancellation and prepayment policies vary according to accommodation type.
                        Please <a href="#">enter the dates of your stay</a>, and check the conditions of your required
                        option.</p>
                </div>
            </div>
            <div class="rule">
                <div class="icon1">👶</div>
                <div class="details">
                    <h4>Children and beds</h4>
                    <p><strong>Child policies</strong><br>
                        Children of any age are welcome.<br><br>
                        Children 7 years and above will be charged as adults at this property.<br><br>
                        To see correct prices and occupancy information, please add the number of children in your group
                        and their ages to your search.<br><br>
                        <strong>Cot and extra bed policies</strong>
                    <table>
                        <tr>
                            <td>0 - 2 years</td>
                            <td>Cot upon request</td>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <td>7+ years</td>
                            <td>Extra bed upon request</td>
                            <td>$75 per person, per night</td>
                        </tr>
                    </table>

                    </p>
                </div>
            </div>
            <div class="rule">
                <div class="icon1">⛔</div>
                <div class="details">
                    <h4>Age restriction</h4>
                    <p>The minimum age for check-in is 18</p>
                </div>
            </div>
            <div class="rule">
                <div class="icon1">🐕</div>
                <div class="details">
                    <h4>Pets</h4>
                    <p>Pets are not allowed.</p>
                </div>
            </div>
            <div class="rule">
                <div class="icon1">💳</div>
                <div class="details">
                    <h4>This property accepts</h4>
                    <p>Visa, Mastercard, American Express, Cash</p>
                </div>
            </div>
        </div>

    </div>

    <footer style=" margin-top: 150px;">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>

    <script src="../script/hotel1.js"></script>
</body>

</html>
// In /WEB2-Ebooking/src/script/aboutus.js
$(document).ready(function () {
    const $goTopBtn = $('.gotopbtn');
    const header = document.querySelector('header');

    window.addEventListener('scroll', function () {
        // Handle "Go to top" button visibility
        if ($(window).scrollTop() > 500) {
            $goTopBtn.stop().css('visibility', 'visible').animate({ opacity: 1 }, 300);
        } else {
            $goTopBtn.stop().animate({ opacity: 0 }, 300, function () {
                $(this).css('visibility', 'hidden');
            });
        }

        // Handle header background color
        if (document.body.scrollTop > 70 || document.documentElement.scrollTop > 70) {
            header.style.backgroundColor = "rgb(4,22,37)";
        } else {
            header.style.backgroundColor = "transparent";
        }
    });

    $goTopBtn.click(function () {
        $('html, body').animate({ scrollTop: 0 }, 800);
    });
});

// Audio handling
const audio = document.getElementById("audio");
const audioIcon = document.getElementById("audio-icon");

audioIcon.addEventListener("click", function () {
    audio.play();
});

// Sidebar toggle
const list1 = document.querySelector(".list1");
const sidebar1 = document.querySelector(".sidebar1");

list1.addEventListener('click', function () {
    sidebar1.classList.toggle("sidebar-special1");
});
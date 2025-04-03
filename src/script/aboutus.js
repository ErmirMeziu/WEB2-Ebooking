/*list show */
const list1 = document.querySelector(".list1");
const sidebar1 = document.querySelector(".sidebar1");

list1.addEventListener('click', function () {
    sidebar1.classList.toggle("sidebar-special1");
});

// Get the elements
const contactBtn = document.querySelector('.button-show');
const show_hide = document.querySelector('.show-hide');
const closeContactForm = document.querySelector('.close-form');

//toggle show-hide
contactBtn.addEventListener('click', function () {
    show_hide.classList.add('show-hide-special');
    show_hide.scrollIntoView({ behavior: 'smooth', block: 'start' });
});

closeContactForm.addEventListener('click', function () {
    show_hide.classList.remove('show-hide-special');
})


/*go to top */
$(document).ready(function () {
    const $goTopBtn = $('.gotopbtn');

    // Kontrollo lëvizjen në scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 500) {
            $goTopBtn.stop().css('visibility', 'visible').animate({ opacity: 1 }, 300);
        } else {
            $goTopBtn.stop().animate({ opacity: 0 }, 300, function () {
                $(this).css('visibility', 'hidden');
            });
        }
    });

    $goTopBtn.click(function () {
        $('html, body').animate({ scrollTop: 0 }, 800);
    });
});


//Audio
const audio = document.getElementById("audio");
const audioIcon = document.getElementById("audio-icon");

audioIcon.addEventListener("click", function () {
    audio.play();
});





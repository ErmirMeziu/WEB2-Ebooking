/* backgroud-slideshow */
var i = 0;
var images = [
    'images/home-background/first.jpg',
    'images/home-background/second.jpg',
    'images/home-background/third.jpg',
    'images/home-background/fourth.jpg',
    'images/home-background/fifth.jpg'
];
var imglength = images.length - 1;


var time = 5000;
const home = document.querySelector(".home");


function changeImg(callback) {
    home.style.backgroundImage = `url(${images[i]})`;

    i < imglength ? i++ : i = 0;

    setTimeout(() => callback(changeImg), time);
}

// callback function
changeImg(changeImg);

/* header */
const header = document.querySelector("header");
const gotopbtn = document.querySelector(".gotopbtn");

window.onscroll = function () {

    if (document.body.scrollTop > 70 || document.documentElement.scrollTop > 70) {
        header.style.backgroundColor = "rgb(4,22,37)";
    } else {
        header.style.backgroundColor = "transparent";
    }

    if (document.body.scrollTop > 900 || document.documentElement.scrollTop > 900) {
        gotopbtn.classList.add("gotopbtn-special");
    } else {
        gotopbtn.classList.remove("gotopbtn-special");
    }
};


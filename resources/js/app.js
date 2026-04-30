import './bootstrap';

//import Alpine from 'alpinejs';

//window.Alpine = Alpine;

//Alpine.start();

//Frontpage and webshop page carousel JS code
const carouselTrack = document.getElementById("carouselTrack");
const carouselItem = document.getElementById('carouselItem');
const carouselScreenShot = document.getElementById("carouselTrackScreenShot");
const carouselItemScreenShot = document.getElementById('carouselItemScreenShot');
const scrollOptions = { behavior: 'smooth' };
const leftBtn = document.querySelector('.nav-left');
const rightBtn = document.querySelector('.nav-right');
const leftBtnScreenShots = document.querySelector('.nav-left-screen');
const rightBtnScreenShots = document.querySelector('.nav-right-screen');
let isHovered = false;
let stopAutoScroll = false;
if (leftBtn) {
    leftBtn.addEventListener('click', () => {
        //Webshop page part
        const itemWidth = carouselItem.offsetWidth;
        carouselTrack.scrollBy({
            left: -itemWidth,
            ...scrollOptions
        });


    });
}
if (rightBtn) {
    rightBtn.addEventListener('click', () => {
        //Webshop page part
        const itemWidth = carouselItem.offsetWidth;
        carouselTrack.scrollBy({
            left: itemWidth,
            ...scrollOptions
        });

    });
}

//Screenshot part
if (leftBtnScreenShots) {
    leftBtnScreenShots.addEventListener('click', () => {
        //Webshop page part
        const itemWidth = carouselItemScreenShot.offsetWidth;
        carouselTrackScreenShot.scrollBy({
            left: -itemWidth,
            ...scrollOptions
        });


    });
}
if (rightBtnScreenShots) {
    rightBtnScreenShots.addEventListener('click', () => {
        //Webshop page part
        const itemWidth = carouselItemScreenShot.offsetWidth;
        carouselTrackScreenShot.scrollBy({
            left: itemWidth,
            ...scrollOptions
        });

    });
}


import './bootstrap';

//import Alpine from 'alpinejs';

//window.Alpine = Alpine;

//Alpine.start();

//Frontpage and webshop page carousel JS code
const carouselTrack = document.getElementById("carouselTrack");
const carouselItem = document.getElementById('carouselItem');
const scrollOptions = { behavior: 'smooth' };
const leftBtn = document.querySelector('.nav-left');
const rightBtn = document.querySelector('.nav-right');
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
        stopAutoScroll = true;
            //Webshop page part
            const itemWidth = carouselItem.offsetWidth;
            carouselTrack.scrollBy({
                left: itemWidth,
                ...scrollOptions
            });
        
    });
}




import './bootstrap';

//import Alpine from 'alpinejs';

//window.Alpine = Alpine;

//Alpine.start();

//Frontpage and webshop page carousel JS code
const track = document.getElementById('carouselTrack');
const trackDiscounted = document.getElementById("carouselTrackDiscounted");
const discountedItem = document.getElementById('discountedItem');
const scrollOptions = { behavior: 'smooth' };
const leftBtn = document.querySelector('.nav-left');
const rightBtn = document.querySelector('.nav-right');
let isHovered = false;
let stopAutoScroll = false;
if(leftBtn){
leftBtn.addEventListener('click', () => {
    stopAutoScroll = true;
    if(track){
        //First/welcome page part
    track.scrollBy({
        left: -200,
       ...scrollOptions
    });
    }else {
        //Webshop page part
        const itemWidth = discountedItem.offsetWidth;
trackDiscounted.scrollBy({ 
    left: -itemWidth, 
    ...scrollOptions });
    }

});
}
if(rightBtn){
    rightBtn.addEventListener('click', () => {
    stopAutoScroll = true;
    if(track){
        //First/welcome page part
    track.scrollBy({
        left: 200,
        ...scrollOptions
    });
    }else{
    //Webshop page part
    const itemWidth = discountedItem.offsetWidth; 
    trackDiscounted.scrollBy({ 
    left: itemWidth, 
    ...scrollOptions });
    }
});
}
function autoScroll() {
  if (!track || isHovered || stopAutoScroll) {
    requestAnimationFrame(autoScroll);
    return;
    }
    
  track.style.scrollBehavior = 'auto';
  track.scrollLeft += 0.50;


    const halfway = track.scrollWidth / 2;
    if (track.scrollLeft >= halfway) {

        track.scrollLeft = 0.50; 

    }

    requestAnimationFrame(autoScroll);
}

// Start auto-scrolling when DOM is ready
window.addEventListener('load', () => {
    autoScroll();
});
if(track){
track.addEventListener('mouseenter', () => {
    isHovered = true;
});
}
if(track){
track.addEventListener('mouseleave', () => {
    isHovered = false;
});
}


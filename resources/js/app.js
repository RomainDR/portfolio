import AOS from 'aos';
import 'aos/dist/aos.css';

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';


document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        once: true,
    });
});

const swiper = new Swiper('.swiper', {
    direction: 'horizontal',
    loop: true,
    //autoplay: {
    //    delay: 5000,
    //},

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
});

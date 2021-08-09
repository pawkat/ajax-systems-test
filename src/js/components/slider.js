'use strict';

import {Swiper, Navigation} from "swiper";

Swiper.use(Navigation);

!(function ($) {
    const $sliders = $('.js-slider');
    $sliders.each((i, slider) => {
        const swiper = new Swiper(slider, {
            direction: 'horizontal',
            spaceBetween: 0,
            slidesPerView: 1,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
        if (swiper.slides.length >= 3) {
            swiper.slideTo(1);
        }
    });

})(jQuery);

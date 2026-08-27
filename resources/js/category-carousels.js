import Swiper from 'swiper';
import { Autoplay } from 'swiper/modules';

document.querySelectorAll('.category-carousel').forEach((el) => {
    new Swiper(el, {
        modules: [Autoplay],
        slidesPerView: 2,
        spaceBetween: 12,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 24 },
            1024: { slidesPerView: 4, spaceBetween: 32 },
        },
    });
});

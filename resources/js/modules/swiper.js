import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';

document.querySelectorAll('.gallery-swiper').forEach((el) => {
  new Swiper(el, {
    modules: [Navigation, Pagination, Autoplay],
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    navigation: {
      prevEl: el.parentElement.querySelector('.gallery-swiper-prev'),
      nextEl: el.parentElement.querySelector('.gallery-swiper-next'),
    },
    pagination: {
      el: el.parentElement.querySelector('.swiper-pagination'),
      clickable: true,
    },
  });
});

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import './modules/maps.js';
import './modules/iso.js';
import './modules/filter.js';
import './modules/swiper.js';
import './modules/lightbox.js';
import './modules/scrollreveal.js';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();
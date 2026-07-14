import Swiper from 'swiper';
import { Navigation, Pagination, Keyboard } from 'swiper/modules';
import 'swiper/css';

const overlay = document.querySelector('[data-lightbox-overlay]');

if (overlay) {
  const wrapper = overlay.querySelector('[data-lightbox-wrapper]');
  const groupsEl = overlay.querySelector('[data-lightbox-groups]');
  const groups = groupsEl ? JSON.parse(groupsEl.textContent) : {};

  let swiper = null;
  let currentGroup = null;

  const buildSlides = (images) => {
    wrapper.innerHTML = images
      .map(
        (image) => `
        <div class="swiper-slide flex items-center justify-center">
          <picture class="flex items-center justify-center w-full h-full">
            <source srcset="${image}.avif" type="image/avif">
            <source srcset="${image}.webp" type="image/webp">
            <img src="${image}.jpg" alt="" class="max-w-full max-h-full object-contain" />
          </picture>
        </div>`
      )
      .join('');
  };

  const open = (groupId, index) => {
    const images = groups[groupId];
    if (!images || !images.length) return;

    if (currentGroup !== groupId) {
      buildSlides(images);
      currentGroup = groupId;

      if (swiper) swiper.destroy(true, true);
      swiper = new Swiper(overlay.querySelector('.lightbox-swiper'), {
        modules: [Navigation, Pagination, Keyboard],
        keyboard: { enabled: true },
        navigation: {
          prevEl: overlay.querySelector('.lightbox-swiper-prev'),
          nextEl: overlay.querySelector('.lightbox-swiper-next'),
        },
        pagination: {
          el: overlay.querySelector('.lightbox-swiper-pagination'),
          clickable: true,
        },
      });
    }

    swiper.slideTo(index, 0);
    window.dispatchEvent(new CustomEvent('lightbox-open'));
  };

  document.querySelectorAll('[data-lightbox]').forEach((trigger) => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      open(
        trigger.dataset.lightbox,
        parseInt(trigger.dataset.lightboxIndex, 10) || 0
      );
    });
  });

  // Close when clicking the backdrop (but not the swiper / controls)
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      window.dispatchEvent(new CustomEvent('lightbox-close'));
    }
  });
}

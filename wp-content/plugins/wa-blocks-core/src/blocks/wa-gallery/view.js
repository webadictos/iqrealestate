/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */
// console.log('Hello World! (from wa-blocks-core-wa-gallery block)');
/* eslint-enable no-console */

import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import SimpleLightbox from 'simplelightbox';

// import 'swiper/swiper-bundle.css'; // Importa los estilos CSS de SwiperJS

const swiperCarrusel = (() => {
  const init = (contenedor = document) => {
    contenedor
      .querySelectorAll('.wa-swipper-gallery')
      .forEach(swiperElement => createSwiper(swiperElement));
  };

  const createSwiper = item => {
    const itemConfig = JSON.parse(item.getAttribute('data-wa-gallery') ?? {});

    let swiperConfig = {
      slideClass: 'swiper-slide',
      direction: 'horizontal',
      //centeredSlides: true,
      loop: false,
      slidesPerView: 3,
      spaceBetween: 10,
      mousewheel: true,
      autoHeight: true,
      modules: [],
      breakpoints: {},
      grabCursor: true,
    };

    swiperConfig.direction = itemConfig.direction ?? 'horizontal';
    swiperConfig.loop = itemConfig.loop ?? false;
    swiperConfig.slidesPerView = itemConfig.slidesPerView ?? 2;
    swiperConfig.autoHeight = itemConfig.autoheight ?? true;
    swiperConfig.spaceBetween = itemConfig.spaceBetween ?? 0;

    if (itemConfig.pagination) {
      swiperConfig.modules.push(Pagination);
      swiperConfig.pagination = {
        el: '.swiper-pagination',
        clickable: true,
      };
    }
    if (itemConfig.navigation) {
      swiperConfig.modules.push(Navigation);
      swiperConfig.navigation = {
        nextEl: `.swiper-button-next`,
        prevEl: `.swiper-button-prev`,
      };
    }

    swiperConfig.breakpoints = {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        spaceBetween: 10,
        // slidesOffsetBefore: 30,
        // slidesOffsetAfter: 30,
      },
      // when window width is >= 480px
      768: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      // when window width is >= 1024
      1024: {
        slidesPerView: itemConfig.slidesPerView,
        spaceBetween: itemConfig.spaceBetween,
      },
    };
    // console.log(swiperConfig);

    const swiper = new Swiper(item, swiperConfig);
  };

  return {
    init: init,
  };
})();

swiperCarrusel.init();

const initLightbox = (idContenedor = '') => {
  const imagesLightbox = new SimpleLightbox(
    `${idContenedor} .wa-gallery-lightbox`,
    {
      sourceAttr: 'data-src',
      captionSelector: 'self',
      captionType: 'data',
      captionsData: 'caption',
      loop: false,
      uniqueImages: true,
      showCounter: false,
      nav: false,
      scrollZoom: false,
      overlayOpacity: 0.95,
    }
  );
};

initLightbox();

var bodyEl = document.querySelector('body');
if (bodyEl) {
  bodyEl.addEventListener('is.post-load', e => {
    // console.log(e);
    if (e.detail.postID) {
      const postSelector = document.getElementById(`post-${e.detail.postID}`);
      swiperCarrusel.init(postSelector);
      initLightbox(`#post-${e.detail.postID}`);
    }
  });
}

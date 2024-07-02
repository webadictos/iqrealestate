import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

// import 'swiper/swiper-bundle.css'; // Importa los estilos CSS de SwiperJS

const swiperCarrusel = (() => {
  const init = (contenedor = document) => {
    contenedor
      .querySelectorAll('.wa-swipper-slides')
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
      observeParents: true,
      observer: true,
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
        slidesPerView: itemConfig.slidesPerViewMobile ?? 1,
        spaceBetween: itemConfig?.spaceBetweenMobile ?? itemConfig.spaceBetween,
        direction: itemConfig?.directionMobile ?? 'horizontal',
        // slidesOffsetBefore: 30,
        // slidesOffsetAfter: 30,
      },
      // when window width is >= 480px
      768: {
        slidesPerView: itemConfig?.slidesPerViewTablet ?? 1,
        direction: itemConfig?.directionTablet ?? 'horizontal',
        spaceBetween: itemConfig?.spaceBetweenTablet ?? itemConfig.spaceBetween,
      },
      // when window width is >= 1024
      1024: {
        slidesPerView: itemConfig.slidesPerView ?? 1,
        spaceBetween: itemConfig.spaceBetween,
        direction: itemConfig?.direction ?? 'horizontal',
      },
    };
    // console.log(swiperConfig);

    const swiper = new Swiper(item, swiperConfig);

    // console.log(swiper);
  };

  return {
    init: init,
  };
})();

swiperCarrusel.init();

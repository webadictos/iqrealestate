import Swiper, { Navigation, Pagination, Mousewheel, Autoplay } from 'swiper';

const swiperCarrusel = (() => {
  const swipers = [];

  const init = () => {
    const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');

    if (tabs.length > 0) {
      tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', event => {
          const targetPane = document.querySelector(
            event.target.getAttribute('data-bs-target')
          );
          const swiperElement = targetPane.querySelector(
            '.wa-swiper-component'
          );

          if (
            swiperElement &&
            !swiperElement.classList.contains('swiper-initialized')
          ) {
            // console.log('Initializing swiper:', swiperElement);
            createSwiper(swiperElement);
          }
        });
      });

      // Initialize swiper in the active tab on page load
      const activeTab = document.querySelector(
        '.tab-pane.active .wa-swiper-component'
      );
      if (activeTab) {
        createSwiper(activeTab);
      }
    } else {
      // Initialize all swipers if there are no tabs
      document
        .querySelectorAll('.wa-swiper-component')
        .forEach(swiperElement => {
          if (!swiperElement.classList.contains('swiper-initialized')) {
            createSwiper(swiperElement);
          }
        });
    }
  };

  const createSwiper = item => {
    const itemConfig = item.dataset.carruselConfig
      ? JSON.parse(item.dataset.carruselConfig)
      : null;
    const carouselID = item.dataset.carouselId;

    if (!itemConfig || !carouselID) {
      console.warn(
        'Missing itemConfig or carouselID for swiper element:',
        item
      );
      return;
    }

    let swiperConfig = {
      slideClass: 'swiper-slide',
      direction: 'horizontal',
      centeredSlides: false,
      loop: false,
      observer: true,
      observerParents: true,
      slidesPerView: 3,
      spaceBetween: 10,
      mousewheel: true,
      autoHeight: true,
      modules: [],
      breakpoints: {},
    };

    swiperConfig.direction = itemConfig.direction;
    swiperConfig.loop = itemConfig.loop;
    swiperConfig.slidesPerView = itemConfig.items_visible;
    swiperConfig.autoHeight = itemConfig.autoheight;
    swiperConfig.spaceBetween = itemConfig.items_gap;
    swiperConfig.centeredSlides = itemConfig.centered;

    if (itemConfig.pagination) {
      swiperConfig.modules.push(Pagination);
      swiperConfig.pagination = {
        el: '.swiper-pagination',
        clickable: true,
      };
    }

    if (itemConfig.mousewheel) {
      swiperConfig.modules.push(Mousewheel);
    }

    if (itemConfig.navigation) {
      swiperConfig.modules.push(Navigation);
      swiperConfig.navigation = {
        nextEl: `#swiper-carousel-${carouselID} .swiper-button-next`,
        prevEl: `#swiper-carousel-${carouselID} .swiper-button-prev`,
      };
    }

    if (itemConfig.autoplay) {
      swiperConfig.modules.push(Autoplay);
      swiperConfig.autoplay = {
        delay: 2500,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      };
    }

    swiperConfig.breakpoints = {
      320: {
        slidesPerView: itemConfig.items_visible_movil,
        spaceBetween: itemConfig.items_gap,
        // slidesOffsetBefore: 30,
        // slidesOffsetAfter: 30,
      },
      768: {
        slidesPerView: itemConfig.items_visible_tablet,
        spaceBetween: itemConfig.items_gap,
      },
      1024: {
        slidesPerView: itemConfig.items_visible,
        spaceBetween: itemConfig.items_gap,
      },
    };

    const swiper = new Swiper(item, swiperConfig);
    item.classList.add('swiper-initialized');
    swipers.push(swiper);

    const collapsedItems = item.querySelectorAll('.collapse');

    if (collapsedItems) {
      collapsedItems.forEach(collapsedItem => {
        collapsedItem.addEventListener('shown.bs.collapse', () => {
          swiper.updateAutoHeight(150);
        });
        collapsedItem.addEventListener('hidden.bs.collapse', () => {
          swiper.updateAutoHeight(150);
        });
      });
    }
  };

  return {
    init: init,
  };
})();

export { swiperCarrusel };

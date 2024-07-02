/*
 * Sticky Header
 */
const body = document.body;
const nav = document.querySelector('#masthead');
const siteMain = document.querySelector('.site-main');
const header = document.querySelector('#masthead');
const stickyHeaderHeight = document.querySelector(':root');

const stickiesToDetach = document.querySelectorAll('[data-detach-sticky="1"]');
const adFixedTop = document.querySelector('.ad-fixed-top');

let eventDistpatched = false;
let canChangeClass = true;

const dispatchStickyEvent = () => {
  if (!eventDistpatched) {
    const stickyEvent = new CustomEvent('is.sticky', {});
    document.querySelector('body').dispatchEvent(stickyEvent);
    eventDistpatched = true;
  }
  canChangeClass = false;
};

const dispatchUnStickyEvent = () => {
  if (eventDistpatched) {
    const stickyEvent = new CustomEvent('is.unsticky', {});
    document.querySelector('body').dispatchEvent(stickyEvent);
    eventDistpatched = false;
  }
  canChangeClass = true;
};

const handleScroll = () => {
  const body = document.body;
  const scrollPosition = window.scrollY || window.pageYOffset;
  stickyHeaderHeight.style.setProperty(
    '--sticky-header',
    '' + nav.offsetHeight / 16 + 'rem'
  );
  //--sticky-ad-top

  if (adFixedTop && adFixedTop.classList.contains('sticky-top')) {
    stickyHeaderHeight.style.setProperty(
      '--sticky-ad-top',
      '' + adFixedTop.offsetHeight / 16 + 'rem'
    );
  } else {
    stickyHeaderHeight.style.setProperty('--sticky-ad-top', '0rem');
  }

  // Verificar si el desplazamiento es mayor que la altura de nav#superior
  if (scrollPosition > header.offsetHeight + 32) {
    body.classList.add('is-scrolling');
    dispatchStickyEvent();
  } else {
    body.classList.remove('is-scrolling');
    dispatchUnStickyEvent();
  }
};

// Agregar el evento de desplazamiento al documento
window.addEventListener('scroll', handleScroll);

if (stickiesToDetach) {
  const bodyEl = document.querySelector('body');
  if (bodyEl) {
    bodyEl.addEventListener('is.sticky', e => {
      stickiesToDetach.forEach(function (sticky) {
        // Hacer algo con cada elemento, por ejemplo, imprimir su contenido

        const timeToDetach = parseInt(sticky.dataset.detachTime ?? 1);
        let hidePosition = navSuperior.offsetHeight + sticky.offsetHeight;

        setTimeout(() => {
          // sticky.style.backgroundColor = 'red';
          sticky.style.top = `-${hidePosition}px`;
          setTimeout(() => {
            sticky.classList.remove('sticky-top');
            stickyHeaderHeight.style.setProperty('--sticky-ad-top', '0rem');
          }, 500);
          // sticky.classList.remove('sticky-top');
        }, timeToDetach * 1000);
      });
    });
  }
}

// const config = {
//   root: null,
//   rootMargin: '0px 0px 0px',
//   threshold: 0,
// };

// // console.log(hero);
// let isHeroVisible = false;
// const observer = new IntersectionObserver(function (entries, observer) {
//   entries.forEach(entry => {
//     console.log(entry.intersectionRatio);

//     if (entry.intersectionRatio === 0) {
//       nav.classList.add('isSticky');
//       body.classList.add('sticky-active');
//     } else {
//       nav.classList.remove('isSticky');
//       body.classList.remove('sticky-active');
//     }
//   });
// }, config);

// if (siteMain) {
//   observer.observe(siteMain);
// }

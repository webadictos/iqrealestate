// import GLightbox from 'glightbox';

// const lightbox = GLightbox({
//   selector: '.glightbox',
//   touchNavigation: true,
//   loop: true,
//   autoplayVideos: true,
// });

import SimpleLightbox from 'simplelightbox';

const currentArticle = WA_ThemeSetup.currentID;

const initLightbox = postID => {
  if (document.querySelector('[data-full-image]')) {
    const imagesLightbox = new SimpleLightbox(
      `#post-${postID} .entry-main-text img`,
      {
        sourceAttr: 'data-full-image',
        captionSelector: 'self',
        captionType: 'data',
        captionsData: 'lightboxcaption',
        loop: false,
        uniqueImages: true,
        showCounter: false,
        nav: false,
        scrollZoom: false,
        overlayOpacity: 0.95,
        preloading: false,
      }
    );
  }
  if (document.querySelector('.wa-gallery-lightbox')) {
    const galleryLightbox = new SimpleLightbox(`.wa-gallery-lightbox`, {
      sourceAttr: 'data-src',
      captionSelector: 'self',
      captionType: 'data',
      captionsData: 'caption',
      loop: false,
      uniqueImages: true,
      showCounter: false,
      nav: true,
      scrollZoom: false,
      overlayOpacity: 0.95,
    });
  }
};

const initLightboxForInfiniteScroll = e => {
  if (e.detail.postID) {
    //console.log(`Loading dependencies for #post-${e.detail.postID}`);
    WA_ThemeSetup.currentID = e.detail.postID;
    initLightbox(e.detail.postID);
  }
};

initLightbox(currentArticle);

document
  .querySelector('body')
  .addEventListener('is.post-load', initLightboxForInfiniteScroll);

// imagesLightbox.on('show.simplelightbox', function () {
//   // do something…
//   console.log('Se abrio');
// });

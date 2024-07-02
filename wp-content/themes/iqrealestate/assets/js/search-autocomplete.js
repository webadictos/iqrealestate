import * as bootstrap from 'bootstrap';

const collapseSearch = document.getElementById('collapse-search');
const collapseSearchBar = document.getElementById('collapse-search-bar');

const body = document.body;
// const overlay = document.querySelector('.overlay-background');
// const searchResults = document.querySelector('.searchwp-live-search-results');

// collapseSearch.addEventListener('show.bs.collapse', event => {
//   // document.addEventListener('keydown', cerrarCollapse);

//   // if (overlay) {
//   //   overlay.classList.add('show');
//   // }
// });

// overlay.addEventListener('click', event => {
//   var collapse = new bootstrap.Collapse(collapseSearch);
//   collapse.hide();
// });

collapseSearch.addEventListener('shown.bs.collapse', event => {
  // body.style.overflow = 'hidden';
  // body.style.paddingRight = '0';
  document.getElementById('search-component__search-input').value = '';

  document.getElementById('search-component__search-input').focus();
});

collapseSearchBar.addEventListener('shown.bs.collapse', event => {
  // body.style.overflow = 'hidden';
  // body.style.paddingRight = '0';
  document.getElementById('search-component__search-input-bar').value = '';

  document.getElementById('search-component__search-input-bar').focus();
});

// collapseSearch.addEventListener('hide.bs.collapse', event => {
//   body.style.overflow = '';
//   body.style.paddingRight = '';
//   if (overlay) {
//     overlay.classList.remove('show');
//   }
//   if (searchResults) {
//     searchResults.classList.remove('searchwp-live-search-results-showing');
//   }
//   document.removeEventListener('keydown', cerrarCollapse);
// });

// const cerrarCollapse = event => {
//   if (event.key === 'Escape') {
//     var collapse = new bootstrap.Collapse(collapseSearch);
//     collapse.hide();
//   }
// };

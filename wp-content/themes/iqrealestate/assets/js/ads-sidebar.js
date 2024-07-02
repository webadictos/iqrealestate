import { screen_min_width } from './wordpress-functions';

//Validamos que sea desktop para iniciar el handlescroll
if (screen_min_width('992px')) {
  //   const sidebar = document.querySelector(
  //     `#post-${WA_ThemeSetup.currentID} aside.single-widget-area`
  //   );

  const handleScroll = () => {
    const body = document.body;
    const scrollPosition = window.scrollY || window.pageYOffset;
    const sidebar = document.querySelector(
      `#post-${WA_ThemeSetup.currentID} aside.single-widget-area`
    );
    //Validamos si existe sidebar en ese layout
    if (sidebar) {
      const sidebarHeight = sidebar.offsetHeight;

      const adUnitHeight = sidebarHeight / 2 - 100;

      sidebar.style.setProperty('--ad-unit-height', '' + adUnitHeight + 'px');
    }
  };

  // Agregar el evento de desplazamiento al documento
  window.addEventListener('scroll', handleScroll);
}

import { cloudflareParser } from './js/cloudflare-parser';
import {
  getEditionInfoByCountry,
  buscarEdicionPorNombre,
} from './js/country-codes-utils';

// console.log(
//   `%c

//   HOME

//   `,
//   'color: red;padding-bottom:.5rem;font-size:1.2rem;'
// );

const getActiveEdition = async () => {
  // Verificar si el parámetro 'edicion' está presente en la URL
  const urlParams = new URLSearchParams(window.location.search);
  const edicionParametro = urlParams.get('edicion');
  let activeEdition = null;

  if (edicionParametro) {
    // Si el parámetro 'edicion' está presente, usar la función buscarPorNombre
    const edicionObj = buscarEdicionPorNombre(edicionParametro);

    if (edicionObj) {
      sessionStorage.setItem('edicion', JSON.stringify(edicionObj));
      activeEdition = edicionObj;
    }
  } else {
    // Si no está presente, verificar sessionStorage
    const activeEditionString = sessionStorage.getItem('edicion');
    if (activeEditionString) {
      // Si sessionStorage tiene el objeto, utilizarlo
      activeEdition = JSON.parse(activeEditionString);
    } else {
      // Si no, obtener información de edición por país
      // Suponiendo que tengas el código de país almacenado en algún lugar
      // const countryCode = obtenerCodigoPais();
      // activeEdition = getEditionInfoByCountry(countryCode);
      let CFcountryLookup = await cloudflareParser(
        'https://www.cloudflare.com/cdn-cgi/trace'
      );
      // console.log(CFcountryLookup); // Muestra el código del país

      activeEdition = getEditionInfoByCountry(CFcountryLookup);

      if (activeEdition) {
        sessionStorage.setItem('edicion', JSON.stringify(activeEdition));
      }
    }
  }

  if (activeEdition) {
    const btnEdition = document.querySelectorAll('.menu-editions__btn');
    const logoLink = document.getElementById('logo-edition');
    const logoNavLink = document.getElementById('logo-edition-nav');

    if (btnEdition) {
      btnEdition.forEach(btn => {
        btn.innerText = activeEdition.name;
      });
    }

    if (logoLink) {
      logoLink.setAttribute(
        'href',
        `${activeEdition.link}?edicion=${activeEdition.slug}`
      );
    }
    if (logoNavLink) {
      logoNavLink.setAttribute(
        'href',
        `${activeEdition.link}?edicion=${activeEdition.slug}`
      );
    }
  }
};

if (document.querySelector('.menu-editions__btn')) {
  getActiveEdition();
}

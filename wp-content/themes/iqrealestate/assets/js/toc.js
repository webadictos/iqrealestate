// /*
//  * Sticky Header
//  */
// const toc = document.querySelector('.toc-wrapper');
// const viewAllContainer = document.querySelector('.toc-wrapper-view-all');
// const viewAllBtn = document.querySelector('.btn-view-all');
// const tocList = toc.querySelector('ul');

// console.log('HOLA');
// console.log(tocList.scrollHeight, tocList.clientHeight);

// if (tocList.scrollHeight > tocList.clientHeight) {
//   // Agregar la clase "show" al botón
//   viewAllContainer.classList.add('show');
// } else {
//   viewAllContainer.classList.remove('show');
// }

// viewAllBtn.addEventListener('click', e => {
//   if (toc.classList.contains('expanded')) {
//     toc.classList.remove('expanded');
//     viewAllBtn.innerText = 'Ver todo';
//     viewAllBtn.classList.remove('expanded');
//   } else {
//     viewAllBtn.classList.add('expanded');
//     viewAllBtn.innerText = 'Ver menos';
//     toc.classList.add('expanded');
//   }
// });

const toc = document.querySelector('.toc-wrapper');
const viewAllContainer = document.querySelector('.toc-wrapper-view-all');
const viewAllBtn = document.querySelector('.btn-view-all');
const tocList = toc.querySelector('ul');
const anchors = tocList.querySelectorAll('a');

const validarDesbordamiento = () => {
  if (tocList.scrollHeight > tocList.clientHeight) {
    viewAllContainer.classList.add('show');
  } else {
    viewAllContainer.classList.remove('show');
    toc.classList.add('expanded');
  }
};

window.addEventListener('load', validarDesbordamiento);
window.addEventListener('resize', validarDesbordamiento);

viewAllBtn.addEventListener('click', e => {
  if (toc.classList.contains('expanded')) {
    toc.classList.remove('expanded');
    viewAllBtn.innerText = 'Ver todo';
    viewAllBtn.classList.remove('expanded');
  } else {
    viewAllBtn.classList.add('expanded');
    viewAllBtn.innerText = 'Ver menos';
    toc.classList.add('expanded');
  }
});

anchors.forEach(anchor => {
  anchor.addEventListener('click', e => {
    e.preventDefault(); // Evitar el comportamiento predeterminado del enlace

    const targetId = anchor.getAttribute('href').substring(1); // Obtener el ID de destino sin el signo #
    const targetElement = document.getElementById(targetId); // Obtener el elemento de destino

    if (targetElement) {
      targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Desplazar suavemente con centrado
    }
  });
});

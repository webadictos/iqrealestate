const dispatchSectionLoadedEvent = idSection => {
  const newSectionLoaded = new CustomEvent('is.section-loaded', {
    detail: {
      section: idSection,
    },
  });
  document.querySelector('body').dispatchEvent(newSectionLoaded);
};

// Define una función para manejar la observación de elementos
function handleIntersection(entries, observer) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // Renderiza el contenido dentro del template
      const idSection = entry.target.dataset.sectionId;

      const template = document.getElementById(`template-${idSection}`);

      //   console.log('Seccion', idSection);

      if (template) {
        const contenido = template.content.cloneNode(true);
        entry.target.appendChild(contenido);

        dispatchSectionLoadedEvent(idSection);
      }

      // Deja de observar el elemento una vez que se ha cargado
      observer.unobserve(entry.target);
    }
  });
}

// Crea un Intersection Observer
const options = {
  root: null,
  rootMargin: '300px', // Cambiado a -300px para activar 300px antes de ser visible
  threshold: 0, // Ajusta el umbral según tus necesidades
};
const observer = new IntersectionObserver(handleIntersection, options);

// Observa elementos que contienen las plantillas
const elementosObservados = document.querySelectorAll(
  '[data-wa-lazysection="true"]'
);

elementosObservados.forEach(elemento => {
  observer.observe(elemento);
});

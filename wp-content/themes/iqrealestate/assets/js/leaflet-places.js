import L from 'leaflet';

const PlacesMap = (() => {
  /**
   * THEME VARS
   */

  const themeUri = WA_ThemeSetup.themeUri;
  const iconMarker = `${themeUri}/assets/images/icons/location.svg`;
  const iconMarkerActive = `${themeUri}/assets/icons/location.svg`;

  let mapCenter = {
    lat: 19.4326018,
    lng: -99.1332049,
  };
  const initialZoom = 15;

  const iconMarkerL = L.icon({
    iconUrl: iconMarker,
    iconSize: [35, 48],
  });
  const iconMarkerActiveL = L.icon({
    iconUrl: iconMarkerActive,
    iconSize: [35, 48],
  });

  /**
   * Methods
   */
  const init = () => {
    const projects = document.querySelectorAll('.single-project__map');

    if (projects) {
      [...projects].forEach(project => {
        loadMap(project);
      });
    }
  };
  const isMobile = () => {
    const isMobile = window.matchMedia('(max-width: 991px)');

    return isMobile.matches;
  };

  const loadMap = project => {
    const map = L.map(project.id);

    map.on('load', function () {
      renderPlacesIntoMap(project, map);
    });

    map.setView(
      [project.dataset.latitude, project.dataset.longitude],
      initialZoom
    );

    const tiles = L.tileLayer(
      'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
      {
        maxZoom: 19,
        attribution:
          '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }
    ).addTo(map);
  };

  const renderPlacesIntoMap = (project, map) => {
    let isFirstIteration = true;

    if (project.dataset?.latitude && project.dataset?.longitude) {
      const projectItem = {
        id: project.dataset.id,
        latitud: parseFloat(project.dataset.latitude),
        longitud: parseFloat(project.dataset.longitude),
      };

      addPlaceIntoMap(projectItem, map);

      if (isFirstIteration) {
        map.setView({ lat: projectItem.latitud, lng: projectItem.longitud });
        isFirstIteration = false; // Cambia la variable de control para las siguientes iteraciones
      }
    }
  };

  const addPlaceIntoMap = (projectItem, map) => {
    const latitud = projectItem.latitud;
    const longitud = projectItem.longitud;

    const marker = L.marker([latitud, longitud], { icon: iconMarkerL }).addTo(
      map
    );
  };

  return {
    init: init,
  };
})();

export { PlacesMap };

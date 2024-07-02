export function getEditionInfoByCountryDos(userCountryCode) {
  // Obtener el objeto JSON de las ediciones
  const editions = WA_ThemeSetup?.editions;

  if (!editions) return false;

  // Variable para almacenar el enlace
  let activeEdition = null;

  // Iterar sobre las ediciones
  for (const edition of editions) {
    for (const key in edition) {
      if (edition.hasOwnProperty(key)) {
        // Verificar si el código de país está presente en la edición actual
        if (
          edition[key].country_codes &&
          edition[key].country_codes.includes(userCountryCode)
        ) {
          activeEdition = edition[key];
          break; // Si encontramos el país en alguna edición, detenemos la iteración
        }
      }
    }
    if (activeEdition) {
      break; // Si ya encontramos el enlace, detenemos la iteración externa
    }
  }

  // Si no se encontró ninguna edición para el país, se usa la edición global
  if (!activeEdition) {
    for (const edition of editions) {
      for (const key in edition) {
        if (key === 'global') {
          activeEdition = edition[key];
          break;
        }
      }
      if (activeEdition) {
        break;
      }
    }
  }

  return activeEdition;
}

export function getEditionInfoByCountry(countryCode) {
  const editions = WA_ThemeSetup?.editions;

  if (!editions) return false;

  // Buscar edición correspondiente al country code
  const foundEdition = editions.find(objeto => {
    const edicion = Object.values(objeto)[0];
    return edicion.country_codes.includes(countryCode);
  });

  // Si se encuentra la edición, devolverla
  if (foundEdition) {
    return Object.values(foundEdition)[0];
  } else {
    // Si no se encuentra, devolver el objeto correspondiente a México
    const globalEdition = editions.find(
      objeto => Object.keys(objeto)[0] === 'global'
    );
    if (globalEdition) {
      return Object.values(globalEdition)[0];
    }
    return false; // Si no se encuentra edición, devolver false o manejarlo según sea necesario
  }
}

const buscarEdicionPorNombre = nombre => {
  const editions = WA_ThemeSetup?.editions ?? [];

  const foundEdition = editions.find(
    objeto => Object.keys(objeto)[0] === nombre
  );
  if (foundEdition) {
    return Object.values(foundEdition)[0];
  } else {
    return null; // O podrías devolver un valor predeterminado o manejar la falta de coincidencia de otra manera.
  }
};

// Exportar la función buscarPorNombre como un módulo
export { buscarEdicionPorNombre };

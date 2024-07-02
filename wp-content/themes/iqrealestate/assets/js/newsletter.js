const newsletter = document.getElementById('newsletter-form');
const newsletterBtn = document.getElementById('newsletter-btn');

// newsletter.addEventListener(
//   'submit',
//   event => {
//     event.preventDefault();
//     event.stopPropagation();

//     const checkboxes = newsletter.querySelectorAll('input[name="lists[]"]');
//     let alMenosUnoMarcado = false;

//     checkboxes.forEach(checkbox => {
//       if (checkbox.checked) {
//         alMenosUnoMarcado = true;
//       }
//     });

//     if (!newsletter.checkValidity() && !alMenosUnoMarcado) {
//       newsletter.classList.add('was-validated');
//     } else {
//       var formData = new FormData(newsletter);
//       var formContainer = document.querySelector(
//         '.modal-newsletter__form-container'
//       );

//       console.log(formData);

//       fetch(WA_ThemeSetup.ajaxurl, {
//         method: 'POST',
//         body: formData,
//       })
//         .then(function (response) {
//           if (response.ok) {
//             // Si la respuesta del servidor es exitosa, muestra un mensaje de éxito
//             formContainer.innerHTML = '<p>Gracias por suscribirte</p>';
//           } else {
//             // Si la respuesta del servidor no es exitosa, muestra un mensaje de error
//             formContainer.innerHTML = '<p>Error al suscribirse</p>';
//           }
//         })
//         .catch(function (error) {
//           // Manejo de errores en caso de fallo en la petición fetch
//           console.error('Error:', error);
//           formContainer.innerHTML = '<p>Error al suscribirse</p>';
//         });
//     }
//   },
//   false
// );

newsletterBtn.addEventListener('click', () => {
  const checkboxes = newsletter.querySelectorAll('input[name="lists[]"]');
  let alMenosUnoMarcado = true;

  //   checkboxes.forEach(checkbox => {
  //     if (checkbox.checked) {
  //       alMenosUnoMarcado = true;
  //     }
  //   });

  //   console.log(newsletter.checkValidity(), alMenosUnoMarcado);

  if (!newsletter.checkValidity() || !alMenosUnoMarcado) {
    newsletter.classList.add('was-validated');
  } else {
    var formData = new FormData(newsletter);
    var formContainer = document.querySelector(
      '.modal-newsletter__form-container'
    );
    const spinner = document.querySelector('.modal-newsletter__spinner');
    const formSuccess = document.querySelector(
      '.modal-newsletter__form-success'
    );

    const downloadBtn = document.getElementById('download-btn');

    formContainer.classList.add('d-none');
    spinner.classList.remove('d-none');

    fetch(WA_ThemeSetup.ajaxurl, {
      method: 'POST',
      body: formData,
    })
      .then(function (response) {
        if (response.ok) {
          // Si la respuesta del servidor es exitosa, muestra un mensaje de éxito
          formSuccess.innerHTML =
            '<p class="text-success text-center fw-bold">Gracias por suscribirte. Da clic enseguida para descargar la revista digital.</p>';

          spinner.classList.add('d-none');
          newsletterBtn.classList.add('d-none');
          if (downloadBtn) {
            downloadBtn.classList.remove('d-none');
          }
        } else {
          spinner.classList.add('d-none');
          formContainer.classList.remove('d-none');
          // Si la respuesta del servidor no es exitosa, muestra un mensaje de error
          formSuccess.innerHTML = '<p>Error al suscribirse</p>';
        }
      })
      .catch(function (error) {
        // Manejo de errores en caso de fallo en la petición fetch
        console.error('Error:', error);
        formSuccess.innerHTML = '<p>Error al suscribirse</p>';
      });
  }
});

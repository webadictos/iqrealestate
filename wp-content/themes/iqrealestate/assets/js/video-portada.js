import { fileLoader } from './file-loader';
import { uniqid } from './wordpress-functions';

const videoPlayers = [];

const insertVideoFile = (figure, videoSource) => {
  if (videoSource) {
    const fileExtension = videoSource.split('.').pop(); // Obtener la extensión del archivo

    const videoElement = document.createElement('video');
    // Agrega los atributos al elemento <video>
    videoElement.autoplay = true;
    videoElement.loop = true;
    videoElement.playsInline = true;
    videoElement.muted = true;
    videoElement.controls = false;
    const sourceElement = document.createElement('source');
    sourceElement.src = videoSource;

    // Determinar el tipo MIME basado en la extensión del archivo
    if (fileExtension === 'webm') {
      sourceElement.type = 'video/webm';
    } else if (fileExtension === 'mp4') {
      sourceElement.type = 'video/mp4';
    } else {
      // Agregar el tipo MIME predeterminado si la extensión no se reconoce
      sourceElement.type = 'video/mp4';
    }

    videoElement.appendChild(sourceElement);

    // Reemplaza el contenido del <figure> con el nuevo reproductor de video
    figure.innerHTML = '';
    figure.appendChild(videoElement);
  }
};

const renderDailyMotionVideo = (innerPlayer, videoSource) => {
  dailymotion
    .createPlayer(innerPlayer.id, {
      video: videoSource,
    })
    .then(player => {
      player.setMute(true);
      player.play();

      videoPlayers[innerPlayer.id] = player;
    })
    .catch(e => console.error(e));
};

const insertDailyMotion = (figure, videoSource) => {
  if (videoSource) {
    const innerPlayer = document.createElement('div');

    innerPlayer.id = 'dailymotion-' + uniqid();
    figure.innerHTML = '';
    figure.appendChild(innerPlayer);

    if (!document.getElementById('dailymotion-js')) {
      fileLoader
        .js(
          'https://geo.dailymotion.com/libs/player/xkg8x.js',
          'dailymotion-js'
        )
        .then(script => {
          renderDailyMotionVideo(innerPlayer, videoSource);
        });
    } else {
      renderDailyMotionVideo(innerPlayer, videoSource);
    }
  }
};

const playVideo = event => {
  event.target.mute();
  event.target.playVideo();
};

const pauseVideos = () => {
  Object.keys(videoPlayers).forEach(player => {
    if (typeof videoPlayers[player].pauseVideo === 'function') {
      // safe to use the function
      videoPlayers[player].pauseVideo();
    } else if (typeof videoPlayers[player].pause === 'function') {
      // safe to use the function
      videoPlayers[player].pause();
    }
  });
};

const renderYouTubeVideo = (innerPlayer, videoSource) => {
  const player = new YT.Player(innerPlayer.id, {
    videoId: videoSource,
    playerVars: {
      height: '100%',
      width: '100%',
      enablejsapi: 1,
      autoplay: 1,
      playsinline: 1,
      modestbranding: 1,
      showinfo: 0,
      rel: 0,
      origin: document.location.origin,
      wmode: 'transparent',
      iv_load_policy: '3',
    },
    events: {
      onReady: playVideo,
    },
  });

  videoPlayers[innerPlayer.id] = player;
};

const insertYouTube = (figure, videoSource) => {
  if (videoSource) {
    const innerContainer = document.createElement('div');

    innerContainer.id = 'youtubevideo-' + uniqid();
    innerContainer.classList.add('ratio');
    innerContainer.classList.add('ratio-16x9');

    const innerPlayer = document.createElement('div');
    innerPlayer.id = 'youtube-player-' + uniqid();

    figure.innerHTML = '';
    figure.appendChild(innerContainer);
    innerContainer.appendChild(innerPlayer);

    if (!document.getElementById('youtube-api')) {
      fileLoader
        .js('https://www.youtube.com/iframe_api', 'youtube-api')
        .then(script => {
          window.onYouTubeIframeAPIReady = () => {
            renderYouTubeVideo(innerPlayer, videoSource);
          };
        });
    } else {
      renderYouTubeVideo(innerPlayer, videoSource);
    }
  }
};

const insertEmbed = (figure, videoSource) => {
  const template = document.getElementById(`${videoSource}`);

  //   console.log('Seccion', idSection);

  if (template) {
    const contenido = template.content.cloneNode(true);
    figure.innerHTML = '';
    figure.appendChild(contenido);
  }
};

// Crea una función para manejar la observación
const handleIntersection = (entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const figure = entry.target;
      const videoSource = figure.getAttribute('data-video-source');
      const videoProvider = figure.getAttribute('data-video-provider');

      pauseVideos();

      switch (videoProvider) {
        case 'archivo':
          insertVideoFile(figure, videoSource);
          break;
        case 'embed':
          insertEmbed(figure, videoSource);
          break;
        case 'dailymotion':
          insertDailyMotion(figure, videoSource);
          break;
        case 'youtube':
          insertYouTube(figure, videoSource);
          break;
      }

      // Deja de observar el elemento una vez que se haya cargado el video
      observer.unobserve(figure);
    }
  });
};

// Configura el Intersection Observer
const observer = new IntersectionObserver(handleIntersection, {
  root: null,
  rootMargin: '0px',
  threshold: 0,
});

// Función para observar elementos
const observeNewFigures = () => {
  const figuresWithVideo = document.querySelectorAll(
    'figure[data-video-source]'
  );

  // Observa cada elemento <figure> con atributo data-video-source
  figuresWithVideo.forEach(figure => {
    observer.observe(figure);
  });
};

// Llama a la función para observar elementos al cargar la página
observeNewFigures();

document.querySelector('body').addEventListener('is.post-load', e => {
  if (e.detail.infinitescroll) {
    observeNewFigures();
  }
});

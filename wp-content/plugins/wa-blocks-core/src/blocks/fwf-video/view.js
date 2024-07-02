const videoFigures = document.querySelectorAll(
  '.wp-block-fw-festival-2024-fwf-video'
);

videoFigures.forEach(figure => {
  const video = figure.querySelector('video');
  const button = figure.querySelector('button');
  const playIcon = `
  <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
  <g>
  <circle id="Ellipse 6" cx="75" cy="75" r="70" stroke="#FDFBDF" stroke-width="10"/>
  <path id="Rectangle 12" d="M54 120L54 38.0002L114.5 79.0001L54 120Z" fill="#FDFBDF"/>
  </g>
  </svg>
  `;
  const pauseIcon = `
  <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
  <g>
  <circle id="Ellipse 6" cx="75" cy="75" r="70" stroke="#FDFBDF" stroke-width="10"/>
  <rect id="Rectangle 14" x="48" y="40" width="16" height="73" fill="#FDFBDF"/>
  <rect id="Rectangle 15" x="89" y="40" width="16" height="73" fill="#FDFBDF"/>
  </g>
  </svg>
  `;

  if (video && button) {
    button.addEventListener('click', () => {
      if (video.paused) {
        video.play();
        button.innerHTML = pauseIcon;
      } else {
        video.pause();
        button.innerHTML = playIcon;
      }
    });

    // Update the button icon based on the initial video state
    video.addEventListener('play', () => {
      button.innerHTML = pauseIcon;
      figure.classList.add('isPlaying');
    });

    video.addEventListener('pause', () => {
      button.innerHTML = playIcon;
      figure.classList.remove('isPlaying');
    });

    // Set the initial icon
    button.innerHTML = video.paused ? playIcon : pauseIcon;
  }
});

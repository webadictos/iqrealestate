window.waAdSlots = window.waAdSlots ?? [];

class WaAdUnit extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = /* html */ `
          <div class="container">
            <h2>Títular del componente</h2>
            <p>Texto y descripción del contenido del componente.</p>
          </div>
        `;
  }
}
customElements.define('wa-adunit', WaAdUnit);

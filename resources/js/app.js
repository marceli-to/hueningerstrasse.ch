import collapse from '@alpinejs/collapse';
import './modules/maps.js';
import './modules/iso.js';
import './modules/filter.js';
import './modules/swiper.js';
import './modules/lightbox.js';
import './modules/scrollreveal.js';

// Alpine wird von Livewire 4 mitgeliefert und dort auch gestartet. Ein eigener
// Alpine-Import mit Alpine.start() laeuft als zweite Instanz und bricht Livewires
// Initialisierung ab: wire:submit bindet dann nicht mehr und das Kontaktformular
// faellt auf einen nativen GET-Submit zurueck (Formulardaten landen in der URL).
// Plugins deshalb ueber livewire:init an Livewires Alpine registrieren.
document.addEventListener('livewire:init', () => {
  window.Alpine.plugin(collapse);
});

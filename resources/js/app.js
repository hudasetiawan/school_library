import './bootstrap';
import './motion';

import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';
import { Indonesian } from 'flatpickr/dist/l10n/id.js';

// Set Flatpickr default locale to Indonesian
flatpickr.localize(Indonesian);

// Make flatpickr available globally for inline scripts
window.flatpickr = flatpickr;

window.Alpine = Alpine;

Alpine.start();

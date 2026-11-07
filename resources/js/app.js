import Alpine from 'alpinejs';
import './audio-player';
import { initStudioAnimations } from './animations';

window.Alpine = Alpine;
Alpine.start();

// Initialize Studio Motion & Interactive Animations when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStudioAnimations);
} else {
    initStudioAnimations();
}

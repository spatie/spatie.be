import images from './images';
import repositories from './repositories';

window.addEventListener('load', images);

[...document.querySelectorAll('[data-repositories]')].forEach(repositories);

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
}

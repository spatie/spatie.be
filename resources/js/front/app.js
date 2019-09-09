import images from './images';

window.addEventListener('load', images);

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
}

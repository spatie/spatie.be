import '../../css/front/front.css'

import Alpine from 'alpinejs';
import images from './images';
import docs from './docs';

window.Alpine = Alpine;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => Alpine.start());
} else {
    Alpine.start();
}

window.addEventListener('load', images);
window.addEventListener('load', docs);

let cleanupAsteroids = null;
let asteroidsCanvas = null;
let asteroidsImportId = 0;

function bootAsteroids() {
    cleanupAsteroids?.();
    cleanupAsteroids = null;

    const canvas = document.querySelector('.js-asteroids');
    asteroidsCanvas = canvas;

    if (! canvas) return;

    const importId = ++asteroidsImportId;

    import('./asteroids').then(({ startAsteroids }) => {
        if (importId !== asteroidsImportId) return;
        if (asteroidsCanvas !== canvas) return;
        if (! document.contains(canvas)) return;

        cleanupAsteroids = startAsteroids(canvas);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootAsteroids, { once: true });
} else {
    bootAsteroids();
}

document.addEventListener('livewire:navigated', bootAsteroids);

/*
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
}
*/

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.getRegistrations().then(function(registrations) {
        for (let registration of registrations) {
            registration
                .unregister()
                .then(function() {
                    return self.clients.matchAll();
                })
                .then(function(clients) {
                    clients.forEach(client => {
                        if (client.url && 'navigate' in client) {
                            client.navigate(client.url);
                        }
                    });
                });
        }
    });
}

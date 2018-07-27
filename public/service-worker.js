'use strict';

const cacheVersion = 3;
const currentCache = {
    offline: 'offline-cache-' + cacheVersion,
};

const offlineUrl = '/offline';

self.addEventListener('install', event => {
    event.waitUntil(
        caches
            .open(currentCache.offline)
            .then(cache => {
                // External request, avoid CORS troubles
                [
                    'https://cloud.typography.com/6194432/6145752/css/fonts.css',
                    'https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver',
                ].map(url => {
                    const request = new Request(url, { mode: 'no-cors' });
                    fetch(request).then(response => cache.put(request, response));
                });

                return cache.addAll(['/css/front.css', '/js/app.js', '/images/offline.jpg', offlineUrl]);
            })
            .then(() => {
                return self.skipWaiting();
            })
    );
});

self.addEventListener('fetch', event => {
    // request.mode = navigate isn't supported in all browsers
    // so include a check for Accept: text/html header.
    if (
        event.request.mode === 'navigate' ||
        (event.request.method === 'GET' && event.request.headers.get('accept').includes('text/html'))
    ) {
        event.respondWith(
            fetch(event.request.url).catch(error => {
                return caches.match(offlineUrl);
            })
        );
    } else {
        // Respond with everything else if we can
        event.respondWith(
            caches.match(event.request).then(response => {
                return response || fetch(event.request, { cache: 'force-cache' });
            })
        );
    }
});

// Cache clean up
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => {
                        return cacheName != currentCache.offline;
                    })
                    .map(cacheName => {
                        return caches.delete(cacheName);
                    })
            );
        })
    );
});

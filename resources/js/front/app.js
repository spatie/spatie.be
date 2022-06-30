import '../../css/front/front.css'

import images from './images';
import docs from './docs';

window.addEventListener('load', images);
window.addEventListener('load', docs);

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

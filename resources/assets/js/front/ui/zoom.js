import { zoom } from '@willemvb/zoom.js/src/zoom.js';

// zoom has little use on 1 col
if (document.body.clientWidth >= 383) {
    document.addEventListener('DOMContentLoaded', () => {
        const elems = document.querySelectorAll('[data-action="zoom"] img');
        for (let i = 0; i < elems.length; i++) {
            elems[i].classList.add('is-zoomable');
            zoom.setup(elems[i]);
        }
    });
}

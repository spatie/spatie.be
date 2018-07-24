import srcsetSize from './ui/srcsetSize';
import repositories from './repositories';
import './ui/zoom';

let resizeTimer;

window.addEventListener('load', () => {
    srcsetSize();
});

window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);

    resizeTimer = setTimeout(() => {
        srcsetSize();
    }, 250);
});

[...document.querySelectorAll('[data-repositories]')].forEach(repositories);

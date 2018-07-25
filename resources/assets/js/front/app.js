import images from './images';
import repositories from './repositories';

window.addEventListener('load', images);

// window.addEventListener('resize', () => {
//     clearTimeout(resizeTimer);

//     resizeTimer = setTimeout(() => {
//         images();
//     }, 250);
// });

[...document.querySelectorAll('[data-repositories]')].forEach(repositories);

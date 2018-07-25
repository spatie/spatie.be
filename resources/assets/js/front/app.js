import images from './images';
import repositories from './repositories';

window.addEventListener('load', images);

[...document.querySelectorAll('[data-repositories]')].forEach(repositories);

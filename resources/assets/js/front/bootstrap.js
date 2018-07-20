/**
 * First we'll require the necessary polyfills for our application.
 */

require('babel-polyfill');

import srcsetSize from './ui/srcsetSize';
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

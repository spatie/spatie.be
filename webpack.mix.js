const mix = require("laravel-mix");

require('laravel-mix-purgecss');

mix.js('resources/js/front/app.js', 'public/js')
    // .postCss('resources/css/front/front.css', 'public/css', [
    //     require('tailwindcss'),
    // ])
    .postCss('resources/css/front/test.css', 'public/css', [
        require('tailwindcss'),
    ])
    .version()
    .purgeCss({
        enabled: false, // temp disable
        whitelistPatterns: [/active/, /grid-span/, /fancybox/, /char-/, /fill-/],
    });

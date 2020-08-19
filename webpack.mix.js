const mix = require("laravel-mix");

require('laravel-mix-purgecss');

mix.version()
    .js('resources/js/front/app.js', 'public/js')
    .postCss('resources/css/front/front.css', 'public/css')

    .version()

    .options({
        postCss: [
            require('tailwindcss'),
        ],
    })

    .purgeCss({
        whitelistPatterns: [/active/, /grid-span/, /fancybox/, /char-/, /fill-/],
    });

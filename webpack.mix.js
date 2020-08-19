const mix = require('laravel-mix');

mix.js('resources/js/front/app.js', 'public/js')
    .postCss('resources/css/front/front.css', 'public/css', [require('tailwindcss')])
    .version();

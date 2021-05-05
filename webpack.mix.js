const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').version()
    .js('resources/js/candidat.js', 'public/js')
    .js('resources/js/projects.js', 'public/js')
    .sass('resources/sass/candidat.scss', 'public/css').version()
    .sass('resources/sass/projet.scss', 'public/css').version()
    .sass('resources/sass/general.scss', 'public/css').version()
    .sass('resources/sass/chat.scss', 'public/css').version()
    .sass('resources/sass/comments.scss', 'public/css').version()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

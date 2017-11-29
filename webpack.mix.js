let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//mix.js('resources/assets/js/app.js', 'public/js');

var tailwindcss = require('tailwindcss');
mix.copyDirectory('resources/assets/plugins', 'public/plugins');
mix.copyDirectory('resources/assets/images', 'public/images');
mix.copyDirectory('resources/assets/js', 'public/js');
mix.sass('resources/assets/scss/style.scss', 'public/css');
mix.sass('resources/assets/scss/pages/dashboard4.scss', 'public/css');
mix.sass('resources/assets/scss/colors/blue.scss', 'public/css');
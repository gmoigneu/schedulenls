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

mix.copyDirectory('resources/assets/images', 'public/images');
mix.copy('resources/assets/scss/icons/themify-icons/fonts/*', 'public/fonts/');
mix.sass('resources/assets/scss/style.scss', 'public/css');


mix.scripts([
    'resources/assets/plugins/jquery/jquery.min.js',
    'resources/assets/plugins/bootstrap/js/popper.min.js',
    'resources/assets/plugins/bootstrap/js/bootstrap.min.js',
    'resources/assets/plugins/sparkline/jquery.sparkline.min.js',
    'resources/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js',
    'resources/assets/js/perfect-scrollbar.jquery.min.js',
    'resources/assets/js/waves.js',
    'resources/assets/js/sidebarmenu.js',
    'resources/assets/js/custom.js'
], 'public/js/app.js');

if (mix.inProduction()) {
    mix.version();
}
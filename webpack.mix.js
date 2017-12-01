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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .copy('node_modules/animate.css/animate.css', 'public/css')
   .copy('node_modules/angular-async-validation/dist/angular-async-validation.js', 'public/js')
   .copy('node_modules/moment-timezone/builds/moment-timezone-with-data-2012-2022.min.js', 'public/js')
   .copy('node_modules/angular-moment/angular-moment.js', 'public/js')
   .copy('node_modules/moment/moment.js', 'public/js');

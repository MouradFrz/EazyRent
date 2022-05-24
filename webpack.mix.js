const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/bootstrap.scss', 'public/css')

    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/login.scss', 'public/css')
    .sass('resources/sass/register.scss', 'public/css')

    .sass('resources/sass/user/index.scss', 'public/css/user')
    .sass('resources/sass/admin/index.scss', 'public/css/admin')
    .sass('resources/sass/owner/index.scss', 'public/css/owner')
    .sass('resources/sass/secretary/index.scss', 'public/css/secretary')
    .sass('resources/sass/vehicules/index.scss', 'public/css/vehicules')
    .sourceMaps();

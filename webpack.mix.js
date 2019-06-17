const mix = require('laravel-mix')

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

mix.sass('resources/assets/sass/app.scss', 'public/css/app.css')
   .sass('resources/assets/sass/vendors/fontawesome.scss', 'public/fonts')
   .sass('resources/assets/sass/vendors/material-icons.scss', 'public/fonts')
   .styles(['node_modules/animate.css/animate.min.css'], 'public/css/animate.min.css')
   .styles(['resources/assets/css/bootstrap.css'], 'public/css/bootstrap.css')
   .sass('resources/assets/sass/components/_all.scss', 'public/css/components.css')
   .styles(['resources/assets/css/base.css'], 'public/css/base.css')
   .styles(
        [
            'resources/assets/libs/amaranjs/css/amaran.min.css',
            'resources/assets/libs/messenger/css/messenger.min.css',
            'resources/assets/libs/messenger/css/messenger-theme-air.min.css',
            'resources/assets/libs/messenger/css/messenger-theme-flat.min.css',
            'resources/assets/libs/messenger/css/messenger-theme-future.min.css',
            'resources/assets/libs/messenger/css/messenger-theme-ice.min.css'
        ], 'public/css/libs.css')

mix.js('resources/assets/js/bootstrap.js', 'public/js/bootstrap.js')
   .js(['resources/assets/js/app.js'], 'public/js/app.js')
   .scripts(
        [
            'resources/assets/libs/amaranjs/js/jquery.amaran.min.js',
            'resources/assets/libs/messenger/js/messenger.min.js',
            'resources/assets/libs/messenger/js/messenger-theme-flat.min.js',
            'resources/assets/libs/messenger/js/messenger-theme-future.min.js',
            'node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
            'node_modules/sweetalert2/dist/sweetalert2.all.min.js',
            'node_modules/bs-custom-file-input/dist/bs-custom-file-input.min.js',
            'node_modules/bs4-breakpoint-check/js/jquery-breakpoint-check.js',
            'node_modules/jquery-touchswipe/jquery.touchSwipe.min.js',
            'node_modules/fastclick/lib/fastclick.js'
        ], 'public/js/libs.js')

mix.copy('resources/assets/images', 'public/images');

if (mix.inProduction()) {
    mix.version();
}

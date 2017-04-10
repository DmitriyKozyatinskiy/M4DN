const { mix } = require('laravel-mix');

mix.webpackConfig({});

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

mix.js(['resources/assets/js/app.js'], 'public/js/app.js')
  .js(['resources/assets/js/subscription.js'], 'public/js/subscription.js')
  .js(['resources/assets/js/billing.js', 'resources/assets/js/billing_paypal.js'], 'public/js/billing.js')
  .js(['resources/assets/js/devices.js'], 'public/js/devices.js')
  .js(['resources/assets/js/History/History.js'], 'public/js/history.js')
  .sass('resources/assets/sass/app.scss', 'public/css');

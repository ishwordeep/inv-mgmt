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
  
mix.js("resources/js/app.js", "public/js")
.styles(
    [
        "public/packages/backpack/base/css/bundle.css", 
        "public/packages/jquery-ui-dist/jquery-ui.min.css"
    ],
    "public/css/vendor.css"
)
.scripts(
    [
        "public/js/jquery.min.js",
        "public/packages/backpack/base/js/bundle.js",
        "public/packages/jquery-ui-dist/jquery-ui.min.js",
        "public/customJS/common.js",
        "public/customJS/stock.js",
        "public/customJS/po.js",
        "public/customJS/numericals.js",
        "public/customJS/stock.js",
    ],
    "public/js/vendor.js"
)
.version();
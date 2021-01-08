const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js") // generate app.js
    .vue({ version: 2 }) // <<<<<<------ important
    .sass("resources/scss/app.scss", "public/css", [
        // generate app.css
        //
    ]);

// note: to compile correctly vue files, verify that these npm packages are installed:
// vue-template-compiler (as a dev dependency)
// vue-loader (as a dev dependency)

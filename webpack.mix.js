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

// copy Vuetify Style from node_modules to public folder
mix.copy(
    "node_modules/vuetify/dist/vuetify.min.css",
    "public/css/vuetify.min.css"
);

mix.js("resources/js/app.js", "public/js")
    .vue({ version: 2 }) // <<<<<<------ important
    .postCss("resources/css/app.css", "public/css/", [
        // generate app.css
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer")
    ])
    .sass("resources/scss/app.scss", "public/css/my.css", [
        // generate my.css
        //
    ]);

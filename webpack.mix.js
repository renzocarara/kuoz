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

mix.copy(
    // copy Vuetify Style from node_modules to public folder
    "node_modules/vuetify/dist/vuetify.min.css",
    "public/css/vuetify.min.css"
);

mix.js("resources/js/app.js", "public/js")
    .vue({ version: 2 }) // <<<<<<------ important
    .postCss("resources/css/app.css", "public/css/", [
        // generate app.css, contains Tailwind style used by the authentication views
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer")
    ])
    .postCss("resources/css/welcome.css", "public/css/welcome.css", [
        // generate welcome.css, specific style just for welcome view
    ])
    .sass("resources/scss/app.scss", "public/css/my.css", [
        // generate my.css, scss style for the Vue App pages
        //
    ]);

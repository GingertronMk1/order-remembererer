const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");
const polyfill = require("laravel-mix-polyfill");
const autoprefixer = require("autoprefixer");
const eslint = require('laravel-mix-eslint')


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

const versions = ["> 0.2%", "last 20 versions", "not dead"];

mix.js("resources/js/app.js", "public/js/app.js")
    .vue()
    .eslint()
    .sass("resources/sass/app.scss", "public/css/app.css")
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: versions,
    })
    .options({
        postCss: [
            tailwindcss("./tailwind.config.js"),
            autoprefixer({
                overrideBrowserslist: versions,
                cascade: false,
            }),
        ],
    })
    .webpackConfig(require("./webpack.config"))
    .version();

if (!mix.inProduction()) {
    mix.sourceMaps();
}
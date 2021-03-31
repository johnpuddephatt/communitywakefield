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

mix.js('resources/js/admin.js', 'public/js').vue({ version: 2 })
    .postCss('resources/css/admin.css', 'public/css', [
        require("@tailwindcss/jit"),
        // require('tailwindcss'),
        // require('postcss-import'),
        require('autoprefixer'),
    ])
    .js('resources/js/app.js', 'public/js').vue({ version: 2 })
    .sass('resources/css/app.scss', 'public/css')
    .browserSync('public.communitywakefield.localhost')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}

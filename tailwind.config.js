const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
              'spruce': '#335057',
              'navy': '#3267AE',
              'fuschia': '#f9c2f4',
              'brand-green-bright': '#86e4af',
              'brand-red': '#c34f6f',
              'brand-orange': '#e2753f',
              'brand-blue-light': '#d1eafb'
            },
            fontFamily: {
                sans: ['Yantramanav', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: theme => ({
             'badges-splash': "url('/images/badges-splash.svg')",
             'badges': "url('/images/badges.svg')"
            }),
            backgroundSize: {
              'cover-width': '100% auto',
             }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};

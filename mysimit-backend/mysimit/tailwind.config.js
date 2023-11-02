const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        screens: {
            'xs': '475px',
            ...defaultTheme.screens,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                // sans: ["Blinker", ...defaultTheme.fontFamily.sans]
            },
            transitionProperty: {
                'width': 'width',
                'height': 'height',
            },
            colors: {
                primary: {
                    "100": "#e5e7eb",
                    "200": "#e5e7eb",
                    "300": "#e5e7eb",
                    "400": "#e5e7eb",
                    "500": "#000000",
                    "600": "#e5e7eb",
                    "700": "#e5e7eb",
                    "800": "#e5e7eb",
                    "900": "#e5e7eb"
                },
                secondary: {
                    "100": "#91c48f",
                    "200": "#7fba7d",
                    "300": "#6db06a",
                    "400": "#5aa658",
                    "500": "#489c45",
                    "600": "#418c3e",
                    "700": "#3a7d37",
                    "800": "#326d30",
                    "900": "#2b5e29"
                }
            },
            borderRadius: {
                'primary': '20px',
            },

        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};

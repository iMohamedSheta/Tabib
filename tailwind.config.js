import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import colors from 'tailwindcss/colors';
import scrollbar from 'tailwind-scrollbar'; // import the plugin
import withMT from "@material-tailwind/html/utils/withMT";


/** @type {import('tailwindcss').Config} */
export default withMT({
    darkMode: 'selector',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            screens: {
                'hs' : '0px',
                'fs' : '200px',
                'xs' : '480px',
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "c-gray-900": '#121317',
                'c-gray-800' : '#191c23',
                "c-gray-700": '#242731',
                "c-gray-600": '#2c3038',
                "purple": colors.purple,
                // "purple": {
                //     '200': '#f3faf8',
                //     '100': '#f3faf8',
                //     '500': '#f3faf8',
                //     '300': '#f3faf8',
                //     '400': '#57aa9f',
                //     '500': '#3e8e85',
                //     '600': '#2f726c',
                //     '700': '#295c58',
                //     '800': '#254a48',
                //     '900': '#223f3d',
                //     '950': '#0f2424',
                // },
                "gray": colors.gray,
            }

        },

    },

    plugins: [forms, typography, scrollbar],
});

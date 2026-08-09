import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Tambahkan ukuran font custom khusus untuk kebutuhan badge UI kita kemarin
            fontSize: {
                'xxs': '0.65rem',
            },
            boxShadow: {
                'xxs': '0 1px 2px 0 rgba(0, 0, 0, 0.02)',
            }
        },
    },

    plugins: [forms],
};

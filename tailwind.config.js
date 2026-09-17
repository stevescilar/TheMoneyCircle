import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
    extend: {
        colors: {
            'brand-green': '#00381B',
            'brand-green-light': '#033D24',
            'brand-gold': '#C59121',
        },
        fontFamily: {
            sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        },
    },
},

    plugins: [forms],
};

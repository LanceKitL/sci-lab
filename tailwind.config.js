import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php', // <--- THIS LINE IS CRITICAL
        './resources/js/**/*.js',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            // Your custom colors here
            colors: {
                'scilab-blue': '#3562AD',
                'scilab-light-blue': '#31496B',
                'scilab-dark-blue': '#2D4470',
                'scilab-active-bg': '#C2DCFF',
                'scilab-active-text': '#085a80',
                'scilab-hover-bg': '#f0f9ff',
                'scilab-hover-text': '#0284c7',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', 'serif'],
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
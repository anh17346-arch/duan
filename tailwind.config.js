import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            colors: {
                brand: {
                    DEFAULT: '#6366F1',
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    600: '#4f46e5',
                    700: '#4338ca'
                }
            },
            boxShadow: {
                soft: '0 10px 30px rgba(0,0,0,.07)'
            }
        },
    },

    plugins: [forms],
};

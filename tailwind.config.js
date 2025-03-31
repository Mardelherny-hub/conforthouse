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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gold: '#e8d4b8',
                dark: '#333333',
            },
            // Estilos personalizados para paginación
            pagination: {
                link: 'px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50',
                active: 'z-10 bg-amber-500 text-white border-amber-500',
                disabled: 'text-gray-300 cursor-not-allowed'
            },
        },
    },

    plugins: [forms],
};

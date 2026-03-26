import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],

    theme: {
        extend: {
            colors: {
                "navy-petroleo": "#2C3E50", // Profissionalismo
                "navy-coral": "#FF6F61", // Empoderamento
                "navy-hot-pink": "#FF69B4", // Meta alcançada
                "navy-gold": "#FFD700", // Sucesso e conquista
                "navy-claro": "#FFF5F7", // Suavidade
            },
            fontFamily: {
                sans: ["Rotis Sans Serif", "sans-serif"], // Tipografia principal
                serif: ["The Seasons", "serif"], // Tipografia de destaque
            },
        },
    },

    plugins: [forms],
};

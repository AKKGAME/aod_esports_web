// tailwind.config.js

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php', // (Filament အတွက်)
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'), // <-- (၁) ဒီ line ကို ထပ်ထည့်ပါ
    ],

    daisyui: {
        themes: ["light", "dark", "cupcake"], // (Theme တွေ ကြိုက်သလောက် ထည့်နိုင်ပါတယ်)
        darkTheme: "dark", // (Default dark mode)
        base: true, // (Base style တွေ ဖွင့်မယ်)
        styled: true, // (Component style တွေ ဖွင့်မယ်)
        utils: true, // (Utility class တွေ ဖွင့်မယ်)
    },
};
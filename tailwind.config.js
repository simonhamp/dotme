import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/views/**/*.html',
        './content/**/*.md',
    ],
    theme: {
        extend: {
            colors: {
                "surface": "#fff8f1",
                "background": "#fff8f1",
                "on-surface": "#211b0b",
                "on-background": "#211b0b",
                "primary": "#1b59b4",
                "primary-container": "#3d72cf",
                "on-primary": "#ffffff",
                "on-primary-container": "#fefcff",
                "secondary": "#b32829",
                "secondary-container": "#fc5d57",
                "on-secondary": "#ffffff",
                "on-secondary-container": "#600008",
                "secondary-fixed": "#ffdad6",
                "on-secondary-fixed": "#410003",
                "tertiary": "#5b5a72",
                "tertiary-container": "#74728c",
                "on-tertiary": "#ffffff",
                "surface-container-lowest": "#ffffff",
                "surface-container-low": "#fff2d9",
                "surface-container": "#faedd2",
                "surface-container-high": "#f4e7cc",
                "surface-container-highest": "#eee1c7",
                "surface-dim": "#e5d9bf",
                "surface-variant": "#eee1c7",
                "on-surface-variant": "#424752",
                "outline": "#737783",
                "outline-variant": "#c3c6d4",
                "error": "#ba1a1a",
            },
            fontFamily: {
                headline: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
                label: ['"Space Grotesk"', ...defaultTheme.fontFamily.mono],
            },
            borderRadius: {
                DEFAULT: '0px',
                lg: '0px',
                xl: '0px',
                full: '9999px',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
};

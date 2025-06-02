import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                playfair: ['"Playfair Display"', 'serif'],
                figtree: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'sheila-primary': {
                    DEFAULT: '#5e35b1',
                    dark: '#7e57c2',
                    darker: '#512da8',
                    light: '#b39ddb',
                },
                'sheila-secondary': {
                    DEFAULT: '#ff7043',
                    dark: '#f4511e',
                },
                'sheila-accent': {
                    DEFAULT: '#26a69a',
                    dark: '#00897b',
                },
            },
            spacing: {
                '128': '32rem',
            },
            boxShadow: {
                'sheila': '0 4px 14px 0 rgba(94, 53, 177, 0.2)',
                'sheila-dark': '0 4px 14px 0 rgba(126, 87, 194, 0.3)',
            },
            // Custom Typography (prose) styles
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        '--tw-prose-body': theme('colors.gray.800'),
                        '--tw-prose-headings': theme('colors.sheila-primary.DEFAULT'),
                        '--tw-prose-links': theme('colors.sheila-primary.dark'),
                        '--tw-prose-bold': theme('colors.sheila-primary.darker'),
                        '--tw-prose-counters': theme('colors.sheila-accent.DEFAULT'),
                        '--tw-prose-bullets': theme('colors.sheila-accent.DEFAULT'),
                        'h1, h2, h3': {
                            fontFamily: theme('fontFamily.playfair').join(', '),
                            fontWeight: '700',
                        },
                        'a:hover': {
                            textDecoration: 'none',
                            color: theme('colors.sheila-primary.darker'),
                        },
                    },
                },
                dark: {
                    css: {
                        '--tw-prose-body': theme('colors.gray.300'),
                        '--tw-prose-headings': theme('colors.sheila-primary.light'),
                        '--tw-prose-links': theme('colors.sheila-primary.dark'),
                        '--tw-prose-bold': theme('colors.sheila-primary.light'),
                    },
                },
            }),
        },
    },
    plugins: [
        forms,
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};

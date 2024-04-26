/** @type {import('tailwindcss').Config} */
export default {
    important: true,
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js'
    ],
    theme: {
        colors: {
            'oss-black': '#050508',
            'oss-footer-dark': '#1F1F1F',
            'oss-gray-light': '#F9F8F7',
            'oss-gray': '#EAE8E5',
            'oss-gray-medium': '#CAC8C4',
            'oss-gray-dark': '#A5A4A3',
            'oss-gray-extra-dark': '#3A3C3E',
            'oss-red': '#FF354F',
            'oss-blue': '#33CCFF',
            'oss-royal-blue': '#172A3D',
            'oss-royal-blue-light': '#515F6E',
            'oss-purple': '#735AFF',
            'oss-green': '#50E69B',
            'oss-green-pale': '#82D8AF',
            'oss-purple-extra-dark': '#15151E',
            'oss-yellow': '#E7C23D',

            transparent: 'transparent',
            current: 'currentColor',
            black: '#172a3d',
            white: '#ffffff',

            paper: 'rgba(249, 248, 248, 0.5)',
            opaque: 'rgba(255, 255, 255, 0.5)',

            'gold-lightest': '#eee8d6',
            gold: '#a89f81',
            'gold-darkest': '#51492c',

            'gray-50': '#f8f8f8',
            'gray-lightest': '#f3efea',
            'gray-lighter': '#cbd2ce',
            'gray-light': '#b8bfbb',
            gray: '#767575',
            'gray-dark': '#686666',
            'gray-darker': '#4c534f',
            'gray-darkest': '#171e1a',

            'blue-50': '#f7fbfc',
            'blue-lightest': '#cae1e8',
            'blue-lighter': '#22a4c9',
            'blue-light': '#22a4c9',
            blue: '#197593',
            'blue-dark': '#004966',
            'blue-darker': '#172a3d',
            'blue-darkest': '#0f1c29',

            orange: '#ffa200',
            'orange-dark': '#e89158',
            'orange-darker': '#944600',

            red: '#ef0732',
            'red-dark': '#c81839',

            'pink-lightest': '#f2d8db',
            pink: '#dd9099',
            'pink-dark': '#8d3b44',

            'green-lightest': '#daefe8',
            'green-lighter': '#94dac4',
            'green-light': '#57c9a5',
            green: '#21b989',
            'green-dark': '#0a8867',

            purple: '#885de3',
        },

        screens: {
            sm: '720px',
            md: '960px',
            lg: '1230px',
            xl: '1680px',
            print: {raw: 'print'},
        },

        fontFamily: {
            sans: [
                'Gotham Narrow SSm A',
                'Gotham Narrow SSm B',
                '-apple-system',
                'BlinkMacSystemFont',
                'Segoe UI',
                'Roboto',
                'Oxygen',
                'Ubuntu',
                'Cantarell',
                'Fira Sans',
                'Droid Sans',
                'Helvetica Neue',
                'sans-serif',
            ],
            serif: [
                'Chronicle Display A',
                'Chronicle Display B',
                'Constantia',
                'Lucida Bright',
                'Lucidabright',
                'Lucida Serif',
                'Lucida',
                'DejaVu Serif',
                'Bitstream Vera Serif',
                'Liberation Serif',
                'Georgia',
                'serif',
            ],
            mono: ['Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace'],
            pt: [
                'PTRootUIWebVF',
                '-apple-system',
                'BlinkMacSystemFont',
                'Segoe UI',
                'Roboto',
                'Oxygen',
                'Ubuntu',
                'Cantarell',
                'Fira Sans',
                'Droid Sans',
                'Helvetica Neue',
                'sans-serif',
            ],
            druk: [
                'Druk',
                'Gotham Narrow SSm A',
                'Gotham Narrow SSm B',
                '-apple-system',
                'BlinkMacSystemFont',
                'Segoe UI',
                'Roboto',
                'Oxygen',
                'Ubuntu',
                'Cantarell',
                'Fira Sans',
                'Droid Sans',
                'Helvetica Neue',
                'sans-serif',
            ]
        },

        lineHeight: {
            none: 1,
            tight: 1.1,
            normal: 1.6,
            relaxed: 1.8,
            loose: 2,
        },

        letterSpacing: {
            tight: '-0.05em',
            normal: '0',
            wide: '0.05em',
        },

        extend: {
            backgroundImage: {
                'link-card': 'linear-gradient(180deg, rgba(141, 161, 166, 0.1) 0%, rgba(255, 255, 255, 0.03) 100%);',
                'link-card-light': 'linear-gradient(180deg, rgba(209, 201, 188, 0.1) 0%, rgba(255, 255, 255, 0.015) 100%);',
                'link-card-light-hover': 'linear-gradient(180deg, rgba(255, 255, 255, 0.6) 0%, rgba(255, 255, 255, 0.09) 100%);',
            },

            boxShadow: {
                DEFAULT: '0 2px 4px 0 rgba(76, 55, 55, 0.12)',
                light: '0 2px 4px 0 rgba(76, 55, 55, 0.04)',
                md: '0 4px 8px 0 rgba(162, 184, 193, 0.12), 0 2px 4px 0 rgba(76, 55, 55, 0.12)',
                lg: '0 15px 30px 0 rgba(162, 184, 193, 0.14), 0 5px 15px 0 rgba(76, 55, 55, 0.12)',
                inner: 'inset 0 2px 4px 0 rgba(76, 55, 55, 0.12)',
                'inner-light': 'inset 0 2px 4px 0 rgba(76, 55, 55, 0.04)',
                none: 'none',
                'oss-card': '0px 0px 110px 50px #00000033',
            },

            fontSize: {
                xxs: '.55rem', // small!
                '6xl': '5rem', // large!
            },

            width: {
                '2px': '2px',
            },

            height: {
                '2px': '2px',
                '18': '4.5rem',
                '1/2': '50%',
            },

            spacing: {
                '7.5': '1.875rem',
            },

            keyframes: {
                wiggle: {
                    '0%, 100%': {transform: 'rotate(-3deg)'},
                    '50%': {transform: 'rotate(3deg)'},
                },
                popin: {
                    '0%': {transform: 'scale(0) translate(-50%, -4rem)'},
                    '100%': {transform: 'scale(1) translate(-50%, -4rem)'},
                }
            },
            animation: {
                wiggle: 'wiggle 0.15s ease-in-out infinite',
                popin: 'popin 0.2s 1 ease-in-out forwards',
            },

            maxWidth: {
                sm: '25rem', // xl/2 - half gap
                md: '40rem',
                lg: '50rem',
                xl: '60rem',
                '2xl': '70rem',
                '3xl': '80rem',
                '4xl': '90rem',
                '5xl': '100rem',
                '1/2': '50vw',
                columns: '80rem', // xl + (2 * large gap)
                logoclient: '8rem',
            },

            maxHeight: {
                none: 'none',
                '16': '4rem',
                '24': '6rem',
            },

            minHeight: {
                '10': '2.5rem',
                '12': '3rem',
            },

            zIndex: {
                auto: 'auto',
                back: -1,
                postcard: 700,
            },

            inset: {
                full: '100%',
                '1/2': '50%'
            },

            gridTemplateColumns: {
                'auto-1fr': 'auto 1fr',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms')({
            strategy: "class",
        }),
    ],
}


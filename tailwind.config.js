module.exports = {
    important: true,
    
    variants: ['responsive', 'group-hover', 'group-focus', 'focus-within', 'first', 'last', 'odd', 'even', 'hover', 'focus', 'active', 'visited', 'disabled'],

    plugins: [
        require('@tailwindcss/custom-forms')
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            black: '#172a3d',
            white: '#ffffff',

            paper: 'rgba(249, 248, 248, 0.5)',
            opaque: 'rgba(255, 255, 255, 0.5)',

            'gold-lightest': '#eee8d6',
            gold: '#a89f81',
            'gold-darkest': '#51492c',

            'grey-lightest': '#f3efea',
            'grey-lighter': '#cbd2ce',
            'grey-light': '#b8bfbb',
            grey: '#767575',
            'grey-dark': '#686666',
            'grey-darker': '#4c534f',
            'grey-darkest': '#171e1a',

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
            'pink-dark': '#B95661',

            'green-lightest': '#daefe8',
            'green-lighter': '#94dac4',
            'green-light': '#57c9a5',
            green: '#21b989',
            'green-dark': '#0a8867',
        },

        screens: {
            sm: '720px',
            md: '960px',
            lg: '1230px',
            xl: '1615px',
            print: { raw: 'print' },
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
        },

        lineHeight: {
            none: 1,
            tight: 1.1,
            normal: 1.6,
            loose: 2,
        },

        letterSpacing: {
            tight: '-0.05em',
            normal: '0',
            wide: '0.05em',
        },

        boxShadow: {
            default: '0 2px 4px 0 rgba(76, 55, 55, 0.12)',
            light: '0 2px 4px 0 rgba(76, 55, 55, 0.04)',
            md: '0 4px 8px 0 rgba(162, 184, 193, 0.12), 0 2px 4px 0 rgba(76, 55, 55, 0.12)',
            lg: '0 15px 30px 0 rgba(162, 184, 193, 0.14), 0 5px 15px 0 rgba(76, 55, 55, 0.12)',
            inner: 'inset 0 2px 4px 0 rgba(76, 55, 55, 0.12)',
            'inner-light': 'inset 0 2px 4px 0 rgba(76, 55, 55, 0.04)',
            none: 'none',
        },

        extend: {
            fontSize: {
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

            maxWidth: {
                sm: '25rem', // xl/2 - half gap
                md: '40rem',
                lg: '50rem',
                xl: '52rem',
                '2xl': '70rem',
                '3xl': '80rem',
                '4xl': '90rem',
                '5xl': '100rem',
                '1/2': '50vw',
                columns: '60rem', // xl + (2 * large gap)
                logoclient: '8rem',
            },

            maxHeight: {
                none: 'none',
                '16': '4rem',
                '24': '6rem',
            },

            zIndex: {
                auto: 'auto',
                back: -1,
                postcard: 700,
            },
        },
    },
};

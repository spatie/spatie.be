module.exports = {
    important: true,

    purge: ['./resources/**/*.blade.php', './resources/**/*.js'],

    variants: [
        'responsive',
        'group-hover',
        'group-focus',
        'focus-within',
        'first',
        'last',
        'odd',
        'even',
        'hover',
        'focus',
        'active',
        'visited',
        'disabled',
    ],

    plugins: [require('@tailwindcss/custom-forms')],

    theme: {
        colors: {
            transparent: 'transparent',
            black: '#172a3d',
            white: '#ffffff',

            paper: 'rgba(249, 248, 248, 0.5)',
            opaque: 'rgba(255, 255, 255, 0.5)',

            'gold-lightest': '#f8f8f8',
            gold: '#767575',
            'gold-darkest': '#171e1a',

            'gray-50': '#f8f8f8',
            'gray-lightest': '#f3efea',
            'gray-lighter': '#cbd2ce',
            'gray-light': '#b8bfbb',
            gray: '#767575',
            'gray-dark': '#686666',
            'gray-darker': '#4c534f',
            'gray-darkest': '#171e1a',

            'blue-50': '#f8f8f8',
            'blue-lightest': '#f3efea',
            'blue-lighter': '#cbd2ce',
            'blue-light': '#b8bfbb',
            blue: '#767575',
            'blue-dark': '#686666',
            'blue-darker': '#4c534f',
            'blue-darkest': '#171e1a',

            orange: '#767575',
            'orange-dark': '#686666',
            'orange-darker': '#171e1a',

            red: '#767575',
            'red-dark': '#686666',

            'pink-lightest': '#f3efea',
            pink: '#767575',
            'pink-dark': '#686666',

            'green-lightest': '#f3efea',
            'green-lighter': '#cbd2ce',
            'green-light': '#b8bfbb',
            green: '#767575',
            'green-dark': '#686666',

            purple: '#767575',
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
                xxs: '.55rem', // small!
                '6xl': '5rem', // large!
                '7xl': '0rem', // xlarge! 
            },


            opacity: {
                '5': '0.05',
            },

            width: {
                '2px': '2px',
            },

            scale: {
                '15': '.15',
                '25': '.25',
                '135': '1.35',
                '120': '1.2',
                '145': '1.45'

            },

            height: {
                '2px': '2px',
                '18': '4.5rem',
                '1/2': '50%',
            },

            keyframes: {
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-3deg)' },
                    '50%': { transform: 'rotate(3deg)' },
                },
                popin: {
                    '0%': { transform: 'scale(0) translate(-50%, -4rem)' },
                    '100%': { transform: 'scale(1) translate(-50%, -4rem)' },
                },

                slidein: {
                    '0%': { transform: 'scale(0.15, 1.45)  translateX(0)', opacity: 0.05 },
                    '100%': { transform: 'scale(0.8, 0.8) translateX(-33rem)', opacity: 1 },
                },

                fadein1: {
                    '0%': { opacity: 0.00 },
                    '65%': { opacity: 0.00 },
                    '66%': { opacity: 0.75 },
                    '100%': { opacity: 0.75 },
                },
                fadein2: {
                    '0%': { opacity: 0.00 },
                    '50%': { opacity: 0.00 },
                    '51%': { opacity: 0.5 },
                    '100%': { opacity: 0.5 },
                },
                fadein3: {
                    '0%': { opacity: 0.00 },
                    '40%': { opacity: 0.00 },
                    '41%': { opacity: 0.25 },
                    '100%': { opacity: 0.25 },
                },
                fadein4: {
                    '0%': { opacity: 0.00 },
                    '20%': { opacity: 0.00 },
                    '21%': { opacity: 0.05 },
                    '100%': { opacity: 0.05 },
                }
                
            },
            animation: {
                wiggle: 'wiggle 0.15s ease-in-out infinite',
                popin: 'popin 0.2s 1 ease-in-out forwards',
                slidein: 'slidein 1s 1 ease-in-out forwards',
                fadein1: 'fadein1 1s 1 ease-in-out forwards',
                fadein2: 'fadein2 1s 1 ease-in-out forwards',
                fadein3: 'fadein3 1s 1 ease-in-out forwards',
                fadein4: 'fadein4 1s 1 ease-in-out forwards',
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
                '1/2': '50%',
                '8': '2rem',
            },

            translate: {
                '28': '7rem',
                '18': '4.5rem',
            },

            gridTemplateColumns: {
                'auto-1fr': 'auto 1fr',
            },
        },

        customForms: theme => ({
            default: {
                input: {
                    color: theme('colors.black'),
                    borderWidth: '2px',
                    borderRadius: theme('borderRadius.sm'),
                    borderColor: theme('colors.gray-light'),
                    height: theme('spacing.10'),
                    paddingLeft: theme('spacing.2'),
                    paddingRight: theme('spacing.2'),
                    '&:focus': {
                        borderColor: theme('colors.blue-light'),
                        outline: 'none',
                        boxShadow: 'none',
                    },
                },
                textarea: {
                    color: theme('colors.black'),
                    borderWidth: '2px',
                    borderRadius: theme('borderRadius.sm'),
                    borderColor: theme('colors.gray-light'),
                    height: theme('spacing.32'),
                    paddingLeft: theme('spacing.2'),
                    paddingRight: theme('spacing.2'),
                    '&:focus': {
                        borderColor: theme('colors.blue'),
                        outline: 'none',
                        boxShadow: 'none',
                    },
                },
                select: {
                    color: theme('colors.black'),
                    borderWidth: '2px',
                    borderRadius: theme('borderRadius.sm'),
                    borderColor: theme('colors.gray-light'),
                    height: theme('spacing.10'),
                    paddingLeft: theme('spacing.2'),
                    paddingRight: theme('spacing.2'),
                    '&:focus': {
                        borderColor: theme('colors.blue'),
                        outline: 'none',
                        boxShadow: 'none',
                    },
                },
                checkbox: {
                    borderWidth: '2px',
                    borderRadius: theme('borderRadius.sm'),
                    borderColor: theme('colors.gray-light'),
                    color: theme('colors.blue'),
                    height: theme('spacing.8'),
                    width: theme('spacing.8'),
                    '&:focus': {
                        borderColor: theme('colors.blue'),
                        outline: 'none',
                        boxShadow: 'none',
                    },
                },
                radio: {
                    borderWidth: '2px',
                    borderRadius: theme('borderRadius.full'),
                    borderColor: theme('colors.gray-light'),
                    color: theme('colors.blue'),
                    height: theme('spacing.8'),
                    width: theme('spacing.8'),
                    '&:focus': {
                        borderColor: theme('colors.blue'),
                        outline: 'none',
                        boxShadow: 'none',
                    },
                },
            },
        }),
    },
};

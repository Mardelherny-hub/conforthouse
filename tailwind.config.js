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
            // Fuentes personalizadas ConfortHouse
            fontFamily: {
                'luxury': ['Cormorant Garamond', 'serif'],
                'body': ['Montserrat', 'sans-serif'],
                'sans': ['Montserrat', ...defaultTheme.fontFamily.sans],
                'serif': ['Cormorant Garamond', ...defaultTheme.fontFamily.serif],
            },
            
            // Colores basados en el logo ConfortHouse Living
            colors: {
                // Colores principales del logo
                'primary-gold': '#B8731A',
                'secondary-champagne': '#D4C4A8',
                'accent-black': '#000000',
                
                // Paleta completa de dorados
                'gold': {
                    50: '#fefdf8',
                    100: '#fef7e7',
                    200: '#fdeccc',
                    300: '#fcdda6',
                    400: '#f9c474',
                    500: '#f6a93f',
                    600: '#e89429',
                    700: '#B8731A', // Color principal del logo
                    800: '#a0621a',
                    900: '#834f19',
                },
                
                // Paleta completa de champagne
                'champagne': {
                    50: '#faf9f7',
                    100: '#f5f2ed',
                    200: '#ede6db',
                    300: '#D4C4A8', // Color principal del logo
                    400: '#c4b294',
                    500: '#b5a086',
                    600: '#a08d79',
                    700: '#8a7867',
                    800: '#716359',
                    900: '#5d524b',
                },
                
                // Neutros elegantes
                'neutral': {
                    50: '#FAFAFA',
                    100: '#F5F5F5',
                    200: '#E5E5E5',
                    300: '#D4D4D4',
                    400: '#A3A3A3',
                    500: '#737373',
                    600: '#525252',
                    700: '#404040',
                    800: '#262626',
                    900: '#171717',
                },
            },

            // Gradientes personalizados
            backgroundImage: {
                'luxury-gradient': 'linear-gradient(135deg, #e89429 0%, #B8731A 50%, #a0621a 100%)',
                'champagne-gradient': 'linear-gradient(135deg, #ede6db 0%, #D4C4A8 50%, #c4b294 100%)',
                'dark-gradient': 'linear-gradient(135deg, #262626 0%, #000000 100%)',
                'hero-gradient': 'linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(184, 115, 26, 0.1) 100%)',
            },

            // Sombras luxury
            boxShadow: {
                'luxury': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'gold': '0 10px 25px rgba(184, 115, 26, 0.15)',
                'champagne': '0 10px 25px rgba(212, 196, 168, 0.15)',
                'nav': '0 4px 30px rgba(0, 0, 0, 0.1)',
                'nav-scrolled': '0 10px 25px rgba(0, 0, 0, 0.3)',
            },

            // Espaciado adicional
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '100': '25rem',
                '112': '28rem',
                '128': '32rem',
            },

            // Alturas personalizadas
            height: {
                'hero': '90vh',
                'hero-sm': '70vh',
            },

            // Anchos personalizados
            maxWidth: {
                '8xl': '88rem',
                '9xl': '96rem',
            },

            // Animaciones luxury
            animation: {
                'fadeInUp': 'fadeInUp 0.8s ease-out',
                'slideInFromLeft': 'slideInFromLeft 0.8s ease-out',
                'kenBurns': 'kenBurns 20s ease-out infinite',
                'float': 'float 3s ease-in-out infinite',
                'glow': 'glow 2s ease-in-out infinite alternate',
            },

            // Keyframes para animaciones
            keyframes: {
                fadeInUp: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(30px)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)',
                    },
                },
                slideInFromLeft: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateX(-50px)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateX(0)',
                    },
                },
                kenBurns: {
                    '0%': {
                        transform: 'scale(1.2)',
                    },
                    '100%': {
                        transform: 'scale(1)',
                    },
                },
                float: {
                    '0%, 100%': {
                        transform: 'translateY(0px)',
                    },
                    '50%': {
                        transform: 'translateY(-10px)',
                    },
                },
                glow: {
                    '0%': {
                        boxShadow: '0 0 20px rgba(184, 115, 26, 0.3)',
                    },
                    '100%': {
                        boxShadow: '0 0 30px rgba(184, 115, 26, 0.6)',
                    },
                },
            },

            // Transiciones personalizadas
            transitionProperty: {
                'height': 'height',
                'spacing': 'margin, padding',
            },

            // Duración de transiciones
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
                '800': '800ms',
                '1200': '1200ms',
            },

            // Timing functions personalizadas
            transitionTimingFunction: {
                'luxury': 'cubic-bezier(0.4, 0, 0.2, 1)',
                'smooth': 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
                'bounce-soft': 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
            },

            // Blur personalizado
            backdropBlur: {
                'xs': '2px',
                'luxury': '12px',
                'heavy': '16px',
            },

            // Letter spacing adicional
            letterSpacing: {
                'wider': '0.05em',
                'widest': '0.1em',
                'luxury': '0.025em',
            },

            // Z-index personalizado
            zIndex: {
                '60': '60',
                '70': '70',
                '80': '80',
                '90': '90',
                '100': '100',
            },
        },
    },
    plugins: [
        forms,
        // Plugin personalizado para componentes luxury
        function({ addComponents, theme }) {
            addComponents({
                // Componentes de navegación
                '.luxury-nav': {
                    background: 'rgba(0, 0, 0, 0.95)',
                    backdropFilter: 'blur(16px)',
                    borderBottom: '1px solid rgba(184, 115, 26, 0.3)',
                    transition: 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                    boxShadow: '0 4px 20px rgba(0, 0, 0, 0.15)',
                },
                '.luxury-nav-scrolled': {
                    background: 'rgba(0, 0, 0, 0.98)',
                    boxShadow: '0 10px 30px rgba(0, 0, 0, 0.4)',
                    borderBottom: '1px solid rgba(184, 115, 26, 0.4)',
                },
                '.nav-link-luxury': {
                    position: 'relative',
                    color: 'white',
                    fontFamily: theme('fontFamily.body'),
                    fontWeight: '400',
                    letterSpacing: '0.5px',
                    textTransform: 'uppercase',
                    fontSize: '0.875rem',
                    transition: 'all 0.3s ease',
                    padding: '0.75rem 1.25rem',
                    textDecoration: 'none',
                    '&::after': {
                        content: '""',
                        position: 'absolute',
                        width: '0',
                        height: '2px',
                        bottom: '0',
                        left: '50%',
                        background: 'linear-gradient(90deg, #e89429, #B8731A, #e89429)',
                        transition: 'all 0.3s ease',
                        transform: 'translateX(-50%)',
                    },
                    '&:hover, &.active': {
                        color: theme('colors.gold.400'),
                        textDecoration: 'none',
                        '&::after': {
                            width: '80%',
                        },
                    },
                },
                '.luxury-logo': {
                    fontFamily: theme('fontFamily.luxury'),
                    fontSize: '1.75rem',
                    fontWeight: '600',
                    color: theme('colors.gold.700'),
                    letterSpacing: '0.05em',
                    textDecoration: 'none',
                    transition: 'all 0.3s ease',
                    '&:hover': {
                        color: theme('colors.gold.500'),
                        textShadow: '0 0 20px rgba(184, 115, 26, 0.3)',
                    },
                },
                // Componentes de botones
                '.btn-luxury-primary': {
                    background: 'linear-gradient(135deg, #e89429 0%, #B8731A 50%, #a0621a 100%)',
                    color: 'white',
                    fontFamily: theme('fontFamily.body'),
                    fontWeight: '500',
                    fontSize: '0.875rem',
                    textTransform: 'uppercase',
                    letterSpacing: '0.05em',
                    padding: '0.875rem 2rem',
                    border: 'none',
                    borderRadius: '4px',
                    cursor: 'pointer',
                    transition: 'all 0.3s ease',
                    position: 'relative',
                    overflow: 'hidden',
                    '&:hover': {
                        transform: 'translateY(-2px)',
                        boxShadow: '0 10px 25px rgba(184, 115, 26, 0.15)',
                    },
                },
                '.btn-luxury-secondary': {
                    background: 'transparent',
                    color: theme('colors.gold.700'),
                    border: `2px solid ${theme('colors.gold.700')}`,
                    fontFamily: theme('fontFamily.body'),
                    fontWeight: '500',
                    fontSize: '0.875rem',
                    textTransform: 'uppercase',
                    letterSpacing: '0.05em',
                    padding: '0.75rem 2rem',
                    borderRadius: '4px',
                    cursor: 'pointer',
                    transition: 'all 0.3s ease',
                    '&:hover': {
                        background: theme('colors.gold.700'),
                        color: 'white',
                        transform: 'translateY(-2px)',
                        boxShadow: theme('boxShadow.md'),
                    },
                },
            })
        },
    ],
};
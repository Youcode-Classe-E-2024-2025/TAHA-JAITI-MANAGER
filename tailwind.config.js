/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{php,html,js}", "./index.php"],
  theme: {
    extend: {
      colors: {
        'dark_purple': { 
          DEFAULT: '#191528', 
          100: '#050408', 
          200: '#0a0810', 
          300: '#0f0d18', 
          400: '#141120', 
          500: '#191528', 
          600: '#3e3463', 
          700: '#63539e', 
          800: '#9589c1', 
          900: '#cac4e0' 
        },
        'tyrian_purple': { 
          DEFAULT: '#5c162e', 
          100: '#120409', 
          200: '#240912', 
          300: '#360d1c', 
          400: '#481225', 
          500: '#5c162e', 
          600: '#9a254e', 
          700: '#d03f72', 
          800: '#e07fa1', 
          900: '#efbfd0' 
        },
        'claret': { 
          DEFAULT: '#7c162e', 
          100: '#190409', 
          200: '#320913', 
          300: '#4b0d1c', 
          400: '#651225', 
          500: '#7c162e', 
          600: '#bb2145', 
          700: '#de466a', 
          800: '#e9849c', 
          900: '#f4c1cd' 
        },
        'rich_black': { 
          DEFAULT: '#110e1b', 
          100: '#030305', 
          200: '#07060b', 
          300: '#0a0810', 
          400: '#0e0b16', 
          500: '#110e1b', 
          600: '#382e59', 
          700: '#5f4e97', 
          800: '#9183bf', 
          900: '#c8c1df' 
        },
      },
      fontFamily: {
        'pop' : ['Poppins', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
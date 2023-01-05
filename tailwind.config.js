const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
purge: [
  './storage/framework/views/*.php',
  './resources/**/*.blade.php',
  './resources/**/*.js',
  './resources/**/*.vue',
],
  darkMode: false, // or 'media' or 'class'
  theme: {
    screens: {
      'xs': '270px',
      ...defaultTheme.screens,
    },
    extend: {
      colors: {
        blue:{
          500:"#024B85",
          primary:"#0478d4",
        },
        dialog:"rgba(0,0,0,0.5)",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    (function({ addBase, theme }) {
      addBase({
        'h1': { fontSize: theme('fontSize.2xl') },
        'h2': { fontSize: theme('fontSize.xl') },
        'h3': { fontSize: theme('fontSize.lg') },
      })
    })
  ]
}
// test  
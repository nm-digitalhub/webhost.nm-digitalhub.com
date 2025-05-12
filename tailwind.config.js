const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'Heebo', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: colors.blue,
        secondary: colors.gray,
        accent: colors.indigo,
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('tailwindcss-rtl'),
  ],
}

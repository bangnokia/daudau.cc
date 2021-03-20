const colors = require('tailwindcss/colors')

module.exports = {
  purge: {
    content: ['./resources/views/**/*.blade.php'],
    options: {
      safelist: ['hljs']
    }
  },
  theme: {
    extend: {
      colors: {
        cyan: colors.cyan
      }
    },
  },
  variants: {},
  plugins: [],
}

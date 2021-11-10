const colors = require('tailwindcss/colors')

module.exports = {
  mode: 'jit',
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

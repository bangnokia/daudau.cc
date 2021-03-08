module.exports = ({env}) => ({
	syntax: 'postcss-scss',
	plugins: {
		tailwindcss: {},
		autoprefixer: {},
		cssnano: env === "production" ? { preset: "default" } : false
  }
})

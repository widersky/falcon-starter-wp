require('dotenv').config();

const themeName = process.env.VITE_THEME_NAME;

module.exports = {
  content: [
    // https://tailwindcss.com/docs/content-configuration
    `./wp-content/themes/${themeName}/*.php`,
    `./wp-content/themes/${themeName}/inc/**/*.php`,
    `./wp-content/themes/${themeName}/templates/**/*.php`,
    `./wp-content/themes/${themeName}/safelist.txt`
  ],
  safelist: [
    'text-center'
  ],
  theme: {
    extend: {}
  },
  plugins: []
}

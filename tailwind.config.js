/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./templates/**/*.php",
    "./js/**/*.js",
    "./*.html"
  ],
  theme: {
    extend: {
      colors: {
        res: {
          green: "#00a651",
          gray: "#ceced0",
          text: "#555555"
        }
      },
      boxShadow: {
        soft: "0 8px 24px rgba(0,0,0,.08)"
      }
    },
  },
  plugins: [],
}

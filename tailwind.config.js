/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        cream: '#F8F4EE',
        dark: '#252525',
      },
      fontFamily: {
        futura: ['DM Sans', 'system-ui', '-apple-system', 'sans-serif'],
        elinga: ['Elinga', 'serif'],
      },
    },
  },
  plugins: [],
}
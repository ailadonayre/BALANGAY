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
        'bal-cream': '#F8F4EE',
        'bal-sand': '#E4DDCC',
        'bal-green': '#5B5843',
        'bal-dark': '#443A35',
      },
      fontFamily: {
        dmsans: ['"DM Sans"', 'system-ui', '-apple-system', 'sans-serif'],
        elinga: ['Elinga', 'serif'],
      },
    },
  },
  plugins: [],
}
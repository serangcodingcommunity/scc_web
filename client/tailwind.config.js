/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    fontFamily: {
      sans: ['Poppins', 'Helvetica', 'Arial', 'sans-serif'],
    },
    extend: {
      colors: {
        primary: '#142D55',
        bgPrimary: '#E9E9E9',
        bgPagination: '#D9D9D9',
        desc: '#6C6C6C'
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
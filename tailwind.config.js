/** @type {import('tailwindcss').Config} */
export default {  
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.[css,js]",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
  corePlugins: {
    preflight: true,
  }
}


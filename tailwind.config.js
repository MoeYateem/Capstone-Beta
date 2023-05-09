/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        primary: "#f79010",
        secondary: "#3b2f2c",
        tertiary: "#F2EDD7",

      },
    },
  },
  plugins: [],
};

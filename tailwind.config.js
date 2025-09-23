// tailwind.config.js
import daisyui from "daisyui";

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        display: ["Inter", "sans-serif"],
        sans: ["Instrument Sans", "sans-serif"],
      },
    },
  },
  plugins: [daisyui],
};

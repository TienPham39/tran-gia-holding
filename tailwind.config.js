// tailwind.config.js
import daisyui from "daisyui";
import scrollbar from "tailwind-scrollbar";

export default {
  content: [
    "./resources/**/*.{blade.php,html,js,ts,jsx,tsx,vue}",
    "./src/**/*.{js,ts,jsx,tsx,vue}",
    "./*.html",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
        banque: ['"UTM Banque"', "sans-serif"],
      },
    },
  },
  plugins: [daisyui, scrollbar],
};

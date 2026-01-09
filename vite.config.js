import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    tailwindcss(),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  build: {
    rollupOptions: {
      output: {
        manualChunks: (id) => {
          // Split node_modules into separate chunks
          if (id.includes('node_modules')) {
            // Ant Design Vue and its icons
            if (id.includes('ant-design-vue') || id.includes('@ant-design')) {
              return 'ant-design';
            }
            // Swiper library
            if (id.includes('swiper')) {
              return 'swiper';
            }
            // Chart.js and vue-chartjs
            if (id.includes('chart.js') || id.includes('vue-chartjs')) {
              return 'charts';
            }
            // Vue ecosystem (Vue, Vue Router, Pinia, Inertia)
            if (id.includes('vue') || id.includes('@inertiajs') || id.includes('pinia') || id.includes('vue-router')) {
              return 'vue-core';
            }
            // Icons
            if (id.includes('@iconify') || id.includes('lucide-vue')) {
              return 'icons';
            }
            // Other vendor libraries
            if (id.includes('tinymce') || id.includes('plyr') || id.includes('dayjs') || id.includes('vue-easy-lightbox')) {
              return 'vendor-utils';
            }
            // Everything else from node_modules
            return 'vendor';
          }
        },
      },
    },
    chunkSizeWarningLimit: 1000,
  },
  server: {
    host: "0.0.0.0",
    port: 5173,
    strictPort: true,
    watch: {
      usePolling: true,
      interval: 300,
      ignored: [
        "**/node_modules/**",
        "**/vendor/**",
        "**/storage/**",
        "**/public/**",
        "**/bootstrap/**",
      ],
    },
    hmr: {
      host: "localhost",
      port: 5173,
      protocol: "ws",
    },
  },
});

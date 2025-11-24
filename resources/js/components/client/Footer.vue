<template>
  <footer class="bg-[#2A2A2A] text-white py-20 font-banque">
    <div
      class="max-w-[1300px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-18 items-start"
    >
      <!-- LEFT: LOGO + SOCIAL -->
      <div class="flex flex-col items-center">
        <!-- LOGO + TEXT -->
        <img
          src="/images/homepage/footer_logo.png"
          alt="footer logo"
          class="w-[260px] h-auto"
        />

        <!-- SOCIAL ICONS -->
        <div class="flex items-center justify-center gap-6">
          <img
            src="/images/homepage/ytb.png"
            alt="youtube"
            class="w-8 h-8 cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/fb.png"
            alt="facebook"
            class="w-8 h-8 cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/zalo.png"
            alt="zalo"
            class="w-8 h-8 cursor-pointer hover:opacity-80 transition"
          />
        </div>
      </div>

      <!-- CENTER COLUMN -->
      <div class="flex flex-col text-left gap-3">
        <h3 class="text-lg font-bold tracking-wide">LOREM IPRUM DOLOR</h3>
        <p class="text-[#FFFFFF] leading-relaxed font-gotham">
          excepteur sint occaecat cupidatat non proident, sunt in culpa qui
          officia deserunt
        </p>

        <h3 class="text-lg font-bold tracking-wide mt-4">LOREM IPRUM DOLOR</h3>
        <p class="text-[#FFFFFF] leading-relaxed font-gotham">
          excepteur sint occaecat cupidatat non proident, sunt
        </p>
      </div>

      <!-- RIGHT COLUMN -->
      <div class="flex flex-col text-left gap-3">
        <h3 class="text-lg font-bold tracking-wide">LOREM IPRUM</h3>
        <p class="text-[#FFFFFF] leading-relaxed font-gotham">
          excepteur sintence occaecat cupidatat non proident, sunt in culpa qui
          officia deserunt
        </p>

        <p class="text-[#FFFFFF] leading-relaxed font-gotham mt-4">
          excepteur sintence occaecat cupidatat
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from "vue";
</script>

<style scoped>
/* Container mặc định nếu bạn chưa dùng Tailwind container plugin */
.container {
  max-width: 1200px;
}
</style>

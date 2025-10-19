<template>
  <footer class="bg-[#2A2A2A] text-gray-400 py-10">
    <div
      class="container mx-auto px-6 flex items-center flex-col md:flex-row justify-between gap-10"
    >
      <!-- Box 1: Logo + mạng xã hội -->
      <div
        class="flex flex-col items-center justify-center w-full md:w-1/3"
      >
        <img
          src="/images/homepage/footer_logo.png"
          alt="footer logo"
        />
        <!-- Icon mạng xã hội -->
        <div class="flex items-center gap-4">
          <img
            src="/images/homepage/ytb.png"
            alt="youtube"
            class="cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/fb.png"
            alt="facebook"
            class="cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/zalo.png"
            alt="zalo"
            class="cursor-pointer hover:opacity-80 transition"
          />
        </div>
      </div>

      <!-- Box 2: Placeholder text -->
      <div class="w-full md:w-1/3 flex flex-col gap-2">
        <div class="h-3 bg-gray-500/40 w-3/4 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-5/6 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-4/5 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-2/3 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-3/5 rounded"></div>
      </div>

      <!-- Box 3: Placeholder text -->
      <div class="w-full md:w-1/3 flex flex-col gap-2">
        <div class="h-3 bg-gray-500/40 w-5/6 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-4/5 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-2/3 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-3/5 rounded"></div>
        <div class="h-3 bg-gray-500/40 w-4/6 rounded"></div>
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

<template>
  <!-- Navbar Desktop -->
  <section
    class="relative h-[80px] items-center justify-end xl:justify-center hidden xl:flex"
  >
    <img
      class="absolute top-1/3 left-[10%]"
      src="/images/homepage/logo.png"
      alt="logo"
    />
    <ul class="flex items-center">
      <li
        v-for="(item, index) in navbarItem"
        :key="index"
        class="uppercase font-bold text-base"
        :class="item.active ? 'text-[#880000B8]' : ''"
      >
        <a class="px-3.5 py-4" :href="item.href">{{ item.name }}</a>
      </li>
    </ul>
  </section>

  <!-- Navbar Mobile -->
  <section
    class="relative h-[80px] flex items-center justify-between md:justify-end px-6 xl:hidden"
  >
    <img
      class="absolute max-md:hidden top-1/3 left-[10%]"
      src="/images/homepage/logo.png"
      alt="logo"
    />
    <img class="md:hidden" src="/images/homepage/mobile_logo.png" alt="mobile_logo">
    <button @click="isOpen = true">
      <img src="/images/homepage/menu-icon.png" alt="menu" class="w-8 h-8" />
    </button>
    <transition name="fade">
      <div
        v-if="isOpen"
        class="fixed inset-0 bg-black/40 z-40"
        @click="isOpen = false"
      ></div>
    </transition>

    <!-- Menu trượt -->
    <transition name="slide">
      <div
        v-if="isOpen"
        class="fixed top-0 right-0 h-full bg-white shadow-lg z-50 p-6 w-[80%] max-w-[400px] min-[360px]:w-full transition-transform"
      >
        <div class="flex justify-end mb-6">
          <button
            @click="isOpen = false"
            class="text-gray-500 hover:text-[#880000B8] text-2xl"
          >
            &times;
          </button>
        </div>

        <!-- Danh sách menu -->
        <ul class="flex flex-col gap-3">
          <li
            v-for="(item, index) in navbarItem"
            :key="index"
            class="border-b border-gray-100 pb-2"
          >
            <a
              :href="item.href"
              class="block text-lg font-semibold text-gray-700 hover:text-[#880000B8]"
              @click="isOpen = false"
            >
              {{ item.name }}
            </a>
          </li>
        </ul>
      </div>
    </transition>
  </section>
</template>

<script setup>
import { ref } from "vue";

const isOpen = ref(false);

const navbarItem = [
  { name: "Giới thiệu", href: "#", active: true },
  { name: "Tin tức", href: "#", active: false },
  { name: "Sản phẩm", href: "#", active: false },
  { name: "Dịch vụ", href: "#", active: false },
  { name: "Hoạt động cộng đồng", href: "#", active: false },
  { name: "Cơ hội nghề nghiệp", href: "#", active: false },
];
</script>

<style>
/* Hiệu ứng fade overlay */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Hiệu ứng slide cho menu */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.2s ease;
}
.slide-enter-from {
  transform: translateX(100%);
}
.slide-leave-to {
  transform: translateX(100%);
}
</style>

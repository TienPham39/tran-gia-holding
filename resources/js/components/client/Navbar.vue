<template>
  <!-- Navbar Desktop -->
  <section
    class="relative z-[100] h-[80px] font-mont items-center justify-end xl:justify-center hidden xl:flex bg-transparent"
  >
    <!-- Logo -->
    <img
      class="absolute top-1/3 left-[10%] z-[100]"
      src="/images/homepage/logo.png"
      alt="logo"
    />

    <!-- Menu Desktop -->
    <ul class="flex items-center z-[100] relative">
      <li
        v-for="(item, index) in navbarItem"
        :key="index"
        class="uppercase font-bold text-base transition-colors duration-200"
        :class="
          page.url === item.href
            ? 'text-[#880000B8]'
            : 'text-gray-700 hover:text-[#880000B8]'
        "
      >
        <Link :href="item.href" class="px-3.5 py-4 block">
          {{ item.name }}
        </Link>
      </li>
    </ul>
  </section>

  <!-- Navbar Mobile -->
  <section
    class="relative z-[100] h-[80px] flex items-center justify-between md:justify-end px-6 xl:hidden bg-transparent"
  >
    <!-- Logo cho Tablet -->
    <img
      class="absolute max-md:hidden top-1/3 left-[10%] z-[100]"
      src="/images/homepage/logo.png"
      alt="logo"
    />

    <!-- Logo Mobile -->
    <img
      class="md:hidden z-[100]"
      src="/images/homepage/mobile_logo.png"
      alt="mobile_logo"
    />

    <!-- Nút mở menu -->
    <button @click="isOpen = true" class="z-[100]">
      <img src="/images/homepage/menu-icon.png" alt="menu" class="w-8 h-8" />
    </button>

    <!-- Overlay (mờ nền khi menu mở) -->
    <transition name="fade">
      <div
        v-if="isOpen"
        class="fixed inset-0 bg-black/40 z-[90]"
        @click="isOpen = false"
      ></div>
    </transition>

    <!-- Menu trượt -->
    <transition name="slide">
      <div
        v-if="isOpen"
        class="fixed top-0 right-0 h-full bg-white shadow-lg z-[100] p-6 w-[80%] max-w-[400px] min-[360px]:w-full transition-transform"
      >
        <div class="flex justify-end mb-6">
          <button
            @click="isOpen = false"
            class="text-gray-500 hover:text-[#880000B8] text-2xl"
          >
            &times;
          </button>
        </div>

        <!-- Danh sách menu Mobile -->
        <ul class="flex flex-col gap-3">
          <li
            v-for="(item, index) in navbarItem"
            :key="index"
            class="border-b border-gray-100 pb-2"
          >
            <Link
              :href="item.href"
              class="block text-lg font-semibold text-gray-700 hover:text-[#880000B8]"
              @click="isOpen = false"
            >
              {{ item.name }}
            </Link>
          </li>
        </ul>
      </div>
    </transition>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const isOpen = ref(false);

const navbarItem = [
  { name: "Giới thiệu", href: "/" },
  { name: "Tin tức", href: "/news" },
  { name: "Sản phẩm", href: "/product" },
  { name: "Dịch vụ", href: "/service" },
  { name: "Hoạt động cộng đồng", href: "/community" },
  { name: "Cơ hội nghề nghiệp", href: "/career" },
];
</script>

<style scoped>
/* Hiệu ứng fade overlay */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Hiệu ứng slide menu mobile */
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

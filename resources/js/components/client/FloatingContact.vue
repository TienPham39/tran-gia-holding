<template>
  <div class="fixed bottom-6 right-6 z-[9999]">
    <!-- Toggle Button -->
    <button
      @click="toggleMenu"
      class="cursor-pointer w-14 h-14 flex items-center justify-center rounded-full bg-[#9B1C1C] shadow-lg hover:bg-[#7d1a1a] transition"
    >
      <img
        :src="
          isOpen
            ? '/images/btn-contact-close.png'
            : '/images/btn-contact-toggle.png'
        "
        class="w-7"
        alt="toggle"
      />
    </button>

    <!-- Overlay khi mở menu -->
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black/60 z-[9998]"
      @click="toggleMenu"
    ></div>

    <!-- Contact Popup -->
    <transition name="fade">
      <div
        v-if="isOpen"
        class="absolute bottom-20 right-1 flex flex-col gap-3 w-[200px] z-[9999]"
      >
        <!-- Item chung một kiểu -->
        <template v-for="item in contactItems" :key="item.label">
          <div class="flex justify-end items-center gap-3">
            <!-- Text cố định width -->
            <div class="text-right font-mont w-[120px]">
              <p class="font-bold text-[13px] text-white leading-none">
                {{ item.label }}
              </p>
              <p class="text-[11px] text-[#C5C5C5] leading-none mt-[4px]">
                {{ item.sub }}
              </p>
            </div>

            <!-- Icon cùng size container -->
            <a
              :href="item.href"
              target="_blank"
              class="w-14 h-14 flex items-center justify-center rounded-full hover:scale-105 transition"
              :class="item.bg"
            >
              <img :src="item.icon" class="w-9 h-9 object-contain" />
            </a>
          </div>
        </template>
      </div>
    </transition>
  </div>
</template>
<script setup>
import { ref } from "vue";

const isOpen = ref(false);
const toggleMenu = () => {
  isOpen.value = !isOpen.value;
};

const contactItems = [
  {
    label: "MESSENGER",
    sub: "TƯ VẤN 24/7",
    href: "https://m.me/trangiacholding",
    icon: "/images/btn-contact-mes.png",
    bg: "bg-white",
  },
  {
    label: "ZALO",
    sub: "TƯ VẤN NHANH",
    href: "https://zalo.me/0988386886",
    icon: "/images/btn-contact-zalo.png",
    bg: "bg-white",
  },
  {
    label: "FANPAGE",
    sub: "TRẦN GIA HOLDING",
    href: "https://facebook.com/trangiacholding",
    icon: "/images/btn-contact-fb.png",
    bg: "bg-white",
  },
  {
    label: "HOTLINE",
    sub: "098 8386 886",
    href: "tel:0988386886",
    icon: "/images/btn-contact-phone.png",
    bg: "bg-[#9C0000]",
  },
];
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

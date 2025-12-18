<template>
  <div
    class="flex items-center justify-center gap-6 font-gotham text-[18px]"
    :class="themeClasses.text"
  >
    <!-- Previous -->
    <button
      v-if="currentPage > 1"
      @click="go(currentPage - 1)"
      class="hover:opacity-70 cursor-pointer"
    >
      <span>&lt;</span>
    </button>

    <!-- Số trang -->
    <template v-for="page in pagesToShow" :key="page">

      <span v-if="page === '...'">...</span>

      <!-- Active page -->
      <div
        v-else-if="page === currentPage"
        class="font-bold flex text-white items-center justify-center w-[50px] h-[60px] bg-no-repeat bg-center"
        :style="{ backgroundImage: `url(${themeClasses.img})` }"
      >
        {{ page }}
      </div>

      <!-- Normal pages -->
      <button
        v-else
        @click="go(page)"
        :class="['font-bold hover:opacity-70 cursor-pointer', isRedBg ? 'text-white' : 'text-black']"
      >
        {{ page }}
      </button>

    </template>

    <!-- Next -->
    <button
      v-if="currentPage < totalPages"
      @click="go(currentPage + 1)"
      class="hover:opacity-70 cursor-pointer"
    >
      <span>&gt;</span>
    </button>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  currentPage: Number,
  totalPages: Number,
  theme: String,
  param: String,  
  isRedBg: { type: Boolean, default: false },
});

const emit = defineEmits(["change"]);

// Emit event chung
function go(page) {
  emit("change", {
    param: props.param,
    page,
  });
}

// Theme UI
const themeClasses = computed(() =>
  props.theme === "light"
    ? { text: "text-white", img: "/images/page-active.png" }
    : { text: "text-[#660000]", img: "/images/page-active-dark.png" }
);

// Logic list trang
const pagesToShow = computed(() => {
  const pages = [];
  if (props.totalPages <= 7) {
    for (let i = 1; i <= props.totalPages; i++) pages.push(i);
  } else {
    pages.push(1, 2, 3, 4, 5, "...", props.totalPages);
  }
  return pages;
});
</script>

<style scoped>
.pentagon {
  border: 2px solid white;
  clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}
</style>

<template>
  <div
    class="flex items-center justify-center gap-6 font-gotham text-[18px]"
    :class="themeClasses.text"
  >
    <!-- Previous -->
    <button
      v-if="currentPage !== 1"
      @click="prevPage"
      class="hover:opacity-70 cursor-pointer"
    >
      <span>&lt;</span>
    </button>

    <!-- Số trang -->
    <template v-for="page in pagesToShow" :key="page">
      <!-- Dấu ... -->
      <span v-if="page === '...'">...</span>

      <!-- Trang đang active -->
      <div
        v-else-if="page === currentPage"
        class="font-bold flex text-white items-center justify-center w-[50px] h-[60px] bg-no-repeat bg-center"
        :style="{
          backgroundImage: `url(${themeClasses.img})`,
        }"
      >
        {{ page }}
      </div>

      <!-- Trang bình thường -->
      <button
        v-else
        @click="changePage(page)"
        class="font-bold hover:opacity-70 cursor-pointer"
      >
        {{ page }}
      </button>
    </template>

    <!-- Next -->
    <button
      v-if="currentPage !== totalPages"
      @click="nextPage"
      class="hover:opacity-70 cursor-pointer"
    >
      <span>&gt;</span>
    </button>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  currentPage: { type: Number, default: 1 },
  totalPages: { type: Number, default: 7 },
  theme: { type: String, default: "light" },
});

const themeClasses = computed(() => {
  return props.theme === "light"
    ? {
        text: "text-white",
        img: "/images/page-active.png",
      }
    : {
        text: "text-[#660000]",
        img: "/images/page-active-dark.png",
      };
});
const emit = defineEmits(["update:page"]);

const changePage = (page) => {
  emit("update:page", page);
};

const prevPage = () => {
  if (props.currentPage > 1) emit("update:page", props.currentPage - 1);
};

const nextPage = () => {
  if (props.currentPage < props.totalPages)
    emit("update:page", props.currentPage + 1);
};

// Hiển thị dạng 1 2 3 4 5 ... 7
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

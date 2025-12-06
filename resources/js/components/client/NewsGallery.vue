<template>
  <div class="max-w-6xl mx-auto mt-16 pb-10 font-mont">
    <!-- Hàng 1: 3 ảnh -->
    <div
      v-if="images.length >= 3"
      class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6"
    >
      <img
        v-for="(img, i) in images.slice(0, 3)"
        :key="i"
        :src="getImage(img)"
        class="w-full h-auto object-cover rounded cursor-pointer"
        @click="showLightbox(i)"
      />
    </div>

    <!-- Hàng 2: layout 1 lớn + 2 nhỏ -->
    <div
      v-if="images.length >= 6"
      class="grid grid-cols-1 md:grid-cols-3 gap-6"
    >
      <div class="md:col-span-2">
        <img
          :src="getImage(images[3])"
          class="w-full h-[360px] object-cover rounded cursor-pointer"
          @click="showLightbox(3)"
        />
      </div>

      <div class="flex flex-col gap-6">
        <img
          :src="getImage(images[4])"
          class="w-full h-[170px] object-cover rounded cursor-pointer"
          @click="showLightbox(4)"
        />

        <img
          :src="getImage(images[5])"
          class="w-full h-[165px] object-cover rounded cursor-pointer"
          @click="showLightbox(5)"
        />
      </div>
    </div>

    <!-- Nếu ít hơn 6 ảnh -->
    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <img
        v-for="(img, i) in images"
        :key="i"
        :src="getImage(img)"
        class="w-full h-[200px] object-cover rounded cursor-pointer"
        @click="showLightbox(i)"
      />
    </div>

    <!-- LIGHTBOX -->
    <VueEasyLightbox
      :visible="visibleRef"
      :imgs="lightboxImages"
      :index="indexRef"
      @hide="visibleRef = false"
    />
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import VueEasyLightbox from "vue-easy-lightbox";

const props = defineProps({
  images: Array,
});

function getImage(img) {
  if (!img) return "/images/default-news.png";

  if (img.startsWith("data:image")) {
    return img;
  }
  return `/storage/${img}`;
}

const visibleRef = ref(false);
const indexRef = ref(0);

const lightboxImages = computed(() => props.images.map((img) => getImage(img)));

function showLightbox(i) {
  indexRef.value = i;
  visibleRef.value = true;
}
</script>

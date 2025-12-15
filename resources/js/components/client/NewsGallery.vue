<template>
  <div class="max-w-6xl mx-auto mt-16 pb-10 font-mont">

    <!-- MOBILE LAYOUT -->
    <div class="grid md:hidden gap-4">

      <!-- Pattern MOBILE: 2 – 1 – 2 – 1 -->
      <template v-for="(chunk, idx) in mobileChunks" :key="idx">

        <!-- Nếu chunk là 2 ảnh -->
        <div v-if="chunk.length === 2" class="grid grid-cols-2 gap-4">
          <img
            v-for="(img, i2) in chunk"
            :key="i2"
            :src="getImage(img)"
            class="w-full h-[140px] object-cover rounded cursor-pointer"
            @click="showLightbox(chunkStartIndex(idx) + i2)"
          />
        </div>

        <!-- Nếu chunk là 1 ảnh -->
        <div v-else class="w-full">
          <img
            :src="getImage(chunk[0])"
            class="w-full h-[260px] object-cover rounded cursor-pointer"
            @click="showLightbox(chunkStartIndex(idx))"
          />
        </div>

      </template>
    </div>

    <!-- DESKTOP LAYOUT -->
    <div class="hidden md:block">
      <!-- Hàng 1: 3 ảnh -->
      <div v-if="images.length >= 3" class="grid grid-cols-3 gap-6 mb-6">
        <img
          v-for="(img, i) in images.slice(0, 3)"
          :key="i"
          :src="getImage(img)"
          class="w-full h-[220px] object-cover rounded cursor-pointer"
          @click="showLightbox(i)"
        />
      </div>

      <!-- Hàng 2: 1 lớn + 2 nhỏ -->
      <div v-if="images.length >= 6" class="grid grid-cols-3 gap-6">
        <div class="col-span-2">
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
      <div v-else class="grid grid-cols-3 gap-6">
        <img
          v-for="(img, i) in images"
          :key="i"
          :src="getImage(img)"
          class="w-full h-[200px] object-cover rounded cursor-pointer"
          @click="showLightbox(i)"
        />
      </div>
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
  images: {
    type: Array,
    default: () => [],
  },
});

function getImage(img) {
  if (!img) return "/images/default-news.png";
  if (img.startsWith("data:image")) return img;
  if (img.startsWith("/storage/")) return img;
  return `/storage/${img}`;
}

/* 🔥 MOBILE pattern 2 – 1 – 2 – 1 – 2 – 1 ... */
const mobileChunks = computed(() => {
  const arr = [];
  let i = 0;

  while (i < props.images.length) {
    if (i % 3 === 0) {
      // nhóm 2 ảnh
      arr.push(props.images.slice(i, i + 2));
      i += 2;
    } else {
      // ảnh lớn
      arr.push([props.images[i]]);
      i += 1;
    }
  }
  return arr;
});

/* Tính index gốc khi click ảnh trong chunk */
function chunkStartIndex(chunkIndex) {
  let count = 0;
  for (let i = 0; i < chunkIndex; i++) {
    count += mobileChunks.value[i].length;
  }
  return count;
}

/* Lightbox */
const visibleRef = ref(false);
const indexRef = ref(0);

const lightboxImages = computed(() =>
  props.images.map((img) => getImage(img))
);

function showLightbox(i) {
  indexRef.value = i;
  visibleRef.value = true;
}
</script>

<template>
  <div class="max-w-6xl mx-auto mt-16 pb-10 font-mont">
    <!-- Hàng 1: 3 ảnh -->
    <div v-if="images.length >= 3" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <img
        v-for="(img, i) in images.slice(0, 3)"
        :key="i"
        :src="img"
        class="w-full h-[180px] object-cover rounded"
      />
    </div>

    <!-- Hàng 2: layout 1 lớn + 2 nhỏ -->
    <div v-if="images.length >= 6" class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Ảnh lớn trái -->
      <div class="md:col-span-2">
        <img :src="images[3]" class="w-full h-[360px] object-cover rounded" />
      </div>

      <!-- 2 ảnh nhỏ bên phải -->
      <div class="flex flex-col gap-6">
        <img :src="images[4]" class="w-full h-[170px] object-cover rounded" />
        <img :src="images[5]" class="w-full h-[165px] object-cover rounded" />
      </div>
    </div>

    <!-- Nếu gallery ít hơn 6 ảnh → render grid đơn giản -->
    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <img
        v-for="(img, i) in images"
        :key="i"
        :src="img"
        class="w-full h-[200px] object-cover rounded"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  images: {
    type: Array,
    required: true
  }
});
</script>

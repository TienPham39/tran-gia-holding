<template>
  <div class="w-full font-gotham cursor-pointer" @click="handleClick">
    <!-- Ảnh + Badge -->
    <div
      class="relative w-full h-[232px] bg-[#989898] rounded-[6px] mb-4 bg-cover bg-center"
      :style="{ backgroundImage: `url(${image})` }"
    >
      <!-- Badge HOT -->
      <div v-if="isHot" class="absolute -top-1 left-6">
        <img src="/images/hot_product.png" alt="hot" />
      </div>

      <!-- Badge ĐANG BÁN -->
      <div
        v-if="isSelling"
        class="absolute bottom-2 left-2 bg-white/60 text-[#6A6A6A] text-[10px] font-bold px-3 py-1 rounded-md"
      >
        ĐANG BÁN
      </div>
    </div>

    <!-- Title -->
    <h3
      class="text-[24px] font-extrabold uppercase leading-tight"
      :class="themeClasses.title"
    >
      {{ title }}
    </h3>

    <!-- Description -->
    <p
      class="text-[20px] mt-2 font-medium leading-relaxed"
      :class="themeClasses.desc"
    >
      {{ description }}
    </p>

    <!-- Link -->
    <div
      class="text-[12px] mt-3 block text-right font-semibold tracking-wide"
      :class="themeClasses.link"
    >
      XEM CHI TIẾT
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  image: { type: String, required: true },
  title: { type: String, required: true },
  description: { type: String, required: true },
  isHot: { type: Boolean, default: false },
  isSelling: { type: Boolean, default: false },
  theme: { type: String, default: "light" },
  productId: { type: [Number, String], default: null },
});

const themeClasses = computed(() => {
  return props.theme === "light"
    ? {
        title: "text-white",
        desc: "text-gray-300",
        link: "text-white hover:underline",
      }
    : {
        title: "text-[#660000]",
        desc: "text-black/80",
        link: "text-[#660000] hover:underline",
      };
});

function handleClick() {
  if (props.productId) {
    const routeUrl = typeof route !== 'undefined' 
      ? route('client.product.show', props.productId)
      : `/product/detail/${props.productId}`;
    router.visit(routeUrl);
  }
}
</script>

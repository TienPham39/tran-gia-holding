<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <!-- BG Map -->
    <div
      class="absolute inset-0 bg-[url('/images/homepage/bg-map.png')] bg-bottom bg-cover opacity-60 mix-blend-multiply pointer-events-none"
    ></div>

    <div
      class="relative max-w-8xl mx-auto px-7 flex items-center justify-center gap-0"
    >
      <!-- Arrow Left -->
      <button
        @click="prev"
        class="hidden md:flex items-center justify-center h-[500px] cursor-pointer hover:scale-110 transition"
      >
        <img
          src="/images/homepage/news-left-arrow.png"
          class="w-6 opacity-100 hover:opacity-150"
        />
      </button>

      <swiper
        @swiper="onSwiper"
        ref="swiperRef"
        :effect="'coverflow'"
        :grabCursor="true"
        :centeredSlides="true"
        :loop="true"
        :slidesPerView="'auto'"
        :initialSlide="2"
        :watchSlidesProgress="true"
        :coverflowEffect="{
          rotate: 34, // KHÔNG NGHIÊNG
          stretch: -20, // GIÃN 2 BÊN
          depth: 120, // TẠO XA - GẦN
          modifier: 1, // TĂNG MỨC ĐỘ HIỆU ỨNG
          slideShadows: false,
        }"
        :modules="modules"
        class="projectSwiper"
      >
        <swiper-slide
          v-for="(item, index) in slides"
          :key="index"
          class="slide-box"
        >
          <div
            class="flex flex-col items-start text-white px-12 font-banque cursor-pointer"
          >
            <h1
              class="text-[40px] font-bold tracking-wide relative after:content-[''] after:block after:w-14 after:h-0.5 after:bg-white after:mr-auto after:mt-2 after:mb-6 ml-4 mt-16"
            >
              {{ item.title }}
            </h1>

            <p
              class="text-[13px] leading-[1.4] opacity-90 uppercase font-semibold ml-4"
            >
              {{ item.description }}
            </p>

            <div class="w-[260px] h-[60px] bg-white/30 rounded-md mt-30"></div>
          </div>
        </swiper-slide>
      </swiper>

      <!-- Arrow Right -->
      <button
        @click="next"
        class="hidden md:flex items-center justify-center h-[500px] cursor-pointer hover:scale-110 transition"
      >
        <img
          src="/images/homepage/news-right-arrow.png"
          class="w-6 opacity-100 hover:opacity-150"
        />
      </button>
    </div>

    <div class="flex justify-center gap-4 mt-10 font-gotham">
      <!-- Nút 1 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] 
        bg-cover bg-center border-l border-r border-white
        hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        Xem tất cả dự án →
      </button>

      <!-- Nút 2 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] 
        bg-cover bg-center border-l border-r border-white
        hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        <img src="/images/homepage/phone-icon.png" class="w-6 h-6 opacity-90" />
        Liên hệ ngay
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import Layouts from "../../../layouts/client.vue";
import { defineOptions } from "vue";

// Swiper styles
import "swiper/css";
import "swiper/css/effect-coverflow";

// Module
import { EffectCoverflow } from "swiper/modules";

defineOptions({
  layout: Layouts,
});

const modules = [EffectCoverflow];

const swiperRef = ref(null);
const swiperInstance = ref(null);

const onSwiper = (swiper) => {
  swiperInstance.value = swiper;
  setTimeout(() => {
    swiper.slideToLoop(3, 0);
  }, 50);
};

const next = () => swiperInstance.value?.slideNext();
const prev = () => swiperInstance.value?.slidePrev();

const slides = ref([
  {
    title: "DỰ ÁN 1",
    description: "Consectetur adipiscing elit.",
    image: "/images/slide1.jpg",
  },
  {
    title: "DỰ ÁN 2",
    description: "Sed do eiusmod tempor.",
    image: "/images/slide1.jpg",
  },
  {
    title: "DỰ ÁN 3",
    description: "Hành trình phát triển bền vững.",
    image: "/images/slide1.jpg",
  },
  {
    title: "DỰ ÁN 3",
    description: "Hành trình phát triển bền vững.",
    image: "/images/slide1.jpg",
  },
  {
    title: "DỰ ÁN 3",
    description: "Hành trình phát triển bền vững.",
    image: "/images/slide1.jpg",
  },
  {
    title: "DỰ ÁN 3",
    description: "Hành trình phát triển bền vững.",
    image: "/images/slide1.jpg",
  },
]);
</script>

<style>
.projectSwiper {
  width: 100%;
  padding-top: 40px;
  padding-bottom: 60px;
}

/* Card */
.slide-box {
  width: 320px;
  height: 480px;
  background: rgba(255, 255, 255, 0.25);
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.4s;
}
</style>

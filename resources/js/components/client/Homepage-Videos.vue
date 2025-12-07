<template>
  <section class="relative w-full">
    <div class="plyr relative w-full h-[600px] overflow-hidden">
      <!-- VIDEO + POSTER -->
      <video ref="player" class="w-full h-full object-cover" :src="videoUrl" playsinline></video>
    </div>

    <!-- CUSTOM PLAY BUTTON -->
    <button v-if="showPlayButton" @click="playVideo" class="absolute inset-0 flex items-center justify-center z-30">
      <img src="/images/video/Playvideo.png" alt="Play"
        class="cursor-pointer w-22 h-22 opacity-90 hover:opacity-100 transition" />
    </button>
  </section>

  <section class="relative w-full bg-[#670000] overflow-hidden hidden md:block">
    <!-- TOP GRADIENT -->
    <div
      class="absolute inset-x-0 top-0 h-[180px] pointer-events-none z-30 bg-[linear-gradient(180deg,rgba(103,0,0,1)_0%,rgba(103,0,0,0.85)_20%,rgba(103,0,0,0.45)_70%,rgba(103,0,0,0)_100%)]">
    </div>

    <div class="flex justify-center w-full h-[800px]">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- LEFT COLUMN -->
        <div class="ml-2 overflow-hidden cursor-pointer">
          <swiper direction="vertical" :slides-per-view="2" :space-between="200" :loop="true"
            :watchSlidesProgress="true" :autoplay="{ delay: 3000 }" :speed="2500" class="h-[750px]"
            :modules="[Autoplay]">
            <swiper-slide v-for="img in estateColumns[0]" :key="img">
              <img :src="img" class="w-[350px] h-[450px] object-cover" />
            </swiper-slide>
          </swiper>
        </div>

        <!-- CENTER COLUMN -->
        <div class="overflow-hidden flex flex-col">
          <!-- LOGO -->
          <img src="/images/homepage/footer_logo.png" alt="Trần Gia Holding" class="h-50 md:h-70 w-auto z-30" />

          <!-- GRADIENT IMAGE BELOW LOGO -->
          <img src="/images/holding/gradient-top.png" alt="gradient"
            class="absolute top-[320px] left-140 -translate-y-1/2 w-[400px] h-auto z-10 pointer-events-none" />

          <!-- SWIPER BELOW -->
          <swiper direction="vertical" :slides-per-view="2" :space-between="520" :loop="true"
            :watchSlidesProgress="true" :autoplay="{
              delay: 3000,
              disableOnInteraction: false,
              reverseDirection: true,
            }" :speed="2500" class="h-[750px]" :modules="[Autoplay]">
            <swiper-slide v-for="img in estateColumns[1]" :key="img">
              <img :src="img" class="w-[350px] h-[550px] object-cover" />
            </swiper-slide>
          </swiper>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="overflow-hidden">
          <swiper direction="vertical" :slides-per-view="2" :space-between="200" :loop="true"
            :watchSlidesProgress="true" :autoplay="{ delay: 3000 }" :speed="2200" class="h-[750px]"
            :modules="[Autoplay]">
            <swiper-slide v-for="img in estateColumns[2]" :key="img">
              <img :src="img" class="w-[350px] h-[450px] object-cover" />
            </swiper-slide>
          </swiper>
        </div>
      </div>
    </div>

    <!-- BOTTOM GRADIENT -->
    <div
      class="absolute inset-x-0 bottom-0 h-[180px] pointer-events-none z-30 bg-[linear-gradient(0deg,rgba(103,0,0,1)_10%,rgba(103,0,0,0.85)_35%,rgba(103,0,0,0.45)_65%,rgba(103,0,0,0)_80%)]">
    </div>
  </section>

  <section class="relative w-full bg-[#670000] overflow-hidden md:hidden">

    <!-- TOP GRADIENT -->
    <div class="absolute inset-x-0 top-0 h-[120px] pointer-events-none z-30
    bg-[linear-gradient(180deg,rgba(103,0,0,1)_0%,rgba(103,0,0,0.85)_25%,rgba(103,0,0,0)_100%)]">
    </div>

    <!-- LOGO MOBILE - nằm trên cùng -->
    <div class="flex justify-center pt-6 pb-4 z-40 relative">
      <img src="/images/homepage/footer_logo.png" class="w-[260px] h-auto" alt="Trần Gia Holding" />
    </div>

    <!-- SWIPER DỌC -->
    <div class="w-full px-4 pb-10 relative z-20">
      <swiper direction="vertical" :slides-per-view="1" :space-between="10" :loop="true" :autoplay="{ delay: 2500 }"
        :speed="1800" class="h-[400px] w-full" :modules="[Autoplay]">
        <swiper-slide v-for="img in estateMobile" :key="img">
          <img :src="img" class="w-full h-[380px] rounded-xl object-cover" />
        </swiper-slide>
      </swiper>
    </div>

    <!-- BOTTOM GRADIENT -->
    <div class="absolute inset-x-0 bottom-0 h-[180px] pointer-events-none z-30
      bg-[linear-gradient(0deg,rgba(103,0,0,1)_10%,rgba(103,0,0,0.6)_50%,rgba(103,0,0,0)_100%)]">
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";

import { Autoplay } from "swiper/modules";
import { Pagination } from "swiper/modules";
import "swiper/css/pagination";

import Plyr from "plyr";
import "plyr/dist/plyr.css";

const estateMobile = [
  "/images/holding/Holding1.png",
  "/images/holding/Holding2.png",
  "/images/holding/Holding1.png",
  "/images/holding/Holding2.png",
];

const estateColumns = [
  [
    "/images/holding/Holding1.png",
    "/images/holding/Holding1.png",
    "/images/holding/Holding1.png",
  ],
  [
    "/images/holding/Holding2.png",
    "/images/holding/Holding2.png",
    "/images/holding/Holding2.png",
  ],
  [
    "/images/holding/Holding1.png",
    "/images/holding/Holding1.png",
    "/images/holding/Holding1.png",
  ],
];

const player = ref(null);
const plyr = ref(null);
const videoUrl = "/images/video/fixed.mp4";

// Hiển thị nút play custom
const showPlayButton = ref(true);

const playVideo = () => {
  plyr.value.play();
  showPlayButton.value = false;
};

onMounted(() => {
  plyr.value = new Plyr(player.value, {
    autoplay: false,
    controls: ["progress", "mute", "volume", "fullscreen"],
  });

  plyr.value.on("pause", () => {
    showPlayButton.value = true;
  });

  plyr.value.on("play", () => {
    showPlayButton.value = false;
  });
});
</script>

<style>
.plyr video,
.plyr__poster {
  object-fit: cover !important;
  width: 100% !important;
  height: 100% !important;
}

.plyr {
  width: 100% !important;
  height: 600px !important;
  overflow: hidden !important;
  background: #003505;
}
</style>

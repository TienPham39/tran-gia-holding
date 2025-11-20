<template>
  <section class="w-full relative">
    <video
      ref="player"
      class="plyr__video-embed w-full h-[600px] object-cover"
      :src="videoUrl"
      playsinline
    ></video>
  </section>

  <section class="relative w-full bg-[#670000] overflow-hidden">
    <!-- TOP GRADIENT -->
    <div
      class="absolute inset-x-0 top-0 h-[180px] pointer-events-none z-30 bg-[linear-gradient(180deg,rgba(103,0,0,1)_0%,rgba(103,0,0,0.85)_20%,rgba(103,0,0,0.45)_70%,rgba(103,0,0,0)_100%)]"
    ></div>

    <div class="flex justify-center w-full h-[800px]">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- LEFT COLUMN -->
        <div class="ml-2 overflow-hidden cursor-pointer">
          <swiper
            direction="vertical"
            :slides-per-view="2"
            :space-between="200"
            :loop="true"
            :watchSlidesProgress="true"
            :autoplay="{ delay: 3000 }"
            speed="2500"
            class="h-[750px]"
            :modules="[Autoplay]"
          >
            <swiper-slide v-for="img in estateColumns[0]" :key="img">
              <img :src="img" class="w-[350px] h-[450px] object-cover" />
            </swiper-slide>
          </swiper>
        </div>

        <!-- CENTER COLUMN -->
        <div class="overflow-hidden flex flex-col">
          <!-- LOGO -->
          <img
            src="/images/homepage/footer_logo.png"
            alt="Trần Gia Holding"
            class="h-32 md:h-70 w-auto z-30"
          />

          <!-- SWIPER BELOW -->
          <swiper
            direction="vertical"
            :slides-per-view="2"
            :space-between="520"
            :loop="true"
            :watchSlidesProgress="true"
            :autoplay="{
              delay: 3000,
              disableOnInteraction: false,
              reverseDirection: true,
            }"
            speed="2500"
            class="h-[750px]"
            :modules="[Autoplay]"
          >
            <swiper-slide v-for="img in estateColumns[1]" :key="img">
              <img :src="img" class="w-[350px] h-[550px] object-cover" />
            </swiper-slide>
          </swiper>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="overflow-hidden">
          <swiper
            direction="vertical"
            :slides-per-view="2"
            :space-between="200"
            :loop="true"
            :watchSlidesProgress="true"
            :autoplay="{ delay: 3000 }"
            speed="2200"
            class="h-[750px]"
            :modules="[Autoplay]"
          >
            <swiper-slide v-for="img in estateColumns[2]" :key="img">
              <img :src="img" class="w-[350px] h-[450px] object-cover" />
            </swiper-slide>
          </swiper>
        </div>
      </div>
    </div>

    <!-- BOTTOM GRADIENT -->
    <div
      class="absolute inset-x-0 bottom-0 h-[180px] pointer-events-none z-30 bg-[linear-gradient(0deg,rgba(103,0,0,1)_10%,rgba(103,0,0,0.85)_35%,rgba(103,0,0,0.45)_65%,rgba(103,0,0,0)_80%)]"
    ></div>
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

import Plyr from 'plyr'
import 'plyr/dist/plyr.css'

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

const videoUrl = "/images/video/Video.mp4";
const player = ref()

onMounted(() => {
  new Plyr(player.value, {
    autoplay: false,
    controls: ['play', 'progress', 'fullscreen', 'mute', 'volume']
  })
})
</script>

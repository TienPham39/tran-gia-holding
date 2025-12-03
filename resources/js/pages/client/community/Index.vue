<template>
  <section class="w-full pt-14 relative bg-[#480000]">
    <div class="max-w-[1400px] mx-auto relative px-6">
      <!-- CUSTOM ARROWS -->
      <div
        class="absolute left-0 top-1/2 -translate-y-1/2 z-30 cursor-pointer"
        @click="swiper.slidePrev()"
      >
        <img
          src="/images/homepage/news-left-arrow.png"
          class="w-[20px] opacity-70 hover:opacity-100 transition"
        />
      </div>

      <div
        class="absolute right-0 top-1/2 -translate-y-1/2 z-30 cursor-pointer"
        @click="swiper.slideNext()"
      >
        <img
          src="/images/homepage/news-right-arrow.png"
          class="w-[20px] opacity-70 hover:opacity-100 transition"
        />
      </div>

      <!-- SWIPER -->
      <Swiper
        @swiper="onSwiper"
        :spaceBetween="30"
        :pagination="{ clickable: true }"
        :modules="modules"
        class="swiper-banner"
      >
        <SwiperSlide v-for="n in 3" :key="n">
          <!-- CENTER CONTENT -->
          <div class="flex justify-center">
            <div
              class="relative w-[1200px] rounded-xl overflow-hidden shadow-xl"
            >
              <!-- Background banner -->
              <img
                src="/images/homepage/community-banner.png"
                class="w-full h-auto object-cover"
              />
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
    </div>
  </section>

  <section class="w-full relative">
    <!-- BACKGROUND IMAGE -->
    <div class="relative w-full">
      <img
        src="/images/homepage/community-bg1.png"
        class="w-full h-auto object-cover"
      />

      <!-- TOP GRADIENT OVERLAY -->
      <div class="absolute inset-x-0 top-0 z-20 pointer-events-none">
        <img
          src="/images/homepage/community-overlay-top-bg.png"
          class="w-full h-[1000px] object-cover pointer-events-none"
        />
      </div>

      <!-- BOTTOM GRADIENT OVERLAY -->
      <div class="absolute inset-x-0 bottom-0 z-30 pointer-events-none">
        <img
          src="/images/homepage/community-overlay-bottom-bg.png"
          class="w-full h-[800px] object-cover pointer-events-none"
        />
      </div>

      <!-- ===== TOP CONTENT ===== -->
      <div
        class="absolute top-0 inset-x-0 z-30 mx-auto max-w-[1300px] px-8 md:px-20 pt-28 pb-40 grid grid-cols-1 md:grid-cols-2 gap-16"
      >
        <!-- LEFT LOGO -->
        <div class="flex flex-col items-start">
          <img
            src="/images/homepage/footer_logo.png"
            class="w-auto h-[260px] md:h-[300px] object-contain mb-6"
          />
        </div>

        <!-- RIGHT TEXT -->
        <div class="text-white font-gotham">
          <h2
            class="text-xl md:text-4xl font-extrabold mb-8 tracking-wide text-end"
          >
            LOREM IPSUM DOLOR
          </h2>

          <p
            class="leading-relaxed opacity-90 md:text-xl font-bold text-justify"
          >
            Lorem ips dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ure et dolore magna aliqua. Ut enim ad
            minim veniam, quis nostrud exercitatin ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est quat. Duis aute irure
            dolor in reprehe in voluptate velit esse cillum dolore
          </p>
        </div>
      </div>

      <!-- ===== BOTTOM CONTENT ===== -->
      <div
        class="absolute bottom-0 inset-x-0 z-30 mx-auto max-w-[1600px] px-8 md:px-30 pb-40 pt-24"
      >
        <div class="font-gotham text-white text-justify">
          <h2 class="text-xl md:text-4xl font-extrabold mb-4 tracking-wide">
            LOREM IPSUM DOLOR
          </h2>

          <p class="md:text-2xl leading-relaxed opacity-90 font-bold">
            Lorem ips dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ure et dolore magna aliqua. Ut enim ad
            minim veniam, quis nostrud exercitatin ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est quat. Duis aute irure
            dolor in reprehe in voluptate velit esse cillum dolore
          </p>
        </div>
      </div>
    </div>
    <div
      class="pb-14 flex flex-col md:flex-row justify-center items-center gap-10 bg-[#4e0101]"
    >
      <img
        src="/images/holding/Holding3.png"
        class="w-[440px] h-[300px] object-cover rounded-lg shadow-xl"
      />
      <img
        src="/images/holding/Holding4.png"
        class="w-[440px] h-[300px] object-cover rounded-lg shadow-xl"
      />
    </div>
  </section>

  <section
    class="w-full bg-[#4e0101] text-white py-20 px-6 md:px-20 font-gotham"
  >
    <h2
      class="text-center text-2xl md:text-4xl font-extrabold tracking-wide mb-10"
    >
      LOREM IPSUM DOLOR
    </h2>

    <div class="max-w-[1000px] mx-auto text-center md:text-left mb-10">
      <p class="leading-relaxed opacity-90 md:text-2xl text-justify font-bold">
        lorem ips dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ure et dolore magna aliqua. ut enim ad mnim veniam,
        quis nostrud exercitatin ullamco laboris nisi ut aliquip ex ea commodo
        consequat. duis aute irure dolor in reprehenderit in voluptate velit
        esse cillum dolore eu fugiat nulla pariatur. excepteur sint occaecat
        cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
        id est quat. duis aute irure dolor in reprehe in voluptate velit esse
        cillum dolore
      </p>
    </div>

    <!-- IMAGE CENTER -->
    <div class="w-full flex justify-center mb-16">
      <img
        src="/images/homepage/community-kid-1.png"
        class="max-w-[500px] w-full h-auto object-cover"
      />
      <img
        src="/images/homepage/community-kid-2.png"
        class="max-w-[500px] w-full h-auto object-cover"
      />
    </div>

    <!-- TWO COLUMN TEXT -->
    <div
      class="max-w-[1000px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 text-justify"
    >
      <p class="leading-relaxed opacity-90 md:text-2xl font-bold">
        lorem ips dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ure et dolore magna aliqua. ut enim ad mnim veniam,
        quis nostrud exercitatin ullamco laboris nisi ut aliquip ex ea commodo
        consequat. duis aute irure dolor in reprehenderit
      </p>

      <p class="leading-relaxed opacity-90 md:text-2xl font-bold">
        lorem ips dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ure et dolore magna aliqua. ut enim ad mnim veniam,
        quis nostrud exercitatin ullamco laboris nisi ut aliquip ex ea commodo
        consequat. duis aute irure dolor in reprehenderit
      </p>
    </div>
  </section>

  <section class="w-full py-20 px-6 md:px-62 font-gotham">
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-12">
      <h2
        class="text-4xl md:text-5xl font-extrabold tracking-wide text-[#7A0000] font-banque"
      >
        TIN TỨC
      </h2>

      <a
        href="#"
        class="text-sm md:text-base font-semibold text-gray-600 hover:text-[#7A0000] transition"
      >
        XEM TẤT CẢ >>
      </a>
    </div>

    <!-- ARTICLE GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
      <!-- ITEM 1 -->
      <div>
        <div class="w-full h-[260px] bg-gray-400 rounded-md shadow"></div>

        <h3
          class="mt-6 text-[#7A0000] font-extrabold text-xl uppercase leading-snug"
        >
          LOREM IPSUM DOLOR SIT AREMET, CONS
        </h3>

        <p
          class="mt-4 text-gray-700 leading-relaxed text-sm md:text-base w-[90%]"
        >
          excepteur sint occaecat cupidatat non proident, sunt in culpa qui
          officia deserunt mollit anim id est laboru`
        </p>

        <a
          href="#"
          class="block mt-6 text-xs text-end text-gray-500 hover:text-[#7A0000] transition font-semibold tracking-wide"
        >
          XEM CHI TIẾT
        </a>
      </div>

      <!-- ITEM 2 -->
      <div>
        <div class="w-full h-[260px] bg-gray-400 rounded-md shadow"></div>

        <h3
          class="mt-6 text-[#7A0000] font-extrabold text-xl uppercase leading-snug"
        >
          LOREM IPSUM DOLOR SIT AREMET, CONS
        </h3>

        <p
          class="mt-4 text-gray-700 leading-relaxed text-sm md:text-base w-[90%]"
        >
          excepteur sint occaecat cupidatat non proident, sunt in culpa qui
          officia deserunt mollit anim id est laboru`
        </p>

        <a
          href="#"
          class="block mt-6 text-xs text-end text-gray-500 hover:text-[#7A0000] transition font-semibold tracking-wide"
        >
          XEM CHI TIẾT
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import Layouts from "../../../layouts/client.vue";
import { defineOptions } from "vue";
import { ref } from "vue";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";

defineOptions({
  layout: Layouts,
});

const modules = [Pagination];
const swiper = ref(null);

function onSwiper(s) {
  swiper.value = s;
}
</script>

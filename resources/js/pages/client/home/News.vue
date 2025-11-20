<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <!-- BG Map -->
    <SliderSwiper :slides="slides" />

    <div class="flex justify-center gap-4 mt-10 font-gotham">
      <!-- Nút 1 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        Xem tất cả dự án →
      </button>

      <!-- Nút 2 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        <img src="/images/homepage/phone-icon.png" class="w-6 h-6 opacity-90" />
        Liên hệ ngay
      </button>
    </div>
  </section>

  <!-- DANH SÁCH TIN TỨC -->
  <section class="w-full md:px-0 py-20 text-black bg-gray-100">
    <!-- TITLE -->
    <div class="mx-26 flex items-center gap-0 mb-10">
      <img src="/images/homepage/bg-thi-truong-1.png" class="h-[58px]" />

      <!-- Background chứa chữ -->
      <div
        class="h-[58px] w-[800px] flex items-center bg-cover pl-6"
        style="background-image: url('/images/homepage/bg-thi-truong-2.png')"
      >
        <h2
          class="text-[28px] font-banque font-extrabold uppercase tracking-wider text-white"
        >
          Thị trường
        </h2>
      </div>
    </div>

    <div class="mx-26 grid grid-cols-1 lg:grid-cols-3 gap-12">
      <!-- LEFT CONTENT -->
      <div class="lg:col-span-2 flex flex-col gap-10">
        <div
          v-for="i in 3"
          :key="i"
          class="flex gap-6 border-b border-gray-200 pb-8 cursor-pointer"
        >
          <!-- IMAGE -->
          <div
            class="w-[300px] h-[150px] bg-gray-200 rounded-md bg-cover bg-center border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105"
            :style="{
              backgroundImage: `url('/mnt/data/51728305-fc9c-4d72-91c7-081f3794fe41.png')`,
            }"
          >
            <!-- Date Box -->
            <div
              class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] w-12 h-12 mt-3 ml-3 flex flex-col items-center justify-center border-2 border-[#a30000]"
            >
              <p class="text-[14px] font-bold leading-3.5">18</p>
              <p class="text-[12px] font-bold">TH10</p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between font-gotham w-92">
            <div class="">
              <h3
                class="font-extrabold tracking-wide text-[18px] text-black uppercase mb-2"
                style="text-shadow: 0 0 0.5px #000"
              >
                Lorem ipsum dolor sit amet, cons
              </h3>
              <p
                class="font-bold text-gray-700 text-[14px] text-justify leading-relaxed tracking-wide mb-4"
              >
                Excepteur sint occaecat cupidatat non proident, sunt in culpa
                qui officia deserunt mollit anim id est laboru`
              </p>
            </div>

            <a
              href="#"
              class="text-[13px] text-black hover:text-[#a30000] font-semibold ml-auto"
            >
              Xem chi tiết
            </a>
          </div>
        </div>

        <!-- PAGINATION -->
        <div
          class="cursor-pointer font-gotham w-full flex items-center justify-center gap-6 text-[14px] font-extrabold text-[#990000] mt-4"
        >
          <button class="pentagon">1</button>

          <button class="hover:text-[#a30000]">2</button>
          <button class="hover:text-[#a30000]">3</button>
          <button class="hover:text-[#a30000]">4</button>
          <button class="hover:text-[#a30000]">5</button>

          <span class="text-[#990000]">…</span>

          <button class="hover:text-[#a30000]">7</button>
          <button class="hover:text-[#a30000]">&gt;</button>
        </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <div class="flex flex-col gap-6">
        <div class="w-66 h-[30px] bg-gray-300"></div>

        <div v-for="i in 3" :key="i" class="flex gap-3">
          <!-- BOX ẢNH VUÔNG -->
          <div
            class="w-[100px] h-[100px] bg-gray-300 bg-cover bg-center border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105 overflow-hidden"
            :style="{
              backgroundImage: `url('/mnt/data/51728305-fc9c-4d72-91c7-081f3794fe41.png')`,
            }"
          ></div>

          <div class="flex flex-col justify-between w-40">
            <h4
              class="font-gotham text-[#034F00] uppercase leading-tight tracking-wide text-[15px]"
              style="font-weight: 900; text-shadow: 0 0 0.4px #034f00"
            >
              Lorem iuejdy hfi consrta
            </h4>

            <p class="text-[13px] text-gray-700">18/10/2025</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Quy Hoạch Vùng -->
  <section class="w-full md:px-0 py-20 text-black">
    <!-- TITLE -->
    <div class="mx-26 flex items-center gap-0 mb-10">
      <img src="/images/homepage/bg-thi-truong-1.png" class="h-[58px]" />

      <!-- Background chứa chữ -->
      <div
        class="h-[58px] w-[800px] flex items-center bg-cover pl-6"
        style="background-image: url('/images/homepage/bg-thi-truong-2.png')"
      >
        <h2
          class="text-[28px] font-banque font-extrabold uppercase tracking-wider text-white"
        >
          Quy Hoạch Vùng
        </h2>
      </div>
    </div>

    <div class="mx-26 grid grid-cols-1 lg:grid-cols-3 gap-12">
      <!-- LEFT CONTENT -->
      <div class="lg:col-span-2 flex flex-col gap-10">
        <div
          v-for="i in 3"
          :key="i"
          class="flex gap-6 border-b border-gray-200 pb-8 cursor-pointer"
        >
          <!-- IMAGE -->
          <div
            class="w-[300px] h-[150px] bg-gray-200 rounded-md bg-cover bg-center border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105"
            :style="{
              backgroundImage: `url('/mnt/data/51728305-fc9c-4d72-91c7-081f3794fe41.png')`,
            }"
          >
            <!-- Date Box -->
            <div
              class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] w-12 h-12 mt-3 ml-3 flex flex-col items-center justify-center border-2 border-[#a30000]"
            >
              <p class="text-[14px] font-bold leading-3.5">18</p>
              <p class="text-[12px] font-bold">TH10</p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between font-gotham w-92">
            <div class="">
              <h3
                class="font-extrabold tracking-wide text-[18px] text-black uppercase mb-2"
                style="text-shadow: 0 0 0.5px #000"
              >
                Lorem ipsum dolor sit amet, cons
              </h3>
              <p
                class="font-bold text-gray-700 text-[14px] text-justify leading-relaxed tracking-wide mb-4"
              >
                Excepteur sint occaecat cupidatat non proident, sunt in culpa
                qui officia deserunt mollit anim id est laboru`
              </p>
            </div>

            <a
              href="#"
              class="text-[13px] text-black hover:text-[#a30000] font-semibold ml-auto"
            >
              Xem chi tiết
            </a>
          </div>
        </div>

        <!-- PAGINATION -->
        <div
          class="cursor-pointer font-gotham w-full flex items-center justify-center gap-6 text-[14px] font-extrabold text-[#990000] mt-4"
        >
          <button class="pentagon">1</button>

          <button class="hover:text-[#a30000]">2</button>
          <button class="hover:text-[#a30000]">3</button>
          <button class="hover:text-[#a30000]">4</button>
          <button class="hover:text-[#a30000]">5</button>

          <span class="text-[#990000]">…</span>

          <button class="hover:text-[#a30000]">7</button>
          <button class="hover:text-[#a30000]">&gt;</button>
        </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <div class="flex flex-col gap-10 font-gotham ml-10">
        <div v-for="i in 3" :key="i" class="gap-3">
          <!-- BOX ẢNH VUÔNG -->
          <div
            class="items-center ml-4 mb-6 w-[100px] h-[120px] bg-cover bg-center border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105 overflow-hidden"
            :style="{
              backgroundImage: `url('/images/homepage/map-quy-hoach.png')`,
            }"
          ></div>

          <div class="text-[14px] text-center w-32 font-bold uppercase bg-gray-300 rounded-sm">
            Xem bản đồ quy hoạch
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import Layouts from "../../../layouts/client.vue";
import { defineOptions } from "vue";
import SliderSwiper from "../../../components/client/Slider-Swiper.vue";

defineOptions({
  layout: Layouts,
});

const slides = ref([
  {
    title: "DỰ ÁN 1",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 2",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 3",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 4",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 5",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 6",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
]);
</script>

<style>


.pentagon {
  position: relative;
  width: 28px;
  height: 28px;
  margin-bottom: 4px;
  padding-top: 4px;
  background-color: #a30000;
  clip-path: polygon(50% 0%, 100% 35%, 100% 100%, 0% 100%, 0% 35%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 700;
}
</style>

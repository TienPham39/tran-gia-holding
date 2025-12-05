<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <!-- BG Map -->
    <SliderSwiper :slides="slides" />

    <div class="flex justify-center gap-4 font-gotham">
      <!-- Nút 1 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white">
        Xem tất cả dự án →
      </button>

      <!-- Nút 2 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white">
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
      <div class="h-[58px] w-[800px] flex items-center bg-cover pl-6"
        style="background-image: url('/images/homepage/bg-thi-truong-2.png')">
        <h2 class="text-[28px] font-banque font-extrabold uppercase tracking-wider text-white">
          Thị trường
        </h2>
      </div>
    </div>

    <div class="mx-26 grid grid-cols-1 lg:grid-cols-3 gap-12">
      <!-- LEFT CONTENT -->
      <div class="lg:col-span-2 flex flex-col gap-10">
        <div v-for="news in props.thiTruong" :key="news.id"
          class="flex gap-6 border-b border-gray-200 pb-8 cursor-pointer" @click="$inertia.visit(`/news/${news.slug}`)">

          <!-- IMAGE -->
          <div class="w-[300px] h-[150px] bg-gray-200 rounded-md bg-cover bg-center 
            border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] 
            transition-transform duration-300 ease-out hover:scale-105"
            :style="{ backgroundImage: `url('/storage/${news.thumbnail}')` }">
            <div class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] 
              w-12 h-12 mt-3 ml-3 flex flex-col items-center justify-center 
              border-2 border-[#a30000]">
              <p class="text-[14px] font-bold leading-3.5">
                {{ new Date(news.created_at).getDate() }}
              </p>
              <p class="text-[12px] font-bold">
                TH{{ new Date(news.created_at).getMonth() + 1 }}
              </p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between font-mont w-92">
            <div class="">
              <h3 class="font-bold tracking-wide text-[18px] text-justify text-black uppercase mb-2"
                style="text-shadow: 0 0 0.5px #000">
                {{ news.title }}
              </h3>

              <p class="text-[#252525] text-[14px] text-justify leading-relaxed tracking-wide mb-4 line-clamp-2"
                v-html="news.excerpt"></p>
            </div>

            <a class="uppercase text-[13px] text-black hover:text-[#a30000] font-semibold ml-auto">
              Xem chi tiết
            </a>
          </div>
        </div>
        <div class="relative z-30">
          <Pagination :currentPage="page" :totalPages="7" :theme="'dark'" @update:page="page = $event" />
        </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <div class="flex flex-col gap-6 font-mont">
        <div class="w-66 h-[30px] md:text-xl font-bold uppercase leading-relaxed tracking-wide">Tin mới nhất</div>

        <div v-for="news in props.thiTruong.slice(0, 3)" :key="news.id" class="flex gap-3 cursor-pointer"
          @click="$inertia.visit(`/news/${news.slug}`)">

          <div class="w-[100px] h-[100px] bg-cover bg-center rounded overflow-hidden"
            :style="{ backgroundImage: `url('/storage/${news.thumbnail}')` }"></div>

          <div class="flex flex-col justify-between w-40">
            <h4 class="text-[#034F00] uppercase leading-tight tracking-wide text-[15px] line-clamp-2"
              style="font-weight: 900; text-shadow: 0 0 0.4px #034f00">
              {{ news.title }}
            </h4>

            <p class="text-[13px] text-gray-700">
              {{ new Date(news.created_at).toLocaleDateString("vi-VN") }}
            </p>
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
      <div class="h-[58px] w-[800px] flex items-center bg-cover pl-6"
        style="background-image: url('/images/homepage/bg-thi-truong-2.png')">
        <h2 class="text-[28px] font-banque font-extrabold uppercase tracking-wider text-white">
          Quy Hoạch Vùng
        </h2>
      </div>
    </div>

    <div class="mx-26 grid grid-cols-1 lg:grid-cols-3 gap-12">
      <!-- LEFT CONTENT -->
      <div class="lg:col-span-2 flex flex-col gap-10">
        <div v-for="news in props.quyHoachVung" :key="news.id"
          class="flex gap-6 border-b border-gray-200 pb-8 cursor-pointer" @click="$inertia.visit(`/news/${news.slug}`)">

          <!-- IMAGE -->
          <div class="w-[300px] h-[150px] bg-gray-200 rounded-md bg-cover bg-center 
            border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] 
            transition-transform duration-300 ease-out hover:scale-105"
            :style="{ backgroundImage: `url('/storage/${news.thumbnail}')` }">
            <div class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] 
              w-12 h-12 mt-3 ml-3 flex flex-col items-center justify-center 
              border-2 border-[#a30000]">
              <p class="text-[14px] font-bold leading-3.5">
                {{ new Date(news.created_at).getDate() }}
              </p>
              <p class="text-[12px] font-bold">
                TH{{ new Date(news.created_at).getMonth() + 1 }}
              </p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between font-gotham w-92">
            <div class="">
              <h3 class="font-extrabold tracking-wide text-[18px] text-black uppercase mb-2"
                style="text-shadow: 0 0 0.5px #000">
                {{ news.title }}
              </h3>

              <p class="font-bold text-gray-700 text-[14px] text-justify leading-relaxed tracking-wide mb-4 line-clamp-2"
                v-html="news.excerpt"></p>
            </div>

            <a class="uppercase text-[13px] text-black hover:text-[#a30000] font-semibold ml-auto">
              Xem chi tiết
            </a>
          </div>
        </div>
        <div class="relative z-30">
          <Pagination :currentPage="page" :totalPages="7" :theme="'dark'" @update:page="page = $event" />
        </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <div class="flex flex-col gap-10 font-gotham items-center">
        <div v-for="i in 3" :key="i" class="gap-3">
          <!-- BOX ẢNH VUÔNG -->
          <div
            class="items-center ml-4 mb-6 w-[100px] h-[120px] bg-cover bg-center border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105 overflow-hidden"
            :style="{
              backgroundImage: `url('/images/homepage/map-quy-hoach.png')`,
            }"></div>

          <div class="text-[14px] text-center w-32 font-bold uppercase bg-gray-300 rounded-sm">
            Xem bản đồ quy hoạch
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- <section class="w-full py-20 bg-[#f7f7f7] font-mont">
    <div class="mx-26 flex items-center gap-0 mb-10">
      <img src="/images/homepage/bg-thi-truong-1.png" class="h-[58px]" />

      <div class="h-[58px] w-[800px] flex items-center bg-cover pl-6"
        style="background-image: url('/images/homepage/bg-thi-truong-2.png')">
        <h2 class="text-[28px] font-banque font-extrabold uppercase tracking-wider text-white">
          Trần Gia Holding
        </h2>
      </div>
    </div>

    <div class="mx-26 grid grid-cols-1 lg:grid-cols-3 gap-12">

      <div class="lg:col-span-2 flex flex-col gap-12">

        <div v-for="item in holdingNews" :key="item.id"
          class="flex gap-6 border-b border-gray-300 pb-10 cursor-pointer">
          <div
            class="w-[300px] h-[150px] bg-gray-200 rounded-md bg-cover bg-center border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105"
            :style="{ backgroundImage: `url('/storage/${item.thumbnail}')` }">
            <div class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000]
              w-12 h-12 mt-3 ml-3 flex flex-col items-center justify-center border-2 border-[#a30000]">
              <p class="text-[14px] font-bold leading-3.5">
                {{ formatDate(item.created_at, 'day') }}
              </p>
              <p class="text-[12px] font-bold">
                TH{{ formatDate(item.created_at, 'month') }}
              </p>
            </div>
          </div>

          <div class="flex flex-col justify-between w-[420px]">

            <div>
              <h3 class="font-extrabold tracking-wide text-[18px] text-black uppercase mb-2 line-clamp-2"
                style="text-shadow: 0 0 0.5px #000">
                {{ item.title }}
              </h3>

              <p class="font-bold text-gray-700 text-[14px] text-justify leading-relaxed tracking-wide line-clamp-3">
                <span v-html="item.excerpt"></span>
              </p>
            </div>

            <a :href="`/news/${item.slug}`" class="text-[13px] text-black hover:text-[#a30000] font-semibold ml-auto">
              Xem chi tiết
            </a>
          </div>
        </div>

        <div class="relative z-30">
          <Pagination :currentPage="currentPage" :totalPages="totalPages" :theme="'dark'"
            @update:page="$emit('updatePage', $event)" />
        </div>
      </div>

      <div class="flex flex-col gap-8">

        <div class="w-66 h-[30px] md:text-xl font-bold uppercase leading-relaxed tracking-wide">Tin mới nhất</div>

        <div v-for="news in latestNews" :key="news.id" class="flex gap-3 cursor-pointer">
          <div class="w-[80px] h-[80px] bg-gray-300 bg-cover bg-center rounded-sm"
            :style="{ backgroundImage: `url('/storage/${news.thumbnail}')` }"></div>

          <div class="flex flex-col justify-between w-40">
            <h4 class="text-[#034F00] uppercase leading-tight font-bold text-[15px] line-clamp-3">
              {{ news.title }}
            </h4>

            <p class="text-[13px] text-gray-700">
              {{ formatDate(news.created_at) }}
            </p>
          </div>
        </div>

      </div>
    </div>
  </section> -->
</template>

<script setup>
import { ref } from "vue";
import { defineOptions } from "vue";
import SliderSwiper from "../../../components/client/Slider-Swiper.vue";
import Pagination from "@/Components/client/Paginate.vue";
import Layouts from "../../../layouts/client.vue";

defineOptions({
  layout: Layouts,
});

const page = ref(1);

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

const props = defineProps({
  thiTruong: Array,
  quyHoachVung: Array,
});

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

<template>
  <!-- SECTION: GIỚI THIỆU DỰ ÁN / HIGHLIGHT BANNER -->
  <section class="w-full overflow-hidden bg-[#00310F]">
    <!-- TOP NAV BUTTONS + LOGO -->
    <div class="flex items-center justify-center gap-4 py-8">
      <div class="flex gap-5 font-gotham">
        <button
          @click="router.visit('/')"
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          TRANG CHỦ
        </button>
        <button
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          GIỚI THIỆU DỰ ÁN
        </button>
      </div>

      <div>
        <img
          src="/images/homepage/tran-gia-village.png"
          class="h-18 w-auto object-contain mx-2"
          alt="Trần Gia Village Logo"
        />
      </div>

      <div class="flex gap-5 font-gotham">
        <button
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          HÌNH ẢNH DỰ ÁN
        </button>
        <button
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          SƠ ĐỒ PHÂN LÔ
        </button>
      </div>
    </div>

    <!-- Background Image -->
    <div class="w-full h-[450px] md:h-full overflow-hidden">
      <img
        src="/images/homepage/bg-detailpage.png"
        class="w-full h-full object-cover object-center"
        alt="Project Banner"
      />
    </div>

    <!-- Box Info -->
    <div
      class="absolute left-1/2 -translate-x-1/2 bottom-[-40px] md:bottom-[-190px] flex gap-4 md:gap-8 z-30"
    >
      <div
        v-for="(item, index) in infoBoxes"
        :key="index"
        class="w-[120px] md:w-[160px] h-[150px] md:h-[170px] flex flex-col justify-center items-center rounded-md font-extrabold uppercase text-[#00330D] text-xl md:text-4xl shadow-[0_8px_25px_rgba(0,0,0,0.35)] bg-[url('/images/homepage/linear-bg.png')] bg-cover bg-center"
      >
        <div
          class="-translate-y-1 md:-translate-y-5 flex flex-col items-center"
        >
          <span>{{ item.line1 }}</span>
          <span>{{ item.line2 }}</span>
        </div>
      </div>
    </div>
  </section>

  <section class="relative w-full bg-[#00310F] pt-32 font-gotham">
    <!-- Title -->
    <h2
      class="font-gotham text-2xl md:text-4xl font-extrabold text-center text-white uppercase tracking-wide my-16"
    >
      LOREM IPSUM DOLOR SIT AMET, CONS
    </h2>

    <!-- Description -->
    <p
      class="text-2xl text-center text-white mx-auto leading-relaxed px-96 mb-20"
    >
      lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. ut enim ad minim
      veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo consequat. duis aute irure dolor in reprehenderit in voluptate
      velit esse cillum dolore eu fugiat nulla pariatur. excepteur sint occaecat
      cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id
      est laborum.
    </p>

    <div
      class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-6 mb-20"
    >
      <!-- COLUMN 1 -->
      <div class="flex flex-col gap-6">
        <div class="h-[410px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[350px] bg-[#AAAAAA]"></div>
          <div class="h-[60px] bg-[#D9D9D9]"></div>
        </div>

        <div class="h-[250px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[190px] bg-[#AAAAAA]"></div>
          <div class="h-[70px] bg-[#D9D9D9]"></div>
        </div>
      </div>

      <!-- COLUMN 2 -->
      <div class="flex flex-col gap-6">
        <div class="h-[330px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[270px] bg-[#AAAAAA]"></div>
          <div class="h-[60px] bg-[#D9D9D9]"></div>
        </div>

        <div class="h-[330px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[270px] bg-[#AAAAAA]"></div>
          <div class="h-[60px] bg-[#D9D9D9]"></div>
        </div>
      </div>

      <!-- COLUMN 3 -->
      <div class="flex flex-col gap-6">
        <div class="h-[260px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[190px] bg-[#AAAAAA]"></div>
          <div class="h-[70px] bg-[#D9D9D9]"></div>
        </div>

        <div class="h-[400px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[340px] bg-[#AAAAAA]"></div>
          <div class="h-[70px] bg-[#D9D9D9]"></div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="relative z-30 mb-20">
      <Pagination
        :currentPage="page"
        :totalPages="7"
        :theme="'light'"
        @update:page="page = $event"
      />
    </div>

    <div class="border-1 w-[1200px] border-[#757575] mx-auto"></div>
  </section>

  <section class="relative w-full bg-[#00310F]">
    <div class="relative w-full h-[400px] flex items-center justify-center">
      <div
        class="absolute inset-0 bg-[url('/images/homepage/bg-map.png')] bg-cover bg-center opacity-90 mix-blend-multiply"
      ></div>

      <!-- Text -->
      <h2
        class="relative font-gotham uppercase text-[#B8FFC5] text-5xl md:text-5xl font-extrabold tracking-wide text-center"
      >
        SƠ ĐỒ PHÂN LÔ
      </h2>
    </div>

    <!-- Map Image Wrapper -->
    <div class="relative max-w-[1100px] mx-auto">
      <div class="w-full overflow-hidden">
        <img
          src="/images/homepage/sodophanlo1.png"
          alt="Sơ đồ phân lô"
          class="w-full h-auto object-contain"
        />
      </div>
      <div class="w-full overflow-hidden">
        <img
          src="/images/homepage/lienketvung.png"
          alt="Sơ đồ phân lô"
          class="w-full h-auto object-contain"
        />
      </div>
    </div>
  </section>
  <Contact />
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "@/Components/client/Paginate.vue";
import Contact from "../../../components/client/Contact.vue";
import Footer from "../../../components/client/Footer.vue";
import { router } from "@inertiajs/vue3";

const page = ref(1);
const infoBoxes = [
  { line1: "1000", line2: "M2" },
  { line1: "GẦN", line2: "TP" },
  { line1: "LOS", line2: "HUET" },
  { line1: "LOS", line2: "HUET" },
];
</script>

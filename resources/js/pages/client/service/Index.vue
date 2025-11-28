<template>
  <section
    class="w-full bg-[#660000] bg-bottom bg-cover bg-[url('/images/homepage/bg-service.png')] py-30"
  >
    <div class="container mx-auto px-6 text-center">
      <!-- TITLE -->
      <h2
        class="font-banque uppercase text-white text-4xl md:text-5xl font-bold tracking-wide mb-18"
      >
        dịch vụ
      </h2>

      <!-- SERVICE GRID -->
      <div
        class="grid grid-cols-1 md:grid-cols-3 gap-8 font-gotham justify-center mx-auto max-w-[1000px]"
      >
        <div
          v-for="(item, index) in services"
          :key="index"
          class="bg-white rounded-xl p-6 shadow-md flex flex-col items-center justify-center gap-4 transition-transform duration-300 hover:scale-105 h-[250px]"
        >
          <img :src="item.img" class="w-[120px] h-[120px] object-contain" />

          <div class="text-center">
            <h3 class="text-2xl font-bold">{{ item.title }}</h3>
            <p v-if="item.sub" class="text-sm mt-1 tracking-wide">
              {{ item.sub }}
            </p>
          </div>
        </div>
      </div>

      <!-- DESCRIPTION BELOW -->
      <p
        class="text-2xl tracking-wider text-white text-center mt-20 font-gotham"
      >
        “lorem ipsum dolor sit amet, consectetur adipiscing elit”
      </p>
    </div>
  </section>

  <section class="w-full py-20">
    <div
      class="container mx-auto px-20 grid grid-cols-1 md:grid-cols-2 gap-20 items-center"
    >
      <!-- LEFT CONTENT -->
      <div class="text-left font-gotham">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">ĐO ĐẠC</h2>

        <p class="font-bold leading-relaxed mb-8 max-w-[600px] tracking-widest">
          lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut
          aliquip
        </p>

        <div class="w-full h-[300px] overflow-hidden">
          <img
            src="/images/homepage/survey-engineer.png"
            class="w-full h-full object-cover"
          />
        </div>
      </div>

      <!-- RIGHT IMAGE + BUTTON -->
      <div class="flex flex-col">
        <h1
          class="self-end font-banque text-[#770000] text-3xl md:text-5xl font-bold tracking-wide mb-6 text-right"
        >
          ĐO ĐẠC
        </h1>

        <div class="w-full h-[360px] overflow-hidden mb-6">
          <img
            src="/images/homepage/survey-tool.png"
            class="w-full h-full object-cover"
          />
        </div>

        <!-- BUTTON -->
        <button
          class="self-start group cursor-pointer flex items-center gap-2 border border-[#AE0000] text-[#AE0000] px-4 py-2 rounded-md font-semibold tracking-wider hover:bg-[#770000] hover:text-white transition"
        >
          <img
            src="/images/homepage/phone-icon-red.png"
            class="w-5 h-5 object-contain group-hover:hidden"
          />
          <img
            src="/images/homepage/phone-icon.png"
            class="w-5 h-5 object-contain hidden group-hover:block"
          />
          LIÊN HỆ NGAY
        </button>
      </div>
    </div>
  </section>

  <section class="w-full bg-[#00310F] py-20">
    <div class="container mx-auto px-6">
      <!-- TOP GRID -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
        <!-- LEFT CONTENT -->
        <div class="md:ml-auto text-left">
          <h2
            class="font-banque text-white text-3xl md:text-5xl font-bold tracking-wide mb-6"
          >
            THIẾT KẾ
          </h2>

          <p class="text-gray-300 leading-relaxed mb-8 max-w-[500px]">
            lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip
          </p>
        </div>

        <!-- RIGHT ICON -->
        <div class="flex justify-center md:justify-center">
          <img
            src="/images/homepage/design-icon.png"
            class="w-40 md:w-56 opacity-90"
            alt="Thiết kế icon"
          />
        </div>
      </div>

      <!-- PROCESS TITLE -->
      <h3
        class="text-white font-extrabold font-gotham text-2xl md:text-4xl text-center mt-16 tracking-wide"
      >
        QUY TRÌNH THIẾT KẾ
      </h3>

      <!-- PROCESS STEPS -->
      <div class="flex justify-center items-center my-18 flex-wrap">
        <div class="relative flex items-center">
          <div
            class="w-20 h-20 border-2 border-[#8CC6A6] rounded-full flex items-center justify-center"
          >
            <img
              src="/images/homepage/icon-design-1.png"
              class="w-10 h-10 object-contain"
            />
          </div>
          <div class="hidden md:block w-20 h-[1px] bg-[#8CC6A6]"></div>
        </div>

        <div class="relative flex items-center">
          <div
            class="w-20 h-20 border-2 border-[#8CC6A6] rounded-full flex items-center justify-center"
          >
            <img
              src="/images/homepage/icon-design-2.png"
              class="w-10 h-10 object-contain"
            />
          </div>
          <div class="hidden md:block w-20 h-[1px] bg-[#8CC6A6]"></div>
        </div>

        <div class="relative flex items-center">
          <div
            class="w-20 h-20 border-2 border-[#8CC6A6] rounded-full flex items-center justify-center"
          >
            <img
              src="/images/homepage/icon-design-3.png"
              class="w-10 h-10 object-contain"
            />
          </div>
          <div class="hidden md:block w-20 h-[1px] bg-[#8CC6A6]"></div>
        </div>

        <div class="relative flex items-center">
          <div
            class="w-20 h-20 border-2 border-[#8CC6A6] rounded-full flex items-center justify-center"
          >
            <img
              src="/images/homepage/icon-design-4.png"
              class="w-10 h-10 object-contain"
            />
          </div>
        </div>
      </div>

      <!-- IMAGES ROW -->
      <div
        class="flex flex-wrap justify-center items-start gap-3 md:gap-4 mt-16"
      >
        <div class="h-[200px] md:h-[320px] w-full md:w-[250px] overflow-hidden">
          <img
            src="/images/homepage/design-image-1.png"
            class="w-full h-full object-cover"
          />
        </div>

        <div class="h-[200px] md:h-[320px] w-full md:w-[460px] overflow-hidden">
          <img
            src="/images/homepage/design-image-2.png"
            class="w-full h-full object-cover"
          />
        </div>

        <div class="h-[200px] md:h-[320px] w-full md:w-[250px] overflow-hidden">
          <img
            src="/images/homepage/design-image-3.png"
            class="w-full h-full object-cover"
          />
        </div>
      </div>

      <!-- CTA BUTTON -->
      <div class="flex justify-center mt-12">
        <button
          class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button-green.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
        >
          <img
            src="/images/homepage/phone-icon.png"
            class="w-6 h-6 opacity-90"
          />
          Liên hệ ngay
        </button>
      </div>
    </div>
  </section>

  <section class="w-full py-20">
    <div
      class="container mx-auto px-20 grid grid-cols-1 md:grid-cols-2 gap-20 items-center"
    >
      <!-- LEFT CONTENT -->
      <div class="text-left font-gotham">
        <h2 class="uppercase text-3xl md:text-4xl font-extrabold mb-10">
          giải quyết mọi vấn đề
        </h2>

        <p
          class="font-bold leading-relaxed mb-26 max-w-[600px] tracking-widest"
        >
          Giải quyết mọi vướng mắc về thủ tục hành chính: Sang tên, tách thửa,
          chuyển đổi mục đích sử dụng đất, kiểm tra quy hoạch. Đảm bảo "Minh
          bạch - Đúng luật - Nhanh gọn".
        </p>

        <div class="w-full h-[300px] overflow-hidden">
          <img
            src="/images/homepage/service-bg-1.png"
            alt="Service Background"
            class="w-full h-full object-cover object-center"
          />
        </div>
      </div>

      <!-- RIGHT IMAGE + BUTTON -->
      <div class="flex flex-col">
        <h1
          class="uppercase self-end font-banque text-[#770000] text-3xl md:text-6xl font-bold tracking-wide mb-6 text-right"
        >
          Tư Vấn
        </h1>
        <h1
          class="uppercase self-end font-banque text-[#770000] text-3xl md:text-3xl font-bold tracking-wide mb-6 text-right"
        >
          pháp lý bĐS
        </h1>

        <div class="w-full h-[360px] overflow-hidden mb-6">
          <img
            src="/images/homepage/service-bg-2.png"
            alt="Service Image"
            class="w-full h-full object-cover object-center"
          />
        </div>

        <!-- BUTTON -->
        <button
          class="self-start group cursor-pointer flex items-center gap-2 border-2 border-[#AE0000] text-[#AE0000] px-4 py-1 rounded-sm font-semibold tracking-wider hover:bg-[#770000] hover:text-white transition"
        >
          <img
            src="/images/homepage/phone-icon-red.png"
            class="w-5 h-5 object-contain group-hover:hidden"
          />
          <img
            src="/images/homepage/phone-icon.png"
            class="w-5 h-5 object-contain hidden group-hover:block"
          />
          LIÊN HỆ NGAY
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import Layouts from "../../../layouts/client.vue";

defineOptions({
  layout: Layouts,
});

const services = [
  {
    title: "ĐO ĐẠC",
    sub: "",
    img: "/images/homepage/ruler-service.png",
  },
  {
    title: "THIẾT KẾ",
    sub: "XÂY DỰNG",
    img: "/images/homepage/plan-service.png",
  },
  {
    title: "TƯ VẤN",
    sub: "PHÁP LÝ BẤT ĐỘNG SẢN",
    img: "/images/homepage/support-service.png",
  },
];
</script>

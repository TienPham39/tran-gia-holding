<template>
  <footer class="bg-[#2A2A2A] text-white pt-8 pb-16 font-gotham">
    <div
      class="max-w-[1400px] mx-auto flex flex-col md:flex-row justify-center items-start gap-20 md:gap-10 px-4"
    >
      <!-- LEFT COLUMN -->
      <div
        class="flex flex-col items-center text-center w-full"
      >
        <!-- LOGO -->
        <img
          src="/images/homepage/footer_logo_new.png"
          alt="Trần Gia Logo"
          class="w-[200px] md:w-[320px] h-auto mb-6 md:mb-8"
        />

        <!-- SLOGAN -->
        <p
          class="text-gray-300 leading-relaxed mb-6 md:mb-8 text-base md:text-xl font-bold"
        >
          “Khởi Tâm Vươn Tầm<br />
          Đối tác tin cậy của mọi nhà đầu tư.”
        </p>

        <!-- SOCIAL ICONS -->
        <div class="flex items-center gap-5 md:gap-8">
          <img
            src="/images/homepage/ytb.png"
            class="w-7 h-7 md:w-8 md:h-8 cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/fb.png"
            class="w-7 h-7 md:w-8 md:h-8 cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/zalo.png"
            class="w-7 h-7 md:w-8 md:h-8 cursor-pointer hover:opacity-80 transition"
          />
        </div>
      </div>

      <!-- RIGHT AREA -->
      <div class="flex flex-col w-full max-w-[800px] mt-2 md:mt-20 md:mr-20">
        <!-- TITLE -->
        <h3
          class="text-xl md:text-2xl font-banque tracking-wide text-center md:text-left mb-6 md:mb-10"
        >
          CÔNG TY CỔ PHẦN TẬP ĐOÀN TRẦN GIA
        </h3>

        <!-- GRID (1 COL MOBILE – 2 COL DESKTOP) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14">
          <!-- LEFT INFO -->
          <div
            class="flex flex-col gap-3 text-base md:text-lg text-center md:text-left"
          >
            <p class="text-gray-300">
              <span class="font-bold text-white">Trụ sở:</span>
              [Địa chỉ văn phòng tại Lâm Đồng]
            </p>
            <p class="text-gray-300">
              <span class="font-bold text-white">Hotline:</span>
              098 8386 886
            </p>
            <p class="text-gray-300">
              <span class="font-bold text-white">Email:</span>
              [Email công ty]
            </p>
            <p class="text-gray-300">
              <span class="font-bold text-white">Website:</span>
              trangiagolding.vn
            </p>
          </div>

          <!-- RIGHT SERVICES -->
          <div
            class="flex flex-col gap-3 text-base md:text-lg text-center md:text-left"
          >
            <h3
              class="text-lg md:text-xl font-gotham font-extrabold tracking-wide mb-1"
            >
              DỊCH VỤ NỔI BẬT
            </h3>

            <p class="text-gray-300">Dịch vụ đo đạc</p>
            <p class="text-gray-300">Dịch vụ thiết kế</p>
            <p class="text-gray-300">Tư vấn pháp lý BĐS</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

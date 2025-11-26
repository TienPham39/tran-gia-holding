<template>
  <footer class="bg-[#2A2A2A] text-white pt-12 pb-16 font-gotham">
    <div
      class="max-w-[1400px] mx-auto flex flex-col md:flex-row justify-center items-start gap-30"
    >
      <!-- LEFT COLUMN -->
      <div class="flex flex-col items-center text-center min-w-[420px]">
        <!-- LOGO -->
        <img
          src="/images/homepage/footer_logo_new.png"
          alt="Trần Gia Logo"
          class="w-[320px] h-auto mb-8"
        />

        <!-- SLOGAN -->
        <p class="text-gray-300 leading-relaxed mb-8 text-xl">
          “Khởi Tâm Vươn Tầm<br />
          Đối tác tin cậy của mọi nhà đầu tư.”
        </p>

        <!-- SOCIAL ICONS -->
        <div class="flex items-center gap-8">
          <img
            src="/images/homepage/ytb.png"
            class="w-8 h-8 cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/fb.png"
            class="w-8 h-8 cursor-pointer hover:opacity-80 transition"
          />
          <img
            src="/images/homepage/zalo.png"
            class="w-8 h-8 cursor-pointer hover:opacity-80 transition"
          />
        </div>
      </div>

      <!-- RIGHT AREA (TITLE + 2 COLUMN GRID) -->
      <div class="flex flex-col w-full max-w-[800px]">
        <!-- TITLE -->
        <h3 class="text-2xl font-banque tracking-wide mt-20 mb-10">
          CÔNG TY CỔ PHẦN TẬP ĐOÀN TRẦN GIA
        </h3>

        <!-- GRID 2 COLUMNS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-14">

          <!-- LEFT INFO -->
          <div class="flex flex-col gap-4 text-lg">
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
          <div class="flex flex-col gap-4 text-lg">
            <h3 class="text-xl font-gotham font-extrabold tracking-wide mb-2">
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

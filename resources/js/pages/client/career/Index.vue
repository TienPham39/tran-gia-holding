<template>
  <section class="w-full bg-[#660000] pt-16 md:pt-24 pb-36 md:pb-30">
    <div
      class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 px-4"
    >
      <!-- LEFT CONTENT -->
      <div class="text-white text-center md:text-left">
        <!-- Title -->
        <h2
          class="font-banque text-4xl md:text-6xl font-extrabold leading-tight mb-4 md:mb-7 tracking-wide"
        >
          TUYỂN<br class="hidden md:block" />DỤNG
        </h2>

        <!-- Description -->
        <p
          class="text-justify text-base md:text-lg leading-relaxed mb-4 md:mb-6 opacity-90"
        >
          "Khám phá các cơ hội nghề nghiệp cùng Trần Gia Holding, nơi bạn có thể
          phát triển bản thân và góp phần xây dựng cộng đồng công ty thịnh
          vượng."
        </p>

        <p
          class="text-justify text-sm md:text-base leading-relaxed mb-10 md:mb-16 opacity-90"
        >
          Trần Gia Holding hiện đang tìm kiếm các ứng viên tiềm năng cho nhiều
          vị trí hấp dẫn trong lĩnh vực bất động sản, quản lý dự án và chăm sóc
          khách hàng. Chúng tôi quan tâm đến những cá nhân năng động, sáng tạo
          và có tinh thần trách nhiệm cao.
        </p>

        <!-- Button -->
        <button
          class="cursor-pointer font-semibold text-sm md:text-base px-6 py-2 text-white uppercase tracking-wider rounded-sm flex md:inline-flex justify-center items-center gap-2 mx-auto md:mx-0 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] w-full md:w-auto"
        >
          xem tất cả >>
        </button>
      </div>

      <!-- RIGHT IMAGES -->
      <div
        class="relative flex items-end justify-center md:justify-end mt-12 md:mt-0"
      >
        <!-- Shadow -->
        <img
          src="/images/homepage/career-shadow.png"
          class="absolute bottom-[-72px] md:bottom-[-96px] left-1/2 -translate-x-1/2 w-[250px] md:w-[480px] opacity-80 pointer-events-none invert brightness-90"
        />

        <!-- Building -->
        <img
          src="/images/homepage/career-bg.png"
          class="w-[260px] md:w-[500px] object-contain relative z-10"
        />

        <!-- Girl -->
        <img
          src="/images/homepage/career-girl.png"
          class="absolute bottom-[-68px] md:bottom-[-90px] left-[28%] md:left-[22%] w-[60px] md:w-[100px] z-20"
        />

        <!-- Men -->
        <img
          src="/images/homepage/career-men.png"
          class="absolute bottom-[-68px] md:bottom-[-90px] right-[28%] md:right-[20%] w-[90px] md:w-[150px] z-20"
        />
      </div>
    </div>
  </section>

  <section class="w-full py-16 md:pt-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 md:px-2">
      <!-- TITLE -->
      <h2
        class="font-banque text-center text-3xl md:text-5xl font-extrabold text-[#7A0000] tracking-wide mb-6 md:mb-8"
      >
        TRẦN GIA HOLDING TUYỂN DỤNG <br class="hidden md:block" />
        CÁC VỊ TRÍ
      </h2>

      <!-- SUBTITLE -->
      <p
        class="font-gotham font-bold text-center text-gray-600 text-base md:text-lg max-w-4xl mx-auto mb-10 md:mb-16 px-4"
      >
        "Tham gia đội ngũ chuyên nghiệp, môi trường làm việc thân thiện, chế độ
        đãi ngộ cạnh tranh."
      </p>

      <!-- JOB LIST -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14">
        <div
          v-for="(job, index) in jobs"
          :key="index"
          class="flex flex-col md:flex-row items-start md:items-start gap-4 md:gap-6 p-3 md:p-0 border-b md:border-none pb-6 md:pb-0"
        >
          <!-- IMAGE -->
          <div
            class="w-[100px] h-[100px] md:w-[130px] md:h-[130px] bg-gray-200 rounded-md bg-cover bg-center border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105 shrink-0"
            :style="{
              backgroundImage: `url('/images/job-thumb.png')`,
            }"
          >
            <!-- Date box -->
            <div
              class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] w-10 h-10 md:w-12 md:h-12 mt-2 ml-2 md:mt-3 md:ml-3 flex flex-col items-center justify-center border-2 border-[#a30000]"
            >
              <p
                class="text-[12px] md:text-[14px] font-bold leading-[12px] md:leading-[14px]"
              >
                {{ job.date }}
              </p>
              <p class="text-[10px] md:text-[12px] font-bold">
                {{ job.month }}
              </p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between flex-1 w-full">
            <div class="min-h-[110px] md:min-h-[100px] mt-2 md:mt-0">
              <h3
                class="font-bold text-base md:text-lg text-black leading-snug"
              >
                {{ job.title }}
              </h3>

              <p
                class="text-gray-700 text-sm mt-1 line-clamp-2 md:line-clamp-3"
              >
                {{ job.desc }}
              </p>

              <p class="text-[#B40000] font-semibold mt-1 text-sm">
                Lương: {{ job.salary }}
              </p>
            </div>

            <!-- LOCATION + BUTTON -->
            <div
              class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mt-3"
            >
              <p class="text-gray-500 text-sm">{{ job.location }}</p>

              <button
                class="cursor-pointer text-sm uppercase bg-[#9B1C1C] text-white px-3 py-2 rounded-sm border border-transparent transition-all duration-200 hover:bg-transparent hover:border-[#9B1C1C] hover:text-[#9B1C1C] md:px-3 md:py-1.5 w-full md:w-auto text-center"
              >
                Gửi hồ sơ >>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="relative w-full overflow-hidden bg-white">
    <!-- MOUNTAIN + LOGO -->
    <div class="relative w-full flex justify-center">
      <!-- Mountain -->
      <img
        src="/images/homepage/career-mountain.png"
        class="w-full max-w-full h-[400px] md:h-full object-cover md:object-contain"
        alt="Mountain"
      />

      <!-- Logo overlay -->
      <img
        src="/images/homepage/career-logo.png"
        class="absolute top-[10px] md:top-[100px] w-[140px] md:w-[300px] object-contain"
        alt="Trần Gia Holding Logo"
      />
    </div>

    <!-- GRADIENT OVERLAY -->
    <div
      class="absolute bottom-0 left-0 w-full h-[380px] md:h-[450px] bg-gradient-to-t from-[#660000] via-[#660000ee] to-[#66000000] z-20"
    ></div>

    <!-- TEXT CONTENT -->
    <div
      class="relative z-20 max-w-5xl mx-auto px-5 md:px-6 mt-[-90px] md:mt-[-180px]"
    >
      <h2
        class="font-banque text-white text-3xl md:text-5xl font-extrabold mb-4 md:mb-6 tracking-wide text-center md:text-left"
      >
        VỀ TRẦN GIA
      </h2>

      <p
        class="text-white text-base md:text-xl leading-relaxed tracking-wide text-justify mb-4 md:mb-5"
      >
        <span class="font-bold">Trần Gia Holding</span> là đơn vị hàng đầu trong
        lĩnh vực bất động sản và quản lý dự án tại Đà Lạt, luôn hướng tới giá
        trị bền vững và sự phát triển cộng đồng.
      </p>

      <p
        class="text-white text-base md:text-lg leading-relaxed tracking-wide text-justify opacity-90"
      >
        Chúng tôi không ngừng đổi mới, xây dựng môi trường làm việc chuyên
        nghiệp, chia sẻ thành công cùng nhân viên.
      </p>
    </div>
  </section>

  <section class="w-full bg-[#660000] pt-50 pb-40 px-4 text-white text-center">
    <!-- TITLE -->
    <h2
      class="font-banque text-3xl md:text-5xl font-extrabold tracking-wide mb-16"
    >
      THAM GIA VÀO ĐỘI NGŨ
    </h2>

    <!-- DESCRIPTION -->
    <p
      class="max-w-3xl mx-auto text-base md:text-xl leading-relaxed opacity-90 mb-16"
    >
      Nếu bạn yêu thích lĩnh vực bất động sản, mong muốn phát triển bản thân và
      đóng góp cho cộng đồng, hãy gửi hồ sơ về Trần Gia Holding ngay hôm nay.
      <br />Chúng tôi trân trọng mọi cơ hội được hợp tác với bạn.
    </p>

    <!-- BUTTON -->
    <button
      class="cursor-pointer font-semibold text-sm md:text-base px-6 py-2 text-white uppercase tracking-wider rounded-sm flex md:inline-flex justify-center items-center gap-2 mx-auto md:mx-0 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] w-full md:w-auto"
    >
      LOREM ISM DOLOR →
    </button>
  </section>
</template>

<script setup>
import Layouts from "../../../layouts/client.vue";

defineOptions({
  layout: Layouts,
});

const jobs = [
  {
    title: "CHUYÊN VIÊN KINH DOANH BẤT ĐỘNG SẢN",
    desc: "Tìm Kiếm Khách Hàng, Tư Vấn Sản Phẩm, Chăm Sóc...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
  },
  {
    title: "NHÂN VIÊN TÀI CHÍNH - KẾ TOÁN",
    desc: "Mô Tả: Chuẩn Bị Hồ Sơ Tài Chính, Lập Báo Cáo...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
  },
  {
    title: "NHÂN VIÊN CHĂM SÓC KHÁCH HÀNG",
    desc: "Mô Tả: Hỗ Trợ, Giải Đáp Thắc Mắc Và Đảm Bảo...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
  },
  {
    title: "QUẢN LÝ DỰ ÁN XÂY DỰNG",
    desc: "Mô Tả: Quản Lý Tiến Độ, Chất Lượng Các Dự Án...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
  },
];
</script>

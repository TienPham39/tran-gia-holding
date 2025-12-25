<template>
  <section class="w-full bg-[#660000] pt-16 md:pt-24 pb-36 md:pb-30">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 px-4">
      <!-- LEFT CONTENT -->
      <div class="text-white text-center md:text-left">
        <!-- Title -->
        <h2 class="font-banque text-3xl md:text-6xl font-extrabold leading-tight mb-4 md:mb-7 tracking-wide">
          TUYỂN<br class="hidden md:block" /> DỤNG
        </h2>

        <!-- Description -->
        <p class="text-justify text-base p-4 md:p-0 md:text-lg leading-relaxed mb-4 md:mb-6 opacity-90">
          "Khám phá các cơ hội nghề nghiệp cùng Trần Gia Holding, nơi bạn có thể
          phát triển bản thân và góp phần xây dựng cộng đồng công ty thịnh
          vượng."
        </p>

        <p class="text-justify text-sm md:text-base leading-relaxed p-4 md:p-0 mb-10 md:mb-16 opacity-90">
          Trần Gia Holding hiện đang tìm kiếm các ứng viên tiềm năng cho nhiều
          vị trí hấp dẫn trong lĩnh vực bất động sản, quản lý dự án và chăm sóc
          khách hàng. Chúng tôi quan tâm đến những cá nhân năng động, sáng tạo
          và có tinh thần trách nhiệm cao.
        </p>

        <!-- Button -->
        <ButtonEffect class="flex justify-center uppercase items-center" @click="scrollToJobs">
          xem tất cả
          <DoubleRightOutlined style="font-size: 20px" />
        </ButtonEffect>
      </div>

      <!-- RIGHT IMAGES -->
      <div class="relative flex items-end justify-center md:justify-end mt-12 md:mt-0">
        <!-- Shadow -->
        <img src="/images/homepage/career-shadow.png"
          class="absolute bottom-[-72px] md:bottom-[-96px] left-1/2 -translate-x-1/2 w-[250px] md:w-[480px] opacity-80 pointer-events-none invert brightness-90" />

        <!-- Building -->
        <img src="/images/homepage/career-bg.png" class="w-[260px] md:w-[500px] object-contain relative z-10" />

        <!-- Girl -->
        <img src="/images/homepage/career-girl.png"
          class="absolute bottom-[-68px] md:bottom-[-90px] left-[28%] md:left-[22%] w-[60px] md:w-[100px] z-20" />

        <!-- Men -->
        <img src="/images/homepage/career-men.png"
          class="absolute bottom-[-68px] md:bottom-[-90px] right-[28%] md:right-[20%] w-[90px] md:w-[150px] z-20" />
      </div>
    </div>
  </section>

  <section ref="jobListSection" class="w-full py-16 md:pt-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 md:px-2">
      <!-- TITLE -->
      <h2 class="font-banque text-center text-xl md:text-5xl font-extrabold text-[#7A0000] tracking-wide mb-6 md:mb-12">
        TRẦN GIA HOLDING TUYỂN DỤNG <br class="hidden md:block" />
        CÁC VỊ TRÍ
      </h2>

      <!-- SUBTITLE -->
      <p
        class="font-mont font-semibold text-center text-[#656565] text-sm md:text-[16px] max-w-4xl mx-auto mb-10 md:mb-16 px-3">
        "Tham gia đội ngũ chuyên nghiệp, môi trường làm việc thân thiện, chế độ
        đãi ngộ cạnh tranh."
      </p>

      <!-- JOB LIST -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-14">
        <div v-for="(job, index) in jobs" :key="index"
          class="flex flex-row md:flex-row items-start gap-4 md:p-0 rounded-md md:border-none md:shadow-none">
          <!-- IMAGE -->
          <div
            class="relative w-[80px] h-[80px] md:w-[130px] md:h-[130px] rounded-md overflow-hidden border-t-2 border-t-[#FEFEFE] border-b-[#989898] bg-white">

            <img :src="job.image" alt="job image" class="w-full h-full object-cover object-center" />

            <!-- DATE BOX -->
            <div
              class="absolute top-1 left-1 text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] w-8 h-8 md:w-12 md:h-12 flex flex-col items-center justify-center border-2 border-[#a30000]">
              <p class="text-[10px] md:text-[14px] font-bold leading-[10px]">
                {{ job.date }}
              </p>
              <p class="text-[8px] md:text-[12px] font-bold">
                {{ job.month }}
              </p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between flex-1">
            <div class="min-h-[90px] md:min-h-[100px]">
              <h3 class="font-bold text-sm md:text-lg text-black leading-snug">
                {{ job.title }}
              </h3>

              <p class="text-gray-700 text-xs mt-1 line-clamp-2 md:text-sm">
                {{ job.desc }}
              </p>

              <p class="text-[#B40000] font-semibold mt-1 text-xs md:text-sm">
                Lương: {{ job.salary }}
              </p>
            </div>

            <!-- LOCATION + BUTTON -->
            <div class="flex items-center justify-between">
              <p class="text-gray-500 text-xs md:text-sm">{{ job.location }}</p>

              <button
                class="cursor-pointer text-xs md:text-sm uppercase bg-[#9B1C1C] text-white px-3 py-1.5 rounded-sm border border-transparent transition-all duration-200 hover:bg-transparent hover:border-[#9B1C1C] hover:text-[#9B1C1C]">
                Gửi hồ sơ >>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="relative w-full overflow-hidden bg-white pb-10">
    <!-- MOUNTAIN + LOGO -->
    <div class="relative w-full flex justify-center">
      <!-- Mountain -->
      <img src="/images/homepage/career-mountain.png"
        class="w-full max-w-full h-[400px] md:h-full object-cover md:object-contain" alt="Mountain" />

      <!-- Logo overlay -->
      <img src="/images/homepage/career-logo.png"
        class="absolute top-[10px] md:top-[100px] w-[140px] md:w-[400px] object-contain" alt="Trần Gia Holding Logo" />
    </div>

    <!-- GRADIENT OVERLAY -->
    <div
      class="absolute bottom-0 left-0 w-full h-[380px] md:h-[540px] bg-gradient-to-t from-[#660000] via-[#660000] to-[#66000000] z-20">
    </div>

    <!-- TEXT CONTENT -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 md:px-2 mt-[-90px] md:mt-[-180px]">
      <h2
        class="font-banque text-white text-3xl md:text-6xl font-extrabold mb-4 md:mb-16 tracking-wide text-center md:text-left">
        VỀ TRẦN GIA
      </h2>

      <p class="font-gotham text-white text-base md:text-3xl leading-relaxed tracking-wide text-justify mb-4 md:mb-5">
        <span class="font-extrabold">Trần Gia Holding</span> là đơn vị hàng đầu
        trong lĩnh vực bất động sản và quản lý dự án tại Đà Lạt, luôn hướng tới
        giá trị bền vững và sự phát triển cộng đồng.
      </p>

      <p class="font-gotham text-white text-base md:text-3xl leading-relaxed tracking-wide text-justify opacity-90">
        Chúng tôi không ngừng đổi mới, xây dựng môi trường làm việc chuyên
        nghiệp, chia sẻ thành công cùng nhân viên.
      </p>
    </div>
  </section>

  <section class="relative w-full min-h-[550px] md:min-h-[960px] bg-[#660000] bg-cover bg-center bg-no-repeat"
    style="background-image: url('/images/homepage/career-nhaga.png')">
    <!-- LỚP PHỦ PNG -->
    <div class="absolute inset-0 pointer-events-none z-20">
      <img src="/images/homepage/career-overlay.png" class="w-full h-full object-cover" alt="overlay" />
    </div>

    <!-- CONTENT WRAPPER -->
    <div class="relative z-[999] max-w-[1300px] mx-auto px-4 md:px-8 py-16 md:py-30 flex justify-center md:justify-end">
      <div class="bg-white text-[#660000] w-full max-w-[360px] md:max-w-[580px] rounded-xl shadow-xl p-6 md:p-12">
        <!-- TITLE -->
        <h2 class="text-center font-banque text-2xl md:text-5xl font-extrabold leading-tight mb-4 md:mb-6">
          THAM GIA VÀO<br />ĐỘI NGŨ
        </h2>

        <!-- DESCRIPTION -->
        <p class="text-gray-700 text-sm md:text-xl leading-relaxed mb-6 md:mb-8 text-justify">
          Nếu bạn yêu thích lĩnh vực bất động sản, mong muốn phát triển bản thân
          và đóng góp cho cộng đồng, hãy gửi hồ sơ về Trần Gia Holding ngay hôm
          nay.
          <br />Chúng tôi trân trọng mọi cơ hội được hợp tác với bạn.
        </p>

        <!-- INPUT -->
        <input ref="emailInput" v-model="form.email" type="email" required placeholder="EMAIL" class="w-full border-2 border-[#660000] px-3 md:px-4 py-2 md:py-3 mb-6
        text-gray-700 focus:outline-none focus:border-[#660000]
          placeholder:font-bold text-sm md:text-base" />

        <!-- BUTTON -->
        <button @click="submitRecruitment" :disabled="isSubmitting"
          class="cursor-pointer w-[200px] md:w-[240px] mx-auto block bg-[#9B1C1C] hover:bg-[#7b0000] text-white font-semibold py-2 md:py-3 transition uppercase tracking-wide text-sm md:text-base">
          THAM GIA NGAY >>
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { message } from "ant-design-vue";
import Layouts from "../../../layouts/client.vue";

const form = ref({
  category_code: "recruitment",
  email: "",
  message: "Ứng viên gửi hồ sơ ứng tuyển",
});

const isSubmitting = ref(false);
const jobListSection = ref(null);
const emailInput = ref(null);

defineOptions({
  layout: Layouts,
});

const scrollToJobs = () => {
  if (!jobListSection.value) return;

  jobListSection.value.scrollIntoView({
    behavior: "smooth",
    block: "start",
  });
};

const jobs = [
  {
    title: "CHUYÊN VIÊN KINH DOANH BẤT ĐỘNG SẢN",
    desc: "Tìm Kiếm Khách Hàng, Tư Vấn Sản Phẩm, Chăm Sóc...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
    image: "/images/career/career-1.png",
  },
  {
    title: "NHÂN VIÊN TÀI CHÍNH - KẾ TOÁN",
    desc: "Mô Tả: Chuẩn Bị Hồ Sơ Tài Chính, Lập Báo Cáo...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
    image: "/images/career/career-3.png",
  },
  {
    title: "NHÂN VIÊN CHĂM SÓC KHÁCH HÀNG",
    desc: "Mô Tả: Hỗ Trợ, Giải Đáp Thắc Mắc Và Đảm Bảo...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
    image: "/images/career/career-2.png",
  },
  {
    title: "QUẢN LÝ DỰ ÁN XÂY DỰNG",
    desc: "Mô Tả: Quản Lý Tiến Độ, Chất Lượng Các Dự Án...",
    salary: "Thỏa Thuận",
    location: "Đà Lạt",
    date: "18",
    month: "TH10",
    image: "/images/career/career-4.png",
  },
];

const validateEmail = () => {
  if (!emailInput.value) return;

  const input = emailInput.value;

  if (input.validity.valueMissing) {
    input.setCustomValidity("Vui lòng nhập email");
  } else if (input.validity.typeMismatch) {
    input.setCustomValidity("Email không hợp lệ");
  } else {
    input.setCustomValidity("");
  }
};

const submitRecruitment = async () => {
  if (isSubmitting.value) return;

  validateEmail();

  if (!emailInput.value.checkValidity()) {
    emailInput.value.reportValidity();
    return;
  }

  isSubmitting.value = true;

  try {
    await axios.post("/contacts", form.value);

    message.success("Đã gửi thông tin ứng tuyển thành công!");

    form.value.email = "";
  } catch (error) {
    console.error(error);
    message.error("Gửi thất bại, vui lòng thử lại!");
  } finally {
    isSubmitting.value = false;
  }
};

</script>

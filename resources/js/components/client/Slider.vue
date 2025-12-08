<template>
  <div class="w-full bg-white">
    <!-- Hero Section -->
    <section
      class="relative flex justify-center items-center bg-[url('/images/Banner.png?v=1')] bg-cover bg-center w-full h-[300px] md:h-[500px] lg:h-[694px]"
    >
      <!-- Lớp phủ đỏ -->
      <div class="absolute inset-0 bg-[#660000]/75"></div>

      <!-- Nội dung -->
      <div
        class="relative z-10 text-center flex flex-col items-center max-w-[597px] px-4"
      >
        <h1
          class="mb-6 font-banque font-bold uppercase text-white tracking-[0.28px] leading-tight text-[20px] md:text-[40px] lg:text-[40px]"
        >
          KHỞI TÂM VƯƠN TẦM
        </h1>

        <button
          class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png?v=1')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
        >
          đăng ký tư vấn →
        </button>
      </div>
    </section>

    <!-- Carousel Section -->
    <section class="bg-white py-12">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Carousel Container -->
        <div class="flex flex-col md:flex-row items-stretch gap-8">
          <!-- Left Arrow -->
          <button
            @click="prevSlide"
            aria-label="Slide trước"
            class="hidden md:flex items-center justify-center h-[708px] w-12 transition-transform duration-200 hover:scale-110 cursor-pointer"
          >
            <img
              src="/images/leftarrow.png"
              alt="Mũi tên trái"
              class="w-8 h-20 opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </button>

          <!-- Main Content -->
          <div
            class="flex-1 flex flex-col md:flex-row gap-8 items-center md:items-start"
          >
            <!-- Image -->
            <div class="shrink-0 relative flex justify-center">
              <img
                :src="currentSlide.image"
                :alt="currentSlide.title"
                class="cursor-pointer object-cover shadow-lg transition-opacity duration-500 rounded-[7px]"
                :class="{
                  'w-[384px] h-[536px]': screenSize === 'mobile',
                  'w-[280px] h-[471px]': screenSize === 'tablet',
                  'w-[422px] h-[708px]': screenSize === 'desktop',
                }"
              />
            </div>

            <!-- Content -->
            <div class="flex flex-col flex-1 text-center md:text-left">
              <!-- Title -->
              <div class="mt-6 md:mt-10 mb-12">
                <h2
                  class="font-banque font-bold tracking-wider whitespace-nowrap text-[#770400]"
                  :style="{
                    fontSize:
                      screenSize === 'mobile'
                        ? '30px'
                        : screenSize === 'tablet'
                        ? '36px'
                        : '40px',
                  }"
                >
                  {{ currentSlide.title }}
                </h2>
              </div>

              <!-- Description -->
              <div class="space-y-3 mb-6 font-gotham font-extrabold">
                <p
                  class="text-gray-600 leading-relaxed text-base sm:text-xl text-justify whitespace-pre-line"
                >
                  {{ currentSlide.description }}
                </p>
              </div>

              <!-- Buttons -->
              <div
                class="grid grid-cols-2 gap-4 justify-center md:justify-start"
              >
                <button
                  v-for="(btn, idx) in currentSlide.buttons"
                  :key="idx"
                  class="py-3 px-6 font-semibold rounded-[7px] border-2 border-[#720000] transition-all duration-300 cursor-pointer"
                  :style="{
                    backgroundColor: hover === idx ? '#720000' : 'transparent',
                    color: hover === idx ? '#fff' : '#720000',
                    borderColor: '#720000',
                  }"
                  @mouseover="hover = idx"
                  @mouseleave="hover = null"
                >
                  {{ btn }}
                </button>
              </div>
            </div>
          </div>

          <!-- Right Arrow -->
          <button
            @click="nextSlide"
            aria-label="Slide tiếp"
            class="hidden md:flex items-center justify-center h-[708px] w-12 transition-transform duration-200 hover:scale-110 cursor-pointer"
          >
            <img
              src="/images/rightarrow.png"
              alt="Mũi tên phải"
              class="w-8 h-20 opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";

/* 🔹 Dữ liệu slide */
const slides = ref([
  {
    id: 1,
    title: "GIỚI THIỆU",
    image: "/images/slide1.png",
    description: `
Trần Gia Holding định vị là tập đoàn bất động sản đa ngành uy tín hàng đầu tại Lâm Đồng. Chúng tôi không chỉ cung cấp đất nền, nhà vườn mà còn mang đến giải pháp trọn gói: từ tư vấn pháp lý, đo đạc đến thiết kế thi công.

Với sứ mệnh "Kết nối giá trị đất và người", chúng tôi cam kết sự minh bạch tuyệt đối, bảo chứng an toàn cho dòng tiền và kiến tạo không gian sống xanh bền vững.
`,
    buttons: ["Pháp lý minh bạch 100%", "Hệ sinh thái trọn gói", "Vị trí đắc địa ven Đà Lạt", "Tiềm năng sinh lời bền vững"],
  },
  {
    id: 2,
    title: "TẦM NHÌN",
    image: "/images/slide2.png",
    description:
      "Tầm nhìn của chúng tôi là trở thành công ty bất động sản hàng đầu khu vực, tạo ra những không gian sống và làm việc bền vững, nâng cao chất lượng cuộc sống của cộng đồng và góp phần phát triển kinh tế xã hội.",
  },
  {
    id: 3,
    title: "SỨ MỆNH",
    image: "/images/slide3.png",
    description:
      "Sứ mệnh của chúng tôi là xây dựng những dự án bất động sản có giá trị, mang lại lợi ích cho khách hàng, nhà đầu tư và cộng đồng. Chúng tôi cam kết tuân thủ các tiêu chuẩn đạo đức cao nhất và phát triển bền vững.",
  },
]);

/* 🔹 Trạng thái carousel */
const currentIndex = ref(0);
const currentSlide = computed(() => slides.value[currentIndex.value]);
const hover = ref(null);

/* 🔹 Responsive logic */
const screenSize = ref("desktop");
const updateScreen = () => {
  if (window.innerWidth < 768) screenSize.value = "mobile";
  else if (window.innerWidth < 1024) screenSize.value = "tablet";
  else screenSize.value = "desktop";
};

/* 🔹 Chuyển slide thủ công */
const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % slides.value.length;
};
const prevSlide = () => {
  currentIndex.value =
    (currentIndex.value - 1 + slides.value.length) % slides.value.length;
};

/* 🔹 Điều khiển bằng bàn phím */
const handleKey = (e) => {
  if (e.key === "ArrowRight") nextSlide();
  if (e.key === "ArrowLeft") prevSlide();
};

/* 🔹 Lifecycle */
onMounted(() => {
  updateScreen();
  window.addEventListener("resize", updateScreen);
  window.addEventListener("keydown", handleKey);
});
onBeforeUnmount(() => {
  window.removeEventListener("resize", updateScreen);
  window.removeEventListener("keydown", handleKey);
});
</script>

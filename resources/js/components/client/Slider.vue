<template>
  <div class="w-full bg-white">
    <!-- Hero Section -->
    <section
      class="relative flex justify-center items-center bg-[url('/images/Banner.png?v=1')] bg-cover bg-center w-full h-[300px] md:h-[500px] lg:h-[694px]">
      <!-- Lớp phủ đỏ -->
      <div class="absolute inset-0 bg-[#660000]/75"></div>

      <!-- Nội dung -->
      <div class="relative z-10 text-center flex flex-col items-center max-w-[597px] px-4">
        <h1
          class="mb-6 font-banque font-bold uppercase text-white tracking-[0.28px] leading-tight text-[20px] md:text-[40px] lg:text-[40px]">
          KHỞI TÂM VƯƠN TẦM
        </h1>

        <ButtonEffect class="flex justify-center uppercase items-center" @click="goToContact">
          đăng ký tư vấn
          <ArrowRight :size="20" stroke-width="2.3" />
        </ButtonEffect>
      </div>
    </section>

    <!-- Carousel Section -->
    <section class="bg-white py-12">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Carousel Container -->
        <div class="flex flex-col md:flex-row items-stretch gap-8">
          <!-- Left Arrow -->
          <button @click="prevSlide" aria-label="Slide trước"
            class="hidden md:flex items-center justify-center h-[708px] w-12 transition-transform duration-200 hover:scale-110 cursor-pointer">
            <img src="/images/leftarrow.png" alt="Mũi tên trái"
              class="w-8 h-20 opacity-80 hover:opacity-100 transition-opacity duration-300" />
          </button>

          <!-- Main Content -->
          <div class="flex-1 flex flex-col md:flex-row gap-8 items-center md:items-start">
            <!-- Image -->
            <div class="shrink-0 relative flex justify-center">
              <img :src="currentSlide.image" :alt="currentSlide.title"
                class="cursor-pointer object-cover shadow-lg transition-opacity duration-500 rounded-[7px]" :class="{
                  'w-[384px] h-[536px]': screenSize === 'mobile',
                  'w-[280px] h-[471px]': screenSize === 'tablet',
                  'w-[422px] h-[708px]': screenSize === 'desktop',
                }" />
            </div>

            <!-- Content -->
            <div class="flex flex-col flex-1 text-center md:text-left">
              <!-- Title -->
              <div class="mt-6 md:mt-10 mb-12">
                <h2 class="font-banque font-bold tracking-wider whitespace-nowrap text-[#770400]" :style="{
                  fontSize:
                    screenSize === 'mobile'
                      ? '30px'
                      : screenSize === 'tablet'
                        ? '32px'
                        : '36px',
                }">
                  {{ currentSlide.title }}
                </h2>
              </div>

              <!-- Description -->
              <div class="space-y-3 mb-6 font-mont">
                <p class="text-gray-600 leading-relaxed text-[17px] text-justify whitespace-pre-line">
                  {{ currentSlide.description }}
                </p>
              </div>

              <!-- Buttons -->
              <div class="grid grid-cols-2 gap-4 justify-center md:justify-start">
                <button v-for="(btn, idx) in currentSlide.buttons" :key="idx"
                  class="py-3 px-6 font-semibold rounded-[7px] border-2 border-[#720000] transition-all duration-300 cursor-pointer"
                  :style="{
                    backgroundColor: hover === idx ? '#720000' : 'transparent',
                    color: hover === idx ? '#fff' : '#720000',
                    borderColor: '#720000',
                  }" @mouseover="hover = idx" @mouseleave="hover = null">
                  {{ btn }}
                </button>
              </div>
            </div>
          </div>

          <!-- Right Arrow -->
          <button @click="nextSlide" aria-label="Slide tiếp"
            class="hidden md:flex items-center justify-center h-[708px] w-12 transition-transform duration-200 hover:scale-110 cursor-pointer">
            <img src="/images/rightarrow.png" alt="Mũi tên phải"
              class="w-8 h-20 opacity-80 hover:opacity-100 transition-opacity duration-300" />
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";

const emit = defineEmits(["scroll-to-contact"]);

const goToContact = () => {
  emit("scroll-to-contact");
};

/* 🔹 Dữ liệu slide */
const slides = ref([
  {
    id: 1,
    title: "GIỚI THIỆU",
    image: "/images/gioi-thieu.png",
    description: `
      Trần Gia Holding định vị là tập đoàn bất động sản đa ngành uy tín hàng đầu tại Lâm Đồng. Chúng tôi không chỉ cung cấp đất nền, nhà vườn mà còn mang đến giải pháp trọn gói: từ tư vấn pháp lý, đo đạc đến thiết kế thi công.

      Với sứ mệnh "Kết nối giá trị đất và người", chúng tôi cam kết sự minh bạch tuyệt đối, bảo chứng an toàn cho dòng tiền và kiến tạo không gian sống xanh bền vững.
      `,
    buttons: ["Pháp lý minh bạch 100%", "Hệ sinh thái trọn gói", "Vị trí đắc địa ven Đà Lạt", "Tiềm năng sinh lời bền vững"],
  },
  {
    id: 2,
    title: "TẦM NHÌN",
    image: "/images/tam-nhin.png",
    description: `
      Trần Gia Holding hướng đến trở thành một trong những thương hiệu bất động sản uy tín và có tầm ảnh hưởng lớn tại Đà Lạt, tiên phong trong việc phát triển các sản phẩm đất nền, nhà ở và dự án nghỉ dưỡng mang giá trị bền vững cho khách hàng và cộng đồng. Chúng tôi đặt mục tiêu xây dựng một hệ sinh thái bất động sản đáng tin cậy, nơi mọi sản phẩm đều được định hình bởi sự minh bạch, chất lượng và tôn trọng tuyệt đối đối với vẻ đẹp thiên nhiên vốn có của cao nguyên.

      Trong tương lai, Trần Gia Holding nỗ lực trở thành lựa chọn đầu tiên của khách hàng khi tìm kiếm cơ hội an cư và đầu tư tại Đà Lạt; đồng thời trở thành đơn vị tiên phong trong việc kiến tạo những không gian sống hài hòa giữa con người – thiên nhiên – kiến trúc. Với khát vọng phát triển bền vững, chúng tôi mong muốn góp phần định hình diện mạo đô thị Đà Lạt theo hướng hiện đại nhưng vẫn giữ được bản sắc đặc trưng, trở thành một doanh nghiệp phát triển cùng cộng đồng và để lại dấu ấn tích cực qua từng dự án và từng giá trị mà chúng tôi mang đến.
      `,
  },
  {
    id: 3,
    title: "SỨ MỆNH",
    image: "/images/su-menh.png",
    description: `
      Với khách hàng:
      Cung cấp các sản phẩm bất động sản minh bạch pháp lý, giá trị thật – chất lượng thật, cùng dịch vụ tư vấn và đồng hành tận tâm như người nhà.

      Với đối tác:
      Xây dựng hệ sinh thái hợp tác bền vững, công bằng và hiệu quả, cùng nhau mang đến thị trường những dự án chất lượng.

      Với nhân sự:
      Tạo môi trường làm việc chuyên nghiệp, văn minh, nơi mỗi cá nhân được phát triển, ghi nhận và truyền cảm hứng để cống hiến lâu dài.
      `,
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

<style>
.hover-effect {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(1px);
  padding: 0.5rem 1.75rem;
}

.hover-effect span {
  position: absolute;
  inset: 0;
  pointer-events: none;
}

/* ================= BORDER DỌC ================= */
.hover-effect span::before,
.hover-effect span::after {
  content: "";
  position: absolute;
  width: 3px;
  height: 0%;
  background: #ffffff;
  transition: height 0.8s ease-in-out;
}

.hover-effect span::before {
  left: 0;
  bottom: 0;
}

.hover-effect span::after {
  right: 0;
  top: 0;
}

/* ================= BORDER NGANG – 4 ĐOẠN ================= */

/* TRÊN TRÁI */
.hover-effect::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 4px;
  width: 51%;
  background: linear-gradient(90deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

/* TRÊN PHẢI */
.hover-effect::after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  height: 4px;
  width: 50%;
  background: linear-gradient(90deg, #4d080c, #ffffff);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

/* DƯỚI TRÁI */
.hover-effect .bottom-left {
  position: absolute;
  bottom: 0;
  height: 4px;
  width: 51%;
  content: "";
  background: linear-gradient(90deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect .bottom-right {
  position: absolute;
  bottom: 0;
  height: 4px;
  width: 50%;
  content: "";
  background: linear-gradient(270deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}


/* DƯỚI TRÁI */
.hover-effect .bottom-left {
  left: 0;
  transform-origin: left;
}

/* DƯỚI PHẢI */
.hover-effect .bottom-right {
  right: 0;
  transform-origin: right;
}

/* ================= HOVER ================= */
.hover-effect:hover span::before,
.hover-effect:hover span::after {
  height: 100%;
  /* Hai line dọc chạy trước */
}

.hover-effect:hover::before,
.hover-effect:hover::after,
.hover-effect:hover .bottom-left,
.hover-effect:hover .bottom-right {
  transform: scaleX(1);
  /* 4 đoạn ngang chạy từ mép → giữa */
}
</style>

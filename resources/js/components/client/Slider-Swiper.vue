<template>
  <section class="relative bg-[#660000] overflow-hidden">
    <!-- BG Map -->
    <div
      class="absolute inset-0 bg-[url('/images/homepage/bg-map.png')] bg-bottom bg-cover opacity-60 mix-blend-multiply pointer-events-none"
    ></div>

    <div
      class="relative max-w-8xl mx-auto px-7 flex items-center justify-center gap-0"
    >
      <!-- Arrow Left -->
      <button
        @click="prev"
        class="ml-6 hidden md:flex items-center justify-center h-[500px] cursor-pointer hover:scale-110 transition"
      >
        <img
          src="/images/homepage/news-left-arrow.png"
          class="w-6 opacity-100 hover:opacity-150"
        />
      </button>

      <!-- SWIPER -->
      <swiper
        @swiper="onSwiper"
        ref="swiperRef"
        :effect="'coverflow'"
        :slidesPerView="'auto'"
        :grabCursor="true"
        :centeredSlides="true"
        :loop="slides.length > 2"
        :initialSlide="0"
        :watchSlidesProgress="true"
        :coverflowEffect="coverflow"
        :loopedSlides="slides.length"
        :loopAdditionalSlides="0"
        :loopFillGroupWithBlank="false"
        :rewind="false"
        :modules="modules"
        class="projectSwiper w-full md:w-[77%]"
      >
        <swiper-slide
          v-for="(item, index) in computedSlides"
          :key="index"
          class="slide-box"
          :style="{
            backgroundImage: item.image ? `url('${item.image}')` : 'none',
            backgroundColor: item.image
              ? 'transparent'
              : 'rgba(255,255,255,0.25)',
            height: '480px'
          }"
        >
          <div
            class="flex flex-col items-start text-white px-12 font-banque cursor-pointer h-full relative"
          >
            <h1
              class="text-[30px] font-bold tracking-wide relative after:content-[''] after:block after:w-14 after:h-0.5 after:bg-white after:mr-auto after:mt-2 after:mb-6 ml-4 mt-16"
            >
              {{ item.title }}
            </h1>

            <p
              class="text-[13px] leading-[1.4] opacity-90 uppercase font-mont font-semibold ml-4"
            >
              {{ item.description }}
            </p>

            <div class="w-[260px] h-[56px] bg-white/60 rounded-md absolute left-8 bottom-4"></div>
          </div>
        </swiper-slide>
      </swiper>

      <!-- Arrow Right -->
      <button
        @click="next"
        class="mr-6 hidden md:flex items-center justify-center h-[500px] cursor-pointer hover:scale-110 transition"
      >
        <img
          src="/images/homepage/news-right-arrow.png"
          class="w-6 opacity-100 hover:opacity-150"
        />
      </button>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/effect-coverflow";
import { EffectCoverflow } from "swiper/modules";

const props = defineProps({
  slides: { type: Array, required: true },
});

const modules = [EffectCoverflow];
const swiperRef = ref(null);
const swiperInstance = ref(null);

const coverflow = {
  rotate: 34,
  stretch: -20,
  depth: 120,
  modifier: 1,
  slideShadows: false,
};

const computedSlides = computed(() => {
  if (!props.slides || props.slides.length === 0) return [];

  // Không nhân bản slides - Swiper sẽ tự xử lý loop effect khi cần
  // Việc nhân bản thủ công gây ra hiển thị trùng lặp không mong muốn
  return props.slides;
});

const onSwiper = (swiper) => {
  swiperInstance.value = swiper;

  const safeIndex = Math.min(props.slides.length - 1, 2);

  setTimeout(() => {
    if (props.slides.length > 2) {
      swiper.slideTo(safeIndex, 0);
    }
  }, 50);
};

const next = () => swiperInstance.value?.slideNext();
const prev = () => swiperInstance.value?.slidePrev();
</script>

<style scoped>
.projectSwiper {
  padding-top: 40px;
  padding-bottom: 100px;
}

.slide-box {
  width: 320px;
  height: 480px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.4s;
  background-size: cover;
  background-position: center;
}
</style>

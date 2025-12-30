<template>
  <section class="w-full pt-14 relative bg-[#480000]">
    <div class="max-w-[1400px] mx-auto relative px-6">
      <!-- CUSTOM ARROWS -->
      <div class="absolute left-0 top-1/2 -translate-y-1/2 z-30 cursor-pointer" @click="swiper.slidePrev()">
        <img src="/images/homepage/news-left-arrow.png"
          class="ml-2 w-[10px] md:w-[20px] opacity-70 hover:opacity-100 transition" />
      </div>

      <div class="absolute right-0 top-1/2 -translate-y-1/2 z-30 cursor-pointer" @click="swiper.slideNext()">
        <img src="/images/homepage/news-right-arrow.png"
          class="mr-2 w-[10px] md:w-[20px] opacity-70 hover:opacity-100 transition" />
      </div>

      <!-- SWIPER -->
      <Swiper @swiper="onSwiper" :spaceBetween="30" :pagination="{ clickable: true }" :modules="modules"
        class="swiper-banner">
        <SwiperSlide v-for="n in 3" :key="n">
          <!-- CENTER CONTENT -->
          <div class="flex justify-center">
            <div class="relative w-[1200px] rounded-xl overflow-hidden shadow-xl">
              <!-- Background banner -->
              <img src="/images/homepage/community-banner.png" class="w-full h-auto object-cover" />
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
    </div>
  </section>

  <section class="w-full relative">
    <!-- BACKGROUND IMAGE -->
    <div class="relative w-full md:h-[auto] h-[180vh]">
      <img src="/images/homepage/community-bg1.png" class="
        w-full
        h-[150vh] md:h-auto
        object-cover md:opacity-100" />

      <!-- TOP GRADIENT OVERLAY -->
      <div class="absolute inset-x-0 top-0 z-10 pointer-events-none">
        <img src="/images/homepage/community-overlay-top-bg.png"
          class="w-full h-[80vh] md:h-[900px] object-cover pointer-events-none" />
      </div>

      <!-- BOTTOM GRADIENT OVERLAY -->
      <div class="absolute inset-x-0 bottom-0 md:bottom-0 z-30 pointer-events-none">
        <img src="/images/homepage/community-overlay-bottom-bg.png"
          class="w-full h-[100vh] md:h-[800px] object-cover pointer-events-none" />
      </div>

      <!-- ===== TOP CONTENT ===== -->
      <div class="
        relative md:absolute
        bottom-260 md:top-0 inset-x-0 z-30
        mx-auto max-w-[1300px]
        px-6 md:px-20
        pt-16 md:pt-28
        pb-10 md:pb-40
        grid grid-cols-1 md:grid-cols-2
        gap-8 md:gap-16
        
        md:bg-none
      ">
        <!-- LEFT LOGO -->
        <div class="flex justify-center md:justify-start">
          <img src="/images/homepage/footer_logo.png" class="
            hidden md:block
            w-auto h-[340px]
            object-contain
          " />
        </div>

        <!-- RIGHT TEXT -->
        <div class="text-white font-mont">
          <h2 class="
            text-lg md:text-4xl
            font-bold mb-4 md:mb-14
            tracking-wide
            text-center md:text-end
          ">
            TRẦN GIA<br />
            &amp; SỨ MỆNH CỘNG ĐỒNG
          </h2>

          <p class="
            text-[13px] md:text-2xl
            leading-relaxed md:leading-relaxed
            opacity-90
            text-justify
          ">
            LÂM ĐỒNG - NƠI CHÚNG TÔI GẮN KẾT & PHÁT TRIỂN <br />
            Trách nhiệm xã hội là nền tảng của sự bền vững. <br /><br />
            Không chỉ tập trung phát triển kinh doanh, Trần Gia Holding luôn tâm niệm "Nhận từ xã hội, trả lại cho cộng
            đồng". Chúng tôi đồng hành cùng người dân địa phương để xây dựng một Lâm Đồng văn minh, giàu đẹp và nhân ái.
          </p>
        </div>
      </div>

      <!-- ===== BOTTOM CONTENT ===== -->
      <div class="
        relative md:absolute
        bottom-160 md:bottom-0 inset-x-0 z-30
        mx-auto max-w-[1200px]
        px-6 md:px-20
        pt-10 md:pt-20
        pb-16 md:pb-40
        md:bg-none
      ">
        <div class="font-mont text-white">
          <h2
            class="mb-10 font-bold tracking-wide text-white text-xl md:text-4xl text-center md:text-left leading-tight">
            <span class="block md:inline">
              BẢO TỒN THIÊN NHIÊN
            </span>
            <span class="hidden md:inline"> - </span>
            <span class="block md:inline">
              DU LỊCH XANH
            </span>
          </h2>

          <p class="
            text-sm md:text-2xl
            leading-relaxed opacity-90
            text-justify
          ">
            Mỗi dự án của Trần Gia luôn tuân thủ nguyên tắc tôn trọng tự nhiên. Chúng tôi phát triển Trần Gia Green
            Travel với mục tiêu khai thác du lịch bền vững, giữ gìn những đồi thông và hệ sinh thái nguyên bản của vùng
            đất cao nguyên. <br /><br />

            Chương trình "Áo ấm vùng cao" và các hoạt động thiện nguyện thường niên hướng tới trẻ em nghèo và đồng bào
            dân tộc thiểu số. Chúng tôi mong muốn mang lại nụ cười và cơ hội học tập tốt hơn cho thế hệ tương lai.
          </p>
        </div>
      </div>
    </div>
    <div class="
      pb-14
      flex flex-col md:flex-row
      justify-center items-center
      gap-6 md:gap-10
      bg-[#4e0101]
      px-6 md:px-0
    ">
      <img src="/images/holding/Holding3.png" class="w-full md:w-[400px] md:h-[300px] rounded-lg" />
      <img src="/images/holding/Holding4.png" class="w-full md:w-[400px] md:h-[300px] rounded-lg" />
    </div>
  </section>

  <section class="w-full bg-[#4e0101] text-white py-20 px-6 md:px-60 font-mont">
    <h2 class="text-center text-2xl md:text-4xl font-bold tracking-wide mb-20">
      TRẦN GIA GREEN <br>
      HÀNH TRÌNH PHỦ XANH ĐẤT TRỐNG
    </h2>

    <div class="max-w-[1000px] mx-auto text-center md:text-left mb-10">
      <p class="leading-relaxed opacity-90 md:text-2xl text-justify">
        Ngày 28/09/2024 <br> <br>

        Hưởng ứng lời kêu gọi trồng 50 triệu cây xanh của tỉnh Lâm Đồng, cán bộ nhân viên Trần Gia Holding đã ra quân
        trồng mới 5.000 cây thông ba lá tại huyện Lâm Hà. Hoạt động nhằm tái tạo mảng xanh, chống xói mòn và bảo vệ
        nguồn nước cho bà con vùng cao.
      </p>
    </div>

    <!-- IMAGE CENTER -->
    <div class="w-full flex flex-col md:flex-row justify-center mb-16">
      <div class="w-full flex justify-center">
        <img src="/images/homepage/community-kid-1.png" class="w-full max-w-[360px] md:max-w-[500px]" />
      </div>

      <div class="w-full flex justify-center">
        <img src="/images/homepage/community-kid-2.png" class="w-full max-w-[360px] md:max-w-[500px]" />
      </div>
    </div>

    <!-- TWO COLUMN TEXT -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20 max-w-[1000px] mx-auto">
      <div class="space-y-4">
        <h2 class="text-xl md:text-2xl font-extrabold tracking-wide uppercase text-center md:text-left">
          "ÁO ẤM VÙNG CAO" - MÙA ĐÔNG KHÔNG LẠNH
        </h2>

        <p class="text-sm opacity-70 text-center md:text-left">
          Ngày 15/12/2024
        </p>

        <p class="md:text-xl leading-relaxed opacity-90 text-justify">
          Đoàn thiện nguyện Trần Gia đã trao tặng 300 suất quà (áo ấm, chăn bông, nhu yếu phẩm)
          cho các hộ gia đình khó khăn tại xã Đưng K'Nớ (Lạc Dương). Những phần quà nhỏ nhưng
          ấm áp tình người, giúp bà con vững tin vượt qua mùa đông khắc nghiệt.
        </p>
      </div>

      <!-- CỘT PHẢI -->
      <div class="space-y-4">
        <h2 class="text-xl md:text-2xl font-extrabold tracking-wide uppercase text-center md:text-left">
          ĐỒNG HÀNH CÙNG DU LỊCH BỀN VỮNG ĐÀ LẠT
        </h2>

        <p class="text-sm opacity-70 text-center md:text-left">
          Ngày 02/12/2024
        </p>

        <p class="md:text-xl leading-relaxed opacity-90 text-justify">
          Tham gia hội thảo "Du lịch xanh & Phát triển bền vững" cùng UBND TP. Đà Lạt.
          Trần Gia Holding cam kết phát triển các dự án theo mô hình Farmstay bảo tồn:
          không bê tông hóa, giữ nguyên hiện trạng rừng thông và tôn trọng văn hóa bản địa.
        </p>
      </div>
    </div>
  </section>

  <section class="bg-white w-full py-20 px-6 md:px-62 font-mont">
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-12">
      <h2 class="text-3xl md:text-5xl font-extrabold tracking-wide text-[#7A0000] font-banque">
        TIN TỨC
      </h2>

      <a href="/news"
        class="text-xs md:text-base font-semibold text-gray-600 hover:text-[#7A0000] transition whitespace-nowrap">
        XEM TẤT CẢ >>
      </a>
    </div>

    <!-- GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16">
      <div v-for="news in homeNews.data.slice(0, 2)" :key="news.id" class="cursor-pointer"
        @click="$inertia.visit(`/news/${news.slug}`)">
        <!-- IMAGE -->
        <div class="w-full h-[260px] rounded-md shadow bg-cover bg-center"
          :style="{ backgroundImage: `url('${thumbnail(news)}')` }">
          <!-- DATE BADGE -->
          <div
            class="bg-white text-[#a30000] w-14 h-14 m-4 flex flex-col items-center justify-center font-bold border-2 border-[#a30000]">
            <div class="text-sm">
              {{ new Date(news.created_at).getDate() }}
            </div>
            <div class="text-xs">
              TH{{ new Date(news.created_at).getMonth() + 1 }}
            </div>
          </div>
        </div>

        <!-- TITLE -->
        <h3 class="mt-6 text-[#7A0000] font-extrabold text-xl uppercase leading-snug line-clamp-2">
          {{ news.title }}
        </h3>

        <!-- EXCERPT -->
        <p class="mt-4 text-gray-700 leading-relaxed text-sm md:text-base line-clamp-3" v-html="news.excerpt"></p>

        <!-- CTA -->
        <div class="mt-6 text-xs text-end text-gray-500 hover:text-[#7A0000] transition font-semibold tracking-wide">
          XEM CHI TIẾT
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import Layouts from "../../../layouts/client.vue";
import { defineOptions, computed, ref } from "vue";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import { usePage } from "@inertiajs/vue3";

defineOptions({
  layout: Layouts,
});

const modules = [Pagination];
const swiper = ref(null);

const page = usePage();
const homeNews = computed(() => ({
  data: page.props.sharedNews || [],
}));

function onSwiper(s) {
  swiper.value = s;
}

function thumbnail(news) {
  return news.thumbnail_base64 ?? `/storage/${news.thumbnail}`;
}
</script>

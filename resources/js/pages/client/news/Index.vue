<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <!-- BG Map -->
    <SliderSwiper :slides="slides" />

    <div class="flex justify-center gap-4 font-gotham">
      <!-- Nút 1 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        Xem tất cả dự án →
      </button>

      <!-- Nút 2 -->
      <button
        class="cursor-pointer font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        <img src="/images/homepage/phone-icon.png" class="w-6 h-6 opacity-90" />
        Liên hệ ngay
      </button>
    </div>
  </section>

  <NewsList
    title="Thị trường"
    :data="props.thiTruong"
    paginateParam="thiTruongPage"
  />

  <NewsList
    title="Quy hoạch vùng"
    :data="props.quyHoachVung"
    paginateParam="quyHoachVungPage"
  />

  <section
    class="relative w-full md:px-0 pt-20 pb-30 text-black min-h-[750px]"
    style="background-color: #f3f3f3"
  >
    <!-- Decorative BG under everything -->
    <img
      src="/images/homepage/bg-contact.png"
      class="hidden md:block absolute bottom-0 right-[16%] w-[400px] opacity-40 pointer-events-none z-0"
      alt=""
    />

    <img
      src="/images/homepage/bg-contact.png"
      class="hidden md:block absolute bottom-24 right-0 w-[400px] opacity-80 pointer-events-none z-0"
      alt=""
    />

    <NewsList
      title="Trần Gia Holding"
      :data="props.tranGiaHolding"
      paginateParam="tranGiaHoldingPage"
    />
  </section>
</template>

<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { defineOptions } from "vue";
import SliderSwiper from "../../../components/client/Slider-Swiper.vue";
import Pagination from "@/Components/client/Paginate.vue";
import NewsList from "@/Components/client/NewsList.vue";
import Layouts from "../../../layouts/client.vue";

defineOptions({
  layout: Layouts,
});

const props = defineProps({
  thiTruong: Object,
  quyHoachVung: Object,
  tranGiaHolding: Object,
});

function onPaginate({ param, page }) {
  const params = new URLSearchParams(window.location.search);
  params.set(param, page);

  router.visit(`/news?${params.toString()}`, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
  });
}

const slides = ref([
  {
    title: "TRẦN GIA GARDEN HILL",
    description: "Cơ hội đầu tư F0 tốt nhất thị trường Lâm Hà tháng này.",
    image: "/images/products/deo-ta-nung.png",
  },
  {
    title: "TRẦN GIA GARDEN HILL",
    description: "Cơ hội đầu tư F0 tốt nhất thị trường Lâm Hà tháng này.",
    image: "/images/products/rong-bac-thang.png",
  },
  {
    title: "TRẦN GIA GARDEN HILL",
    description: "Cơ hội đầu tư F0 tốt nhất thị trường Lâm Hà tháng này.",
    image: "/images/products/cao-toc-lien-khuong.png",
  },
  {
    title: "TRẦN GIA GARDEN HILL",
    description: "Cơ hội đầu tư F0 tốt nhất thị trường Lâm Hà tháng này.",
    image: "/images/products/tay-nguyen.png",
  },
  {
    title: "TRẦN GIA GARDEN HILL",
    description: "Cơ hội đầu tư F0 tốt nhất thị trường Lâm Hà tháng này.",
    image: "/images/products/ta-dung.png",
  },
]);
</script>

<style>
.pentagon {
  position: relative;
  width: 28px;
  height: 28px;
  margin-bottom: 4px;
  padding-top: 4px;
  background-color: #a30000;
  clip-path: polygon(50% 0%, 100% 35%, 100% 100%, 0% 100%, 0% 35%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 700;
}
</style>

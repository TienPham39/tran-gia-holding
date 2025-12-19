<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <div class="relative">
      <SliderSwiper :slides="highlightProducts" />
    </div>

    <div class="flex justify-center gap-4 font-mont">
      <!-- Nút 1 -->
      <ButtonEffect class="uppercase text-xl flex items-center gap-2" @click="$inertia.visit('/product')">
        <span>Xem tất cả dự án</span>
        <ArrowRight class="w-4 h-4" />
      </ButtonEffect>

      <!-- Nút 2 -->
      <ButtonEffect class="flex justify-center uppercase text-xl">
        <template #icon>
          <img src="/images/homepage/phone-icon.png" class="w-5 h-5 opacity-90" />
        </template>
        Liên hệ ngay
      </ButtonEffect>
    </div>
  </section>

  <section>
    <div class="bg-[#f3f3f3]">
      <NewsList title="Thị trường" :data="props.thiTruong" paginateParam="thiTruongPage" />
    </div>

    <div>
      <NewsList title="Quy hoạch vùng" :data="props.quyHoachVung" paginateParam="quyHoachVungPage" />
    </div>

    <div class="relative w-full md:px-0 pt-20 pb-30 text-black min-h-[750px]" style="background-color: #f3f3f3">
      <img src="/images/homepage/bg-contact.png"
        class="hidden md:block absolute bottom-0 right-[16%] w-[400px] opacity-40 pointer-events-none z-0" alt="" />

      <img src="/images/homepage/bg-contact.png"
        class="hidden md:block absolute bottom-24 right-0 w-[400px] opacity-80 pointer-events-none z-0" alt="" />

      <NewsList title="Trần Gia Holding" :data="props.tranGiaHolding" paginateParam="tranGiaHoldingPage" />
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { defineOptions } from "vue";
import SliderSwiper from "../../../components/client/Product-Swiper.vue";
import Pagination from "@/Components/client/Paginate.vue";
import NewsList from "@/Components/client/NewsList.vue";
import Layouts from "../../../layouts/client.vue";
import BaseButton from "@/components/client/ButtonEffect.vue";

defineOptions({
  layout: Layouts,
});

const page = usePage();

const props = defineProps({
  thiTruong: Object,
  quyHoachVung: Object,
  tranGiaHolding: Object,
  highlightProducts: Object,
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
const highlightProducts = computed(() => {
  return page.props.highlightProducts || [];
});
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

<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <h2 class="uppercase font-bold text-5xl text-center mb-20 font-banque text-white">sản phẩm bđs</h2>
    <!-- Product Card -->
    <div
      class="mb-10 md:max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-6"
    >
      <Card
        v-for="(item, index) in productsSP"
        :key="item.id || index"
        :image="item.image"
        :title="item.title"
        :description="item.description"
        :isHot="item.isHot"
        :isSelling="item.isSelling"
      />
    </div>
    <Pagination
      :currentPage="currentPageSP"
      :totalPages="paginationSP.total_pages"
      :param="'sp'"
      @change="handlePageChange"
    />

    <div class="h-0.5 border border-[#884D4D] w-11/12 mx-auto mt-16"></div>

    <!-- Highlight Projects -->
    <div class="relative">
      <h2 class="uppercase font-bold text-5xl text-center mt-20 font-banque text-white mb-8">
        dự án nổi bật
      </h2>

      <SliderSwiper :slides="highlightProducts" />
      <button
        class="cursor-pointer absolute left-1/2 -translate-x-1/2 bottom-16 font-semibold text-base px-8 py-2 text-white uppercase tracking-wider rounded-sm flex items-center gap-2 transition bg-[url('/images/homepage/bg-button.png')] bg-cover bg-center border-l border-r border-white hover:brightness-110 hover:scale-[1.03] hover:border-white"
      >
        <img src="/images/homepage/phone-icon.png" class="w-6 h-6 opacity-90" />
        Liên hệ ngay
      </button>
    </div>
  </section>
  <section class="relative bg-white py-20 overflow-hidden">
    <h2 class="uppercase text-[#660000] font-bold text-5xl text-center mb-20">
      BĐS ký gửi
    </h2>

    <div
      class="mb-10 md:max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-6"
    >
      <Card
        v-for="(item, index) in productsKG"
        :key="item.id || index"
        :image="item.image"
        :title="item.title"
        :description="item.description"
        :isHot="item.isHot"
        :isSelling="item.isSelling"
        :theme="'dark'"
      />
    </div>
    <Pagination
      :currentPage="currentPageKG"
      :totalPages="paginationKG.total_pages"
      :theme="'dark'"
      :param="'kg'"
      @change="handlePageChange"
    />
  </section>
</template>

<script setup>
import { ref, computed, defineOptions } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import Layouts from "../../../layouts/client.vue";
import Card from "@/Components/client/Card.vue";
import Pagination from "@/Components/client/Paginate.vue";
import SliderSwiper from "../../../components/client/Slider-Swiper.vue";

defineOptions({
  layout: Layouts,
});

const page = usePage();

// Separate pagination states for each section
const currentPageSP = ref(page.props.paginationSP?.current_page || 1);
const currentPageKG = ref(page.props.paginationKG?.current_page || 1);

// Get products from Inertia props
const productsSP = computed(() => {
  return page.props.productsSP || [];
});

const productsKG = computed(() => {
  return page.props.productsKG || [];
});

const highlightProducts = computed(() => {
  return page.props.highlightProducts || [];
});

const paginationSP = computed(() => {
  return page.props.paginationSP || { current_page: 1, total_pages: 1, per_page: 9 };
});

const paginationKG = computed(() => {
  return page.props.paginationKG || { current_page: 1, total_pages: 1, per_page: 9 };
});

// Handle pagination change
function handlePageChange(event) {
  const { param, page } = event;
  
  if (param === 'sp') {
    currentPageSP.value = page;
    router.get('/product', { sp_page: page }, {
      preserveState: true,
      preserveScroll: true,
      only: ['productsSP', 'paginationSP'],
    });
  } else if (param === 'kg') {
    currentPageKG.value = page;
    router.get('/product', { kg_page: page }, {
      preserveState: true,
      preserveScroll: true,
      only: ['productsKG', 'paginationKG'],
    });
  }
}
</script>

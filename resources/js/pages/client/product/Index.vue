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
        :status="item.status"
        :productId="item.id"
      />
    </div>
    <Pagination
      :isRedBg="true"
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
      <ButtonEffect class="absolute left-1/2 -translate-x-1/2 bottom-8 flex justify-center uppercase items-center text-xl font-mont">
        <template #icon>
          <img src="/images/homepage/phone-icon.png" class="w-5 h-5 opacity-90" />
        </template>
        Liên hệ ngay
      </ButtonEffect>
    </div>
  </section>
  <section class="relative bg-white py-20 overflow-hidden">
    <h2 class="uppercase text-[#660000] font-bold text-5xl text-center mb-20 font-banque">
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
        :status="item.status"
        :theme="'dark'"
        :productId="item.id"
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
import SliderSwiper from "../../../components/client/Product-Swiper.vue";

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

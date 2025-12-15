<template>
  <!-- SECTION: GIỚI THIỆU DỰ ÁN / HIGHLIGHT BANNER -->
  <section class="w-full overflow-hidden bg-[#00310F]">
    <!-- TOP NAV BUTTONS + LOGO -->
    <div class="flex items-center justify-center gap-4 py-8">
      <div class="flex gap-5 font-gotham">
        <button
          @click="router.visit('/')"
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          TRANG CHỦ
        </button>
        <button
          @click="scrollToSection('intro-section')"
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          GIỚI THIỆU DỰ ÁN
        </button>
      </div>

      <div>
        <img
          src="/images/homepage/tran-gia-village.png"
          class="h-18 w-auto object-contain mx-2"
          alt="Trần Gia Village Logo"
        />
      </div>

      <div class="flex gap-5 font-gotham">
        <button
          @click="scrollToSection('gallery-section')"
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          HÌNH ẢNH DỰ ÁN
        </button>
        <button
          @click="scrollToSection('floor-plan-section')"
          class="w-[200px] py-2 bg-[#3E7643] text-white text-sm font-semibold rounded-sm hover:brightness-110 transition"
        >
          SƠ ĐỒ PHÂN LÔ
        </button>
      </div>
    </div>

    <!-- Background Image -->
    <div class="w-full h-[450px] md:h-full overflow-hidden">
      <img
        src="/images/homepage/bg-detailpage.png"
        class="w-full h-full object-cover object-center"
        alt="Project Banner"
      />
    </div>

    <!-- Box Info -->
    <div
      class="absolute left-1/2 -translate-x-1/2 bottom-[-40px] md:bottom-[-190px] flex gap-4 md:gap-8 z-30"
    >
      <div
        v-for="(item, index) in infoBoxes"
        :key="index"
        class="w-[120px] md:w-[160px] h-[150px] md:h-[170px] flex flex-col justify-center items-center rounded-md font-extrabold uppercase text-[#00330D] text-sm md:text-2xl shadow-[0_8px_25px_rgba(0,0,0,0.35)] bg-[url('/images/homepage/linear-bg.png')] bg-cover bg-center"
      >
        <div
          class="flex flex-col items-center justify-center text-center"
        >
          <span>{{ item.line1 }}</span>
          <span>{{ item.line2 }}</span>
        </div>
      </div>
    </div>
  </section>

  <section id="intro-section" class="relative w-full bg-[#00310F] pt-32 font-gotham">
    <!-- Title -->
    <h2
      class="font-gotham text-2xl md:text-4xl font-extrabold text-center text-white uppercase tracking-wide my-16"
    >
      {{ product?.solugon || '' }}
    </h2>

    <!-- Description -->
    <p
      class="text-2xl text-center text-white mx-auto leading-relaxed px-96 mb-20"
    >
      {{ product?.short_description || '' }}
    </p>

    <div
      id="gallery-section"
      class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-6 mb-20"
    >
      <!-- Gallery Images - Dynamic based on product.gallery -->
      <!-- COLUMN 1 -->
      <div v-if="galleryImages.length > 0" class="flex flex-col gap-6">
        <div v-if="galleryImages[0]" class="h-[410px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[350px]">
            <img :src="galleryImages[0].image_url" :alt="`Gallery image ${galleryImages[0].id || 1}`" class="w-full h-full object-cover" />
          </div>
          <div class="h-[60px] bg-[#D9D9D9]"></div>
        </div>
        <div v-if="galleryImages[3]" class="h-[250px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[190px]">
            <img :src="galleryImages[3].image_url" :alt="`Gallery image ${galleryImages[3].id || 4}`" class="w-full h-full object-cover" />
          </div>
          <div class="h-[70px] bg-[#D9D9D9]"></div>
        </div>
      </div>

      <!-- COLUMN 2 -->
      <div v-if="galleryImages.length > 1" class="flex flex-col gap-6">
        <div v-if="galleryImages[1]" class="h-[330px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[270px]">
            <img :src="galleryImages[1].image_url" :alt="`Gallery image ${galleryImages[1].id || 2}`" class="w-full h-full object-cover" />
          </div>
          <div class="h-[60px] bg-[#D9D9D9]"></div>
        </div>
        <div v-if="galleryImages[4]" class="h-[330px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[270px]">
            <img :src="galleryImages[4].image_url" :alt="`Gallery image ${galleryImages[4].id || 5}`" class="w-full h-full object-cover" />
          </div>
          <div class="h-[60px] bg-[#D9D9D9]"></div>
        </div>
      </div>

      <!-- COLUMN 3 -->
      <div v-if="galleryImages.length > 2" class="flex flex-col gap-6">
        <div v-if="galleryImages[2]" class="h-[260px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[190px]">
            <img :src="galleryImages[2].image_url" :alt="`Gallery image ${galleryImages[2].id || 3}`" class="w-full h-full object-cover" />
          </div>
          <div class="h-[70px] bg-[#D9D9D9]"></div>
        </div>
        <div v-if="galleryImages[5]" class="h-[400px] bg-[#AAAAAA] overflow-hidden shadow-lg">
          <div class="h-[340px]">
            <img :src="galleryImages[5].image_url" :alt="`Gallery image ${galleryImages[5].id || 6}`" class="w-full h-full object-cover" />
          </div>
          <div class="h-[70px] bg-[#D9D9D9]"></div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="galleryPagination.total_pages > 1" class="relative z-30 mb-20">
      <Pagination
        :currentPage="galleryPagination.current_page"
        :totalPages="galleryPagination.total_pages"
        :theme="'light'"
        param="gallery"
        @change="handlePageChange"
      />
    </div>

    <div class="border-1 w-[1200px] border-[#757575] mx-auto"></div>
  </section>

  <section id="floor-plan-section" class="relative w-full bg-[#00310F]">
    <div class="relative w-full h-[400px] flex items-center justify-center">
      <div
        class="absolute inset-0 bg-[url('/images/homepage/bg-map.png')] bg-cover bg-center opacity-90 mix-blend-multiply"
      ></div>

      <!-- Text -->
      <h2
        class="relative font-gotham uppercase text-[#B8FFC5] text-5xl md:text-5xl font-extrabold tracking-wide text-center"
      >
        SƠ ĐỒ PHÂN LÔ
      </h2>
    </div>

    <!-- Map Image Wrapper -->
    <div class="relative max-w-[1100px] mx-auto">
      <div v-for="(floorPlan, index) in floorPlans" :key="floorPlan.id || index" class="w-full overflow-hidden mt-6 md:mt-8 mb-6 md:mb-8 rounded-lg md:rounded-xl">
        <img
          :src="floorPlan.image_url"
          :alt="`Sơ đồ phân lô ${index + 1}`"
          class="w-full h-auto object-contain rounded-lg md:rounded-xl"
        />
      </div>
    </div>
  </section>
  <Contact />
  <Footer />
</template>

<script setup>
import { computed } from "vue";
import Pagination from "@/Components/client/Paginate.vue";
import Contact from "../../../components/client/Contact.vue";
import Footer from "../../../components/client/Footer.vue";
import { router, usePage } from "@inertiajs/vue3";

const page = usePage();
const product = computed(() => page.props.product || {});

// Info boxes from highlights - hiển thị tất cả highlights có
const infoBoxes = computed(() => {
  return product.value.highlights || [];
});

// Gallery images
const galleryImages = computed(() => {
  return product.value.gallery || [];
});

// Gallery pagination
const galleryPagination = computed(() => {
  return product.value.gallery_pagination || {
    current_page: 1,
    total_pages: 1,
    per_page: 6,
    total: 0,
  };
});

// Floor plan images
const floorPlans = computed(() => {
  return product.value.floor_plans || [];
});

// Smooth scroll to section
function scrollToSection(sectionId) {
  const element = document.getElementById(sectionId);
  if (element) {
    element.scrollIntoView({ behavior: "smooth", block: "start" });
  }
}

// Handle pagination change
function handlePageChange(event) {
  const { page: newPage } = event;
  const routeUrl = typeof route !== 'undefined' 
    ? route('client.product.show', product.value.id)
    : `/product/detail/${product.value.id}`;
  
  router.visit(`${routeUrl}?page=${newPage}`, {
    preserveState: false,
    preserveScroll: false,
    only: ['product'],
    onSuccess: () => {
      // Scroll to gallery section after page loads
      setTimeout(() => {
        scrollToSection('gallery-section');
      }, 100);
    },
  });
}
</script>

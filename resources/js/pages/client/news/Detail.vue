<template>
  <section class="w-full pt-16 pb-14 bg-[#660000] text-white">
    <!-- BREADCRUMB -->
    <div class="max-w-7xl mx-auto px-4 flex items-center gap-2 text-white mb-4 md:mb-6">
      <a href="/" class="flex items-center">
        <img src="/images/home-btn.png" alt="Home" class="w-5 h-5 md:w-6 md:h-6" />
      </a>

      <span class="text-lg md:text-xl">›</span>

      <a href="/news" class="uppercase text-[11px] md:text-sm tracking-wide hover:text-gray-200">
        TIN TỨC
      </a>

      <span class="text-lg md:text-xl">›</span>

      <span class="uppercase text-[11px] md:text-sm tracking-wide text-gray-300">
        {{ news.category?.name || "TIN TỨC" }}
      </span>
    </div>

    <!-- Border top -->
    <div class="mx-auto w-full md:w-[1300px] h-[1px] bg-[#DEDEDE80] mb-6 md:mb-12"></div>

    <!-- Title -->
    <div class="text-center mb-8 md:mb-10 px-4 md:px-40">
      <h1 class="font-banque font-bold uppercase leading-tight text-[20px] md:text-[36px] tracking-wide">
        {{ news.title }}
      </h1>

      <div class="w-16 md:w-20 h-[3px] bg-[#D4D4D4] mx-auto mt-3 md:mt-4"></div>
    </div>

    <!-- Content top section -->
    <div class="max-w-7xl mx-auto px-4 md:px-0 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-20 items-start">

      <!-- Thumbnail on MOBILE (IMAGE FIRST) -->
      <div class="block md:hidden w-full">
        <img :src="getThumbnail(news)" alt="Thumbnail" class="w-full h-auto object-cover rounded" />
      </div>

      <!-- Left text -->
      <div class="font-mont text-[15px] md:text-lg leading-relaxed space-y-4 md:space-y-6">
        <div v-html="news.excerpt"></div>
      </div>

      <!-- Thumbnail on DESKTOP -->
      <div class="hidden md:block w-full">
        <img :src="getThumbnail(news)" alt="Thumbnail" class="w-[500px] h-auto object-cover rounded" />
      </div>
    </div>
  </section>

  <section class="w-full py-20 font-mont">
    <div class="max-w-6xl mx-auto px-4">
      <div v-html="news.content" class="prose prose-lg max-w-none news-content"></div>

      <!-- GALLERY nếu có -->
      <div class="max-w-6xl mx-auto mt-16 pb-10 font-mont" v-if="galleryImages && galleryImages.length > 0">
        <NewsGallery :images="galleryImages" />
      </div>
    </div>
  </section>

  <!-- SECTION: TIN TỨC KHÁC -->
  <section class="w-full pb-16 md:pb-20 font-mont">
    <div class="max-w-6xl mx-auto px-4">

      <div class="w-full md:w-[80%] border-t border-[#D9D9D9] mb-6 md:mb-8 mx-auto"></div>

      <div class="flex items-center justify-between mb-6 md:mb-10">
        <h2 class="font-banque font-bold text-[18px] md:text-[22px] text-[#2e2e2e] uppercase tracking-wide">
          TIN TỨC KHÁC
        </h2>

        <a href="/news" class="text-[12px] md:text-[14px] font-semibold uppercase text-[#7f7f7f] hover:text-[#9B1C1C]">
          Xem tất cả >>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">

        <div v-for="(item, idx) in relatedNews" :key="idx" @click="$inertia.visit(`/news/${item.slug}`)"
          class="cursor-pointer group">
          <!-- Thumbnail -->
          <div class="w-full h-[180px] md:h-[220px] bg-[#e3e3e3] rounded-md overflow-hidden shadow-sm mb-3">
            <img :src="getThumbnail(item)"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
          </div>

          <!-- Title -->
          <h3
            class="text-[#9B1C1C] font-bold text-[16px] md:text-[18px] uppercase leading-snug mb-1 md:mb-2 group-hover:underline">
            {{ item.title }}
          </h3>

          <!-- Excerpt -->
          <p class="text-[#4a4a4a] text-[14px] md:text-[15px] leading-relaxed line-clamp-3" v-html="item.excerpt"></p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from "vue";
import Layouts from "../../../layouts/client.vue";
import NewsGallery from "../../../components/client/NewsGallery.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
  layout: Layouts,
});

const page = usePage();

const news = page.props.news;
const relatedNews = page.props.relatedNews;

// Đảm bảo gallery_images luôn là array
const galleryImages = computed(() => {
  if (!news.gallery_base64) return [];
  if (Array.isArray(news.gallery_base64)) {
    return news.gallery_base64.filter(img => img && img.trim() !== '');
  }
  // Nếu vẫn là string (fallback)
  return news.gallery_base64.split(',').map(img => img.trim()).filter(img => img !== '');
});
function getThumbnail(news) {
  // Nếu backend trả về base64
  if (news.thumbnail_base64) {
    return news.thumbnail_base64;
  }

  // Nếu backend lưu file vào storage
  if (news.thumbnail) {
    return `${news.thumbnail}`;
  }

  // fallback khi không có ảnh
  return "/images/default-news.png";
}

function getGalleryImage(img) {
  // img có thể là base64 hoặc path trong storage
  if (img.startsWith("data:image")) {
    return img;
  }

  return `${img}`;
}
</script>

<style>
.news-content table {
  width: 100% !important;
  border-collapse: collapse;
}

@media (max-width: 768px) {
  .news-content table,
  .news-content table tbody,
  .news-content table tr {
    display: block !important;
    width: 100% !important;
  }

  .news-content table td,
  .news-content table th {
    display: block !important;
    width: 100% !important;
    padding: 0 !important;
    border: none !important;
  }

  .news-content table img {
    width: 100% !important;
    height: auto !important;
    object-fit: cover;
    margin-bottom: 12px;
  }
}
</style>

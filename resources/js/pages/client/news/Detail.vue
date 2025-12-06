<template>
  <section class="w-full pt-20 pb-16 bg-[#660000] text-white">
    <!-- BREADCRUMB -->
    <div class="max-w-7xl mx-auto px-4 flex items-center gap-2 text-white mb-6">
      <a href="/" class="flex items-center">
        <img src="/images/home-btn.png" alt="Home" class="w-6 h-6" />
      </a>

      <span class="text-xl">›</span>

      <a
        href="/news"
        class="uppercase text-sm tracking-wide hover:text-gray-200"
      >
        TIN TỨC
      </a>

      <span class="text-xl">›</span>

      <span class="uppercase text-sm tracking-wide text-gray-300">
        {{ news.category?.name || "TIN TỨC" }}
      </span>
    </div>

    <!-- Border top -->
    <div class="mx-auto w-[1300px] h-[1px] bg-[#DEDEDE80] mb-12"></div>

    <!-- Title -->
    <div class="text-center mb-10 px-40">
      <h1
        class="font-banque font-bold uppercase leading-tight text-[24px] md:text-[36px] tracking-wide"
      >
        {{ news.title }}
      </h1>

      <!-- Small center line -->
      <div class="w-20 h-[3px] bg-[#D4D4D4] mx-auto mt-4"></div>
    </div>

    <!-- Content -->
    <div
      class="max-w-7xl ml-50 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-20 items-start"
    >
      <!-- Left text -->
      <div class="font-mont text-lg text-justify leading-relaxed space-y-6">
        <div v-html="news.excerpt"></div>
      </div>

      <!-- Right image -->
      <div class="w-full">
        <img
          :src="getThumbnail(news)"
          alt="Thumbnail"
          class="w-[500px] h-auto object-cover rounded"
        />
      </div>
    </div>

    <!-- <div class="w-full h-[2px] bg-[#E5E5E5] mx-auto mt-6"></div> -->
  </section>

  <section class="w-full py-20 font-mont">
    <div class="max-w-6xl mx-auto px-4">
      <div v-html="news.content" class="prose prose-lg max-w-none"></div>

      <!-- GALLERY nếu có -->
      <div
        class="max-w-6xl mx-auto mt-16 pb-10 font-mont"
        v-if="news.gallery_base64?.length"
      >
        <NewsGallery :images="news.gallery_base64" />
      </div>
    </div>
  </section>

  <!-- SECTION: TIN TỨC KHÁC -->
  <section class="w-full pb-20 font-mont">
    <div class="max-w-6xl mx-auto px-4">
      <!-- Top line -->
      <div class="w-[80%] border-t border-[#D9D9D9] mb-8 mx-auto"></div>

      <!-- Header row -->
      <div class="flex items-center justify-between mb-10">
        <h2
          class="font-banque font-bold text-[20px] md:text-[22px] text-[#2e2e2e] uppercase tracking-wide"
        >
          TIN TỨC KHÁC
        </h2>

        <a
          href="/news"
          class="text-[14px] font-semibold uppercase text-[#7f7f7f] hover:text-[#9B1C1C] cursor-pointer"
        >
          Xem tất cả >>
        </a>
      </div>

      <!-- NEWS LIST -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10">
        <div
          v-for="(item, idx) in relatedNews"
          :key="idx"
          @click="$inertia.visit(`/news/${item.slug}`)"
          class="cursor-pointer font-mont group"
        >
          <!-- Thumbnail -->
          <div
            class="w-full h-[220px] bg-[#e3e3e3] border border-[#d8d8d8] rounded-md overflow-hidden shadow-sm mb-4"
          >
            <img
              :src="getThumbnail(item)"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
            />
          </div>

          <!-- Title -->
          <h3
            class="text-[#9B1C1C] font-bold text-[18px] uppercase leading-snug mb-2 group-hover:underline"
          >
            {{ item.title }}
          </h3>

          <!-- Excerpt (giới hạn 3 dòng) -->
          <p
            class="text-[#4a4a4a] text-[15px] leading-relaxed line-clamp-3"
            v-html="item.excerpt"
          ></p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import Layouts from "../../../layouts/client.vue";
import NewsGallery from "../../../components/client/NewsGallery.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
  layout: Layouts,
});

const page = usePage();

const news = page.props.news;
const relatedNews = page.props.relatedNews;
console.log(news);
function getThumbnail(news) {
  // Nếu backend trả về base64
  if (news.thumbnail_base64) {
    return news.thumbnail_base64;
  }

  // Nếu backend lưu file vào storage
  if (news.thumbnail) {
    return `/storage/${news.thumbnail}`;
  }

  // fallback khi không có ảnh
  return "/images/default-news.png";
}

function getGalleryImage(img) {
  // img có thể là base64 hoặc path trong storage
  if (img.startsWith("data:image")) {
    return img;
  }

  return `/storage/${img}`;
}
</script>

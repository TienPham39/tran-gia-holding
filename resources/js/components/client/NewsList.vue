<template>
  <section class="w-full py-20 text-black" :class="bgClass">
    <!-- TITLE -->
    <div class="mx-26 flex items-center gap-0 mb-10">
      <img src="/images/homepage/bg-thi-truong-1.png" class="h-[58px]" />
      <div
        class="h-[58px] w-[800px] flex items-center bg-cover pl-6"
        style="background-image: url('/images/homepage/bg-thi-truong-2.png')"
      >
        <h2
          class="text-[28px] font-banque font-extrabold uppercase tracking-wider text-white"
        >
          {{ title }}
        </h2>
      </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="mx-26 grid grid-cols-1 lg:grid-cols-3 gap-12">
      <!-- LEFT LIST -->
      <div class="lg:col-span-2 flex flex-col gap-10">
        <div
          v-for="news in data.data"
          :key="news.id"
          class="flex gap-6 border-b border-gray-200 pb-8 cursor-pointer"
          @click="$inertia.visit(`/news/${news.slug}`)"
        >
          <!-- IMAGE -->
          <div
            class="w-[300px] h-[150px] bg-gray-200 rounded-md bg-cover bg-center border-t-2 border-t-[#FEFEFE] border-b-2 border-b-[#989898] transition-transform duration-300 ease-out hover:scale-105"
            :style="{ backgroundImage: `url('${thumbnail(news)}')` }"
          >
            <div
              class="text-[#a30000] hover:text-white bg-white hover:bg-[#a30000] w-12 h-12 mt-3 ml-3 flex flex-col items-center justify-center border-2 border-[#a30000]"
            >
              <p class="text-[14px] font-bold leading-tight">
                {{ new Date(news.created_at).getDate() }}
              </p>
              <p class="text-[12px] font-bold">
                TH{{ new Date(news.created_at).getMonth() + 1 }}
              </p>
            </div>
          </div>

          <!-- CONTENT -->
          <div class="flex flex-col justify-between font-mont w-92">
            <div>
              <h3 class="font-bold text-[18px] uppercase mb-2 line-clamp-2">
                {{ news.title }}
              </h3>
              <p
                class="text-gray-700 text-[14px] leading-relaxed mb-4 line-clamp-2"
                v-html="news.excerpt"
              ></p>
            </div>

            <a
              class="underline uppercase text-[13px] text-[#545454] hover:text-[#a30000] ml-auto"
            >
              Xem chi tiết
            </a>
          </div>
        </div>

        <!-- PAGINATION -->
        <div class="relative z-30">
          <Pagination
            :currentPage="data.current_page"
            :totalPages="data.last_page"
            :param="paginateParam"
            theme="dark"
            @change="onPaginate"
          />
        </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <div class="flex flex-col gap-6 font-mont">
        <div class="h-[30px] md:text-xl font-bold uppercase">Tin mới nhất</div>

        <div
          v-for="news in data.data.slice(0, 3)"
          :key="news.id"
          class="flex gap-3 cursor-pointer"
          @click="$inertia.visit(`/news/${news.slug}`)"
        >
          <div
            class="w-[100px] h-[100px] bg-cover bg-center rounded overflow-hidden"
            :style="{ backgroundImage: `url('${thumbnail(news)}')` }"
          ></div>

          <div class="flex flex-col justify-between w-40">
            <h4
              class="font-bold text-[#034F00] uppercase text-[15px] line-clamp-2"
            >
              {{ news.title }}
            </h4>
            <p class="text-[13px] text-gray-700">
              {{ new Date(news.created_at).toLocaleDateString("vi-VN") }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import Pagination from "@/Components/client/Paginate.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  title: String,
  data: Object,
  paginateParam: String,
  bgClass: { type: String, default: "" },
});

// Nếu bạn dùng Base64 thay vì file storage
function thumbnail(news) {
  return news.thumbnail_base64 ?? `/storage/${news.thumbnail}`;
}
console.log(props.data)
function onPaginate({ param, page }) {
  const params = new URLSearchParams(window.location.search);
  params.set(param, page);

  router.visit(`/news?${params.toString()}`, {
    preserveScroll: true,
    preserveState: true,
    replace: true,
  });
}
</script>

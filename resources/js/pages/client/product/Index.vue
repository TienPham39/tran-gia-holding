<template>
  <section class="relative bg-[#660000] py-20 overflow-hidden">
    <h2 class="uppercase font-bold text-5xl text-center mb-20">sản phẩm bđs</h2>
    <!-- Product Card -->
    <div
      class="md:max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-6"
    >
      <Card
        v-for="(item, index) in products"
        :key="index"
        :image="item.image"
        :title="item.title"
        :description="item.description"
        :isHot="true"
        :isSelling="true"
      />
    </div>
    <Pagination
      :currentPage="page"
      :totalPages="7"
      @update:page="page = $event"
    />

    <div class="h-0.5 border border-[#884D4D] w-11/12 mx-auto mt-16"></div>

    <!-- Highlight Projects -->
    <div class="relative">
      <h2 class="uppercase font-bold text-5xl text-center mt-20">
        dự án nổi bật
      </h2>

      <SliderSwiper :slides="slides" />
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
      class="md:max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-6"
    >
      <Card
        v-for="(item, index) in products"
        :key="index"
        :image="item.image"
        :title="item.title"
        :description="item.description"
        :isHot="true"
        :isSelling="true"
        :theme="'dark'"
      />
    </div>
    <Pagination
      :currentPage="page"
      :totalPages="7"
      :theme="'dark'"
      @update:page="page = $event"
    />
  </section>
</template>

<script setup>
import { ref, defineOptions } from "vue";
import Layouts from "../../../layouts/client.vue";
import Card from "@/Components/client/Card.vue";
import Pagination from "@/Components/client/Paginate.vue";
import SliderSwiper from "../../../components/client/Slider-Swiper.vue";

defineOptions({
  layout: Layouts,
});
const page = ref(1);

const baseProduct = {
  image: "/images/sample1.jpg",
  title: "Lorem ipsum dolor sit amet, cons",
  description:
    "excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum",
};

const slides = ref([
  {
    title: "DỰ ÁN 1",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 2",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 3",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 4",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 5",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
  {
    title: "DỰ ÁN 6",
    description: "consectetur adipiscing elit, sed do eiusmod tempor",
    image: "/images/slide1.png",
  },
]);

const products = Array.from({ length: 9 }, () => baseProduct);
</script>

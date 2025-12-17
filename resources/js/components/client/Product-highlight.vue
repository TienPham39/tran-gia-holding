<template>
  <section class="w-full bg-[#003505] flex justify-center items-start py-24">
    <div class="max-w-[1500px] w-full px-6 sm:px-6 lg:px-20 mx-auto">
      <header class="text-center mb-8">
        <h1
          class="font-utm font-bold uppercase text-white tracking-[0.28px] pb-6 text-[26px] leading-[42px] md:text-4xl md:leading-[34px] sm:text-[210px] sm:leading-[28px]">
          SẢN PHẨM NỔI BẬT
        </h1>

        <nav class="mt-2">
          <ul
            class="grid grid-cols-4 gap-x-6 gap-y-3 justify-center items-center text-center text-white/90 font-mont uppercase text-[10px] sm:flex sm:gap-x-4 sm:text-sm pb-7">
            <li v-for="(link, idx) in links" :key="idx" class="px-2"
              :class="{ 'border-r border-white/30 pr-3': idx % 4 !== 3 }">
              <span class="block">{{ link }}</span>
            </li>
          </ul>
        </nav>
      </header>

      <!-- Mobile: horizontal carousel -->
      <div class="sm:hidden font-mont">
        <div ref="carousel" class="mobile-carousel overflow-x-auto py-2 flex touch-pan-x scroll-snap-x snap-mandatory"
          @scroll="onScroll" :style="{ gap: mobileGap + 'px' }">
          <div v-for="(p, idx) in products" :key="`mobile-${idx}`" class="group shrink-0 cursor-pointer"
            :style="{ width: mobileCardWidth + 'px', scrollSnapAlign: 'start' }"
            @click="handleProductClick(p)">
            <div class="relative rounded-lg overflow-hidden shadow-lg bg-white/5">
              <img :src="p.image" alt="project image" class="w-full h-[340px] object-cover block rounded-b-lg" />
              <div
                class="absolute inset-1 bg-linear-to-b from-black/80 via-black/40 to-transparent z-1 pointer-events-none rounded-t-lg">
              </div>
              <div class="absolute inset-0 z-2">
                <div
                  class="absolute left-4 top-4 bg-black/40 backdrop-blur-sm py-1 px-3 rounded-sm text-sm font-utm font-bold text-white tracking-[0.5px] border border-transparent">
                  {{ p.name }}
                </div>
                <div class="absolute right-4 top-3 flex items-center gap-2">
                  <img :src="p.logo" alt="logo"
                    class="w-16 h-16 object-contain brightness-125 contrast-125 drop-shadow-md" />
                </div>
                <div
                  class="absolute right-4 bottom-12 font-utm font-bold uppercase text-white/90 tracking-[0.28px] flex items-end gap-1">
                  <span class="text-[42px] leading-none">{{
                    p.area ? p.area.replace(/[^0-9]/g, "") : ""
                    }}</span><span class="text-[20px] leading-none">{{ p.area ? p.area.replace(/[0-9]/g, "") : "" }}</span>
                </div>
              </div>
            </div>
            <div class="mt-4 bg-transparent px-2">
              <div class="h-4 mb-3 bg-[#C3C3C3] w-3/4 rounded"></div>
              <div class="h-4 mb-3 bg-[#C3C3C3] w-5/6 rounded"></div>
              <div class="h-3 mb-2 bg-[#C3C3C3] w-4/5 rounded"></div>
            </div>
          </div>
        </div>

        <div class="mt-6 flex justify-center items-center gap-3">
          <button v-for="(p, idx) in products" :key="`dot-${idx}`" :class="[
            'w-2.5 h-2.5 rounded-full',
            {
              'bg-white': activeIndex === idx,
              'bg-white/40': activeIndex !== idx,
            },
          ]" @click="scrollToIndex(idx)" aria-label="Go to slide"></button>
        </div>
      </div>

      <!-- Desktop/tablet: 3-column grid -->
      <div class="hidden sm:grid gap-10 grid-cols-3">
        <div v-for="(p, idx) in products" :key="idx" class="group cursor-pointer transition-all duration-500"
          @click="handleProductClick(p)">

          <!-- IMAGE CARD -->
          <div class="relative rounded-lg overflow-hidden bg-white/5 shadow-lg
           transition-all duration-700 group-hover:shadow-2xl group-hover:-translate-y-1">

            <div class="relative w-full h-[300px] rounded-b-lg overflow-hidden">

              <!-- BORDER TOP -->
              <div class="absolute top-0 left-0 w-full h-[10px]
                  bg-gradient-to-b from-[#727272] to-transparent z-20
                  transition-opacity duration-500 group-hover:opacity-80"></div>

              <!-- BORDER BOTTOM -->
              <div class="absolute bottom-0 left-0 w-full h-[10px]
                  bg-gradient-to-t from-[#727272] to-transparent z-20
                  transition-opacity duration-500 group-hover:opacity-80"></div>

              <!-- IMAGE -->
              <img :src="p.image" alt="project image" class="w-full h-full object-cover block
               transition-transform duration-700 group-hover:scale-105" />
            </div>

            <!-- Content inside image -->
            <div class="absolute inset-0 z-2">

              <!-- Name tag -->
              <div class="absolute left-4 top-4 py-1.5 px-4 rounded-sm text-sm font-utm font-bold text-white tracking-[0.5px]
               transition-all duration-500 group-hover:brightness-110 group-hover:scale-105" style="
            background-image: url('/images/products-border.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        ">
                {{ p.label }}
              </div>

              <!-- Area -->
              <div class="absolute right-4 bottom-4 font-utm font-bold uppercase text-white/90 tracking-[0.28px]
               flex items-end gap-1 transition-all duration-500
               group-hover:text-white group-hover:scale-105">

                <!-- Number -->
                <span class="text-[45px] leading-none">
                  {{ p.area.replace(/[^0-9]/g, "") }}
                </span>

                <!-- Unit -->
                <span class="text-[20px] leading-none">
                  {{ p.area.replace(/[0-9]/g, "") }}
                </span>
              </div>
            </div>
          </div>

          <!-- TEXT CONTENT BELOW IMAGE -->
          <div class="font-mont mt-4 text-white px-1 transition-all duration-500 group-hover:translate-x-1">
            <!-- Title -->
            <h3 class="font-mont font-bold text-xl uppercase mb-4 h-[28px] flex items-center">
              {{ p.name }}
            </h3>

            <!-- Short description -->
            <p class="text-lg text-justify text-white/90 mt-2 leading-relaxed">
              {{ p.description && p.description.length > 100 ? p.description.slice(0, 100) + '...' : p.description }}
            </p>

            <div class="mt-3 mb-2 flex justify-end">
              <p 
                class="text-[12px] tracking-wide uppercase text-white/80 hover:text-white cursor-pointer"
                @click.stop="handleProductClick(p)"
              >
                Xem chi tiết
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const page = usePage();

// Links từ product types (từ backend)
const links = computed(() => {
  return page.props.productTypeLinks || [];
});

// Products từ backend
const products = computed(() => {
  return page.props.highlightProducts || [];
});

// Carousel state for mobile
const carousel = ref(null);
const activeIndex = ref(0);
const cardWidth = 300; // fallback
const mobileCardWidth = ref(cardWidth);
const gutter = 8; // smaller side gutter so cards become wider
const mobileGap = ref(28); // larger gap between slides

function updateCarouselPadding() {
  if (!carousel.value) return;
  const containerWidth = carousel.value.clientWidth;
  // compute card width so only one card fits visible area (hide adjacent)
  // card width such that there is gutter on both sides (only one visible)
  const targetCardWidth = Math.max(
    320,
    Math.round(containerWidth - gutter * 2)
  );
  mobileCardWidth.value = targetCardWidth;
  // set fixed side gutter so the card is centered with gutter left/right
  carousel.value.style.paddingLeft = gutter + "px";
  carousel.value.style.paddingRight = gutter + "px";
}

function scrollToIndex(i) {
  if (!carousel.value) return;
  const children = carousel.value.children;
  const child = children[i];
  if (child) {
    // center the child: child's center - container's padding
    const containerPadding = parseInt(
      getComputedStyle(carousel.value).paddingLeft || "0",
      10
    );
    const target = child.offsetLeft - containerPadding;
    carousel.value.scrollTo({ left: target, behavior: "smooth" });
    activeIndex.value = i;
  }
}

let scrollTimer = null;
function onScroll() {
  if (!carousel.value) return;
  // debounce
  if (scrollTimer) clearTimeout(scrollTimer);
  scrollTimer = setTimeout(() => {
    const scrollLeft = carousel.value.scrollLeft;
    const children = Array.from(carousel.value.children);
    let closest = 0;
    let minDiff = Infinity;
    children.forEach((c, idx) => {
      const diff = Math.abs(c.offsetLeft - scrollLeft);
      if (diff < minDiff) {
        minDiff = diff;
        closest = idx;
      }
    });
    activeIndex.value = closest;
  }, 80);
}

function handleProductClick(product) {
  if (product.id) {
    const routeUrl = typeof route !== 'undefined'
      ? route('client.product.show', product.id)
      : `/product/detail/${product.id}`;
    router.visit(routeUrl);
  }
}

onMounted(() => {
  // ensure activeIndex and padding are correct on mount
  updateCarouselPadding();
  if (carousel.value) onScroll();
  window.addEventListener("resize", () => {
    updateCarouselPadding();
    // refresh active index after resize
    if (carousel.value) onScroll();
  });
});
</script>

<style scoped>
/* Fonts note: import your real fonts globally (UTM Banque, SVN-Gotham) */
.font-utm {
  font-family: "UTM Banque", sans-serif;
}

.font-svn {
  font-family: "SVN-Gotham", sans-serif;
}

/* Slight card shadow to match design */
.shadow-lg {
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
}

p {
  margin: 0;
}
</style>

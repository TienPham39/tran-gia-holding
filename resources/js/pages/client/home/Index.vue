<template class="font-banque">
  <!-- Slider component -->
  <Slider />

  <!-- Product highlight component -->
  <ProductHighlight />

  <!-- Homepage Videos component -->
  <HomepageVideos />

  <!-- Contact component -->
  <Contact />
</template>

<script setup>
import ProductHighlight from "../../../components/client/Product-highlight.vue";
import Slider from "../../../components/client/Slider.vue";
import HomepageVideos from "../../../components/client/homepage-videos.vue";
import Contact from "../../../components/client/Contact.vue";
import Layouts from "../../../layouts/client.vue"
import { defineOptions } from 'vue';

defineOptions({
  layout: Layouts,
});
</script>

<style></style>

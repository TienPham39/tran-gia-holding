<template class="font-banque">
  <!-- Slider component -->
  <Slider @scroll-to-contact="scrollToContact"/>

  <!-- Product highlight component -->
  <ProductHighlight />

  <!-- Homepage Videos component -->
  <HomepageVideos />

  <!-- Contact component -->
  <div ref="contactRef">
    <Contact />
  </div>
</template>

<script setup>
import ProductHighlight from "../../../components/client/Product-highlight.vue";
import Slider from "../../../components/client/Slider.vue";
import HomepageVideos from "../../../components/client/Homepage-Videos.vue";
import Contact from "../../../components/client/Contact.vue";
import Layouts from "../../../layouts/client.vue"
import { ref, defineOptions } from 'vue';

defineOptions({
  layout: Layouts,
});

const contactRef = ref(null);

const scrollToContact = () => {
  contactRef.value?.scrollIntoView({
    behavior: "smooth",
    block: "start",
  });
};
</script>

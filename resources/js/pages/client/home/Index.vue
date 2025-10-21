<template>
  <!-- Navbar component -->
  <Navbar />

  <!-- Slider component -->
  <Slider />

  <!-- Product highlight component -->
  <ProductHighlight />

  <!-- Homepage Videos component -->
  <HomepageVideos />

  <!-- Contact component -->
  <Contact />

  <!-- Footer component -->
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import Navbar from "../../../components/client/Navbar.vue";
import Slider from "../../../components/client/Slider.vue";
import Contact from "../../../components/client/Contact.vue";
import Footer from "../../../components/client/Footer.vue";
import HomepageVideos from "../../../components/client/homepage-videos.vue";
import ProductHighlight from "../../../components/client/Product-highlight.vue";
</script>

<style></style>

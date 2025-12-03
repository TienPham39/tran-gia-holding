<template>
  <div class="min-h-screen flex flex-col">
    <Navbar />

    <main class="flex-1">
      <slot />
    </main>

    <Footer />

    <FloatingContact />
  </div>
</template>

<script setup>
import Navbar from "../components/client/Navbar.vue";
import Footer from "../components/client/Footer.vue";
import FloatingContact from "../components/client/FloatingContact.vue";
</script>

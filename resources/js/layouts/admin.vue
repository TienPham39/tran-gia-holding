<template>
  <div class="drawer lg:drawer-open font-sans">
    <input type="checkbox" id="my-drawer" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
      <Navbar @toggle-drawer="toggleDrawer" />
      <main class="flex-1 p-4 bg-base">
        <router-view />
      </main>
    </div>
    <Sidebar />
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/SideBar.vue";

// chỉ giữ drawer toggle
const toggleDrawer = () => {
  const drawer = document.getElementById("my-drawer");
  if (drawer) {
    drawer.checked = !drawer.checked;
  }
};
</script>

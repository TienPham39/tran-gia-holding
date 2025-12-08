<template>
  <aside class="drawer-side bg-white border-r border-gray-200">
    <label
      for="my-drawer"
      aria-label="Close sidebar"
      class="drawer-overlay"
    ></label>

    <nav
      class="menu p-4 w-80 min-h-full text-gray-800"
      aria-label="Main navigation"
    >
      <!-- Logo -->
      <header class="mb-2 flex justify-center p-2">
        <img
          src="/images/homepage/career-logo.png"
          alt="Logo"
          class="hidden md:block max-h-20 w-auto object-contain"
        />
      </header>

      <!-- Menu items -->
      <ul role="menu">
        <li
          role="none"
          class="p-2"
          v-for="(lin, index) in links"
          :key="index"
        >
          <!-- Nếu không có children thì navigate thẳng -->
          <Link
            v-if="!lin.children"
            :href="lin.to"
            :class="{ 'bg-gray-200 font-semibold': currentUrl === lin.to }"
            class="flex items-center w-full text-left hover:bg-gray-100 text-black"
          >
            <Icon :icon="lin.icon" class="h-5 w-5" />
            <span class="ml-2">{{ lin.name }}</span>
          </Link>

          <!-- Nếu có children thì hiển thị toggle -->
          <button
            v-else
            role="menuitem"
            :aria-expanded="lin.open"
            @click="setActive(index)"
            class="flex items-center w-full text-left hover:bg-gray-100 text-black"
          >
            <Icon :icon="lin.icon" class="h-5 w-5" />
            <span class="ml-2">{{ lin.name }}</span>
            <span class="ml-auto dropdown-icon">
              <Icon
                :icon="lin.open ? 'line-md:chevron-down' : 'line-md:chevron-right'"
              />
            </span>
          </button>

          <!-- Submenu -->
          <ul v-if="lin.children && lin.open">
            <li
              v-for="(child, childIndex) in lin.children"
              :key="childIndex"
            >
              <Link
                :href="child.to"
                class="block py-1 hover:bg-gray-100 text-black"
              >
                {{ child.name }}
              </Link>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { ref } from "vue";
import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const currentUrl = page.url

const links = ref([
  {
    name: "Analytics",
    icon: "mdi:view-dashboard",
    to: "/admin/analytics",
    active: true,
    open: false,
  },
  {
    name: "Giới thiệu",
    icon: "line-md:home",
    active: true,
    open: false,
    children: [
      { name: "DS. Giới thiệu", to: "/admin/introductions" },
      { name: "Tạo thông tin giới thiệu", to: "/admin/introductions/create" },
    ],
  },
  {
    name: "Dự án",
    icon: "icon-park-outline:chart-line",
    active: false,
    open: false,
    children: [
      { name: "DS. Dự án", to: "#" },
      { name: "Tạo dự án mới", to: "#" },
    ],
  },
  {
    name: "Sản Phẩm",
    icon: "tabler:shopping-cart",
    active: false,
    open: false,
    children: [
      { name: "DS. Sản Phẩm", to: "#" },
      { name: "Tạo sản phẩm mới", to: "#" },
    ],
  },
  {
    name: "Sơ đồ phân lô",
    icon: "line-md:document-list",
    active: false,
    open: false,
    children: [
      { name: "DS. Sơ đồ phân lô", to: "#" },
      { name: "Tạo sơ đồ phân lô", to: "#" },
      { name: "Khách hàng ký gửi", to: "#" },
    ],
  },
  {
    name: "Hoạt động cộng đồng",
    icon: "mdi:hand-heart",
    active: false,
    open: false,
    children: [
      { name: "DS. Hoạt động", to: "#" },
      { name: "Tạo hoạt động mới", to: "#" },
    ],
  },
  {
    name: "Cơ hội nghề nghiệp",
    icon: "mdi:briefcase-outline",
    active: false,
    open: false,
    children: [
      { name: "DS. Tuyển dụng", to: "#" },
      { name: "DS. Ứng viên", to: "#" },
      { name: "Tạo tin tuyển dụng mới", to: "#" },
    ],
  },
  {
    name: "Tin tức",
    icon: "mdi:newspaper-variant-outline",
    active: false,
    open: false,
    children: [
      { name: "DS. Tin tức", to: "/admin/news" },
      { name: "Tạo tin tức mới", to: "/admin/news/create" },
    ],
  },
  {
    name: "Liên hệ",
    icon: "line-md:email",
    active: false,
    open: false,
    children: [{ name: "DS. Liên hệ", to: "#" }],
  },
  {
    name: "Hệ thống",
    icon: "mdi:cog-outline",
    active: false,
    open: false,
    children: [
      { name: "Người dùng", to: "/admin/users" },
      // { name: "Phân quyền", to: "/admin/roles" },
    ],
  },
]);

const setActive = (index) => {
  if (links.value[index].children) {
    links.value[index].open = !links.value[index].open;
  }

  links.value.forEach((lin, i) => {
    lin.active = i === index;
  });
};
</script>

<template>
  <header
    class="navbar bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm"
  >
    <!-- Drawer toggle -->
    <nav class="flex-none lg:hidden">
      <label @click="$emit('toggle-drawer')" class="btn btn-square btn-ghost">
        <Icon
          icon="line-md:close-to-menu-alt-transition"
          class="inline-block w-5 h-5"
        />
      </label>
    </nav>

    <!-- Search -->
    <section class="flex-1">
      <div class="form-control">
        <input
          type="text"
          placeholder="Search"
          class="input input-bordered w-48 ml-2 md:w-auto"
        />
      </div>
    </section>

    <!-- Actions -->
    <section class="flex gap-6 items-center mr-2">
      <!-- Avatar dropdown -->
      <div class="dropdown dropdown-end" v-if="user">
        <button
          tabindex="0"
          role="button"
          class="btn btn-ghost btn-circle avatar"
        >
          <div class="w-10 rounded-full">
            <img
              :src="user.avatar || '/images/Tommy-Shelby.jpg'"
              :alt="user.name"
            />
          </div>
        </button>

        <!-- Dropdown menu -->
        <ul
          tabindex="0"
          class="mt-5 z-[1] p-2 shadow menu menu-sm dropdown-content bg-white rounded-box w-58 space-y-3 font-semibold text-base"
        >
          <li>
            <RouterLink
              to="/admin/profile"
              class="block hover:text-blue-600 transition"
            >
              Profile
            </RouterLink>
          </li>
          
          <li><a>Settings</a></li>

          <!-- Logout button -->
          <li>
            <button
              class="flex items-center gap-2 text-red-600 hover:text-red-700 disabled:opacity-50"
              :disabled="isLoggingOut"
              @click="handleLogout"
            >
              <template v-if="!isLoggingOut"> Logout </template>
              <template v-else>
                <LoadingOutlined spin />
                <span>Đang đăng xuất...</span>
              </template>
            </button>
          </li>
        </ul>
      </div>
    </section>
  </header>
</template>

<script setup>
defineEmits(["toggle-drawer"]);
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";
import { LoadingOutlined } from "@ant-design/icons-vue";
import api from "../../api";

const router = useRouter();
const isLoggingOut = ref(false);
const user = ref(null);

onMounted(async () => {
  try {
    const res = await api.get("/user");
    user.value = res.data;
  } catch (error) {
    console.log("Không thể get user", error);
  }
});

async function handleLogout() {
  // Chặn Multiple Click
  if (isLoggingOut.value) return;
  isLoggingOut.value = true;

  try {
    await api.post("/logout");
  } catch (error) {
    console.warn("Logout error:", error);
  } finally {
    // Luôn xóa token và reset trạng thái
    localStorage.removeItem("auth_token");
    delete api.defaults.headers.common["Authorization"];
    message.success("Đăng xuất thành công!");
    isLoggingOut.value = false;
    router.push({ name: "Auth" });
  }
}
</script>

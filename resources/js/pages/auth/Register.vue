<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div
      class="w-full max-w-md shadow-2xl border-0 overflow-hidden bg-white rounded-lg"
    >
      <!-- Tab Headers -->
      <div class="flex border-b bg-white">
        <button
          @click="activeTab = 'login'"
          class="flex-1 py-4 text-center font-semibold transition-all duration-300 relative"
          :class="
            activeTab === 'login'
              ? 'text-blue-600'
              : 'text-gray-500 hover:text-gray-700'
          "
        >
          Đăng nhập
          <div
            v-if="activeTab === 'login'"
            class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 transition-all duration-300"
          ></div>
        </button>
        <button
          @click="activeTab = 'register'"
          class="flex-1 py-4 text-center font-semibold transition-all duration-300 relative"
          :class="
            activeTab === 'register'
              ? 'text-blue-600'
              : 'text-gray-500 hover:text-gray-700'
          "
        >
          Đăng ký
          <div
            v-if="activeTab === 'register'"
            class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 transition-all duration-300"
          ></div>
        </button>
      </div>

      <!-- Content -->
      <div class="p-8 bg-white">
        <!-- Login Form -->
        <form
          v-if="activeTab === 'login'"
          class="space-y-5 animate-fadeIn"
          @submit.prevent="handleLoginSubmit"
        >
          <div class="space-y-2">
            <label for="login-email" class="text-sm font-medium text-gray-700"
              >Email</label
            >
            <div class="relative">
              <a-input
                v-model:value="formLoginData.email"
                placeholder="Nhập email"
                class="w-full h-11"
              />
            </div>
            <small v-if="errors.email" class="text-red-600">
              {{ errors.email[0] }}
            </small>
          </div>

          <div class="space-y-2">
            <label
              for="login-password"
              class="text-sm font-medium text-gray-700"
              >Mật khẩu</label
            >
            <div class="relative">
              <a-input-password
                v-model:value="formLoginData.password"
                placeholder="Nhập mật khẩu"
                class="w-full h-11"
              />
            </div>
            <small v-if="errors.password" class="text-red-600">
              {{ errors.password[0] }}
            </small>
          </div>

          <div class="text-right">
            <a
              href="#"
              class="text-sm text-blue-600 hover:text-blue-700 font-medium"
              >Quên mật khẩu?</a
            >
          </div>

          <button
            type="submit"
            class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition-all duration-200"
          >
            Đăng nhập
          </button>

          <!-- Nút Google Login -->
          <div class="mt-4">
            <button
              type="button"
              @click="loginWithGoogle"
              class="w-full h-11 flex items-center justify-center gap-2 border border-gray-300 rounded-md bg-white hover:bg-gray-50 shadow-sm"
            >
              <img src="/images/google_logo.png" alt="Google" class="w-5 h-5" />
              <span class="text-gray-700 font-medium"
                >Đăng nhập bằng Google</span
              >
            </button>
          </div>
        </form>

        <!-- Register Form -->
        <form
          v-else
          class="space-y-5 animate-fadeIn"
          @submit.prevent="handleSubmit()"
        >
          <div class="space-y-2">
            <label
              for="register-username"
              class="text-sm font-medium text-gray-700"
              >Tên tài khoản
            </label>
            <a-input
              v-model:value="formRegisterData.user_name"
              placeholder="Tên tài khoản"
              class="w-full h-11"
            />
            <small v-if="errors.user_name" class="text-red-600">
              {{ errors.user_name[0] }}
            </small>
          </div>

          <div class="space-y-2">
            <label for="register-name" class="text-sm font-medium text-gray-700"
              >Họ & tên</label
            >
            <a-input
              v-model:value="formRegisterData.name"
              placeholder="Họ và tên"
              class="w-full h-11"
            />
            <small v-if="errors.name" class="text-red-600">
              {{ errors.name[0] }}
            </small>
          </div>

          <div class="space-y-2">
            <label
              for="register-email"
              class="text-sm font-medium text-gray-700"
              >Email</label
            >
            <a-input
              v-model:value="formRegisterData.email"
              placeholder="Nhập email"
              class="w-full h-11"
            />
            <small v-if="errors.email" class="text-red-600">
              {{ errors.email[0] }}
            </small>
          </div>

          <div class="space-y-2">
            <label
              for="register-password"
              class="text-sm font-medium text-gray-700"
              >Mật khẩu</label
            >
            <a-input-password
              v-model:value="formRegisterData.password"
              placeholder="Nhập mật khẩu"
              class="w-full h-11"
            />
            <small v-if="errors.password" class="text-red-600">
              {{ errors.password[0] }}
            </small>
          </div>

          <div class="space-y-2">
            <label
              for="register-confirm"
              class="text-sm font-medium text-gray-700"
              >Xác nhận mật khẩu</label
            >
            <a-input-password
              v-model:value="formRegisterData.password_confirmation"
              placeholder="Xác nhận mật khẩu"
              class="w-full h-11"
            />
            <small v-if="errors.password_confirmation" class="text-red-600">
              {{ errors.password_confirmation[0] }}
            </small>
          </div>

          <button
            type="submit"
            class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition-all duration-200"
          >
            Đăng ký
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import api from "../../api";
import { message } from "ant-design-vue";
import { useRouter } from "vue-router";

const errors = ref({});
const router = useRouter();

const activeTab = ref("login");

const formRegisterData = reactive({
  user_name: "",
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const formLoginData = reactive({
  email: "",
  password: "",
});

async function handleLoginSubmit() {
  try {
    const res = await api.post("/login", formLoginData);
    errors.value = {};
    if (res.status === 200) {
      localStorage.setItem("auth_token", res.data.token);
      axios.defaults.headers.common[
        "Authorization"
      ] = `Bearer ${res.data.token}`;

      message.success("Đăng nhập thành công");
      router.push({ name: "admin-analytics" });
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    }
    if (error.response && error.response.status === 401) {
      message.error(error.response.data.message);
    }
  }
}

function loginWithGoogle() {
  window.location.href = "http://localhost:8000/auth/google";
}

onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get("token");

  if (token) {
    localStorage.setItem("auth_token", token);
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

    message.success("Đăng nhập Google thành công");
    router.push({ name: "admin-analytics" });
  }
});

async function handleSubmit() {
  try {
    const res = await api.post("/register", formRegisterData);
    errors.value = {};
    if (res.status == 200) {
      message.success("Đăng ký tài khoản thành công");
      activeTab.value = "login";
    }
  } catch (error) {
    errors.value = error.response.data.errors;
  }
}
</script>

<style scoped>
/* Animation nhỏ */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fadeIn {
  animation: fadeIn 0.5s ease-in-out;
}
</style>

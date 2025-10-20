<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div
      class="w-full max-w-md shadow-2xl border-0 overflow-hidden bg-white rounded-lg"
    >
      <!-- Tab Headers -->
      <div class="relative bg-white">
        <!-- Thanh indicator -->
        <div
          class="absolute bottom-0 h-0.5 bg-blue-600 transition-transform duration-400 ease-out w-1/2"
          :class="activeTab === 'login' ? 'translate-x-0' : 'translate-x-full'"
        ></div>

        <!-- Các button -->
        <div class="flex relative z-10">
          <button
            @click="activeTab = 'login'"
            class="flex-1 py-4 text-center font-semibold transition-colors duration-200"
            :class="
              activeTab === 'login'
                ? 'text-blue-600'
                : 'text-black hover:text-gray-700'
            "
          >
            Đăng nhập
          </button>

          <button
            @click="activeTab = 'register'"
            class="flex-1 py-4 text-center font-semibold transition-colors duration-200"
            :class="
              activeTab === 'register'
                ? 'text-blue-600'
                : 'text-black hover:text-gray-700'
            "
          >
            Đăng ký
          </button>
        </div>
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
            >
              Quên mật khẩu?
            </a>
          </div>

          <button
            type="submit"
            :disabled="isSubmitting"
            class="w-full h-11 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition-all duration-200"
          >
            <template v-if="!isSubmitting">
              <span>Đăng nhập</span>
            </template>
            <template v-else>
              <LoadingOutlined spin class="text-base" />
              <span class="ml-1">Đang đăng nhập...</span>
            </template>
          </button>

          <!-- Divider -->
          <div class="relative flex items-center py-2">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="flex-shrink mx-4 text-sm text-gray-500 font-medium"
              >hoặc</span
            >
            <div class="flex-grow border-t border-gray-300"></div>
          </div>

          <!-- Custom Google Login Button -->
          <button
            type="button"
            @click="loginWithGoogle"
            class="group relative w-full h-12 flex items-center justify-center gap-3 px-4 border-2 border-gray-300 rounded-lg bg-white hover:bg-gray-50 hover:border-gray-400 hover:shadow-lg transition-all duration-300 ease-out overflow-hidden"
          >
            <!-- Hover effect background -->
            <div
              class="absolute inset-0 bg-gradient-to-r from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            ></div>

            <!-- Google Icon -->
            <div
              class="relative z-10 flex items-center justify-center w-6 h-6 group-hover:scale-110 transition-transform duration-300"
            >
              <svg viewBox="0 0 24 24" class="w-6 h-6">
                <path
                  fill="#4285F4"
                  d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                />
                <path
                  fill="#34A853"
                  d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                />
                <path
                  fill="#FBBC05"
                  d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                />
                <path
                  fill="#EA4335"
                  d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                />
              </svg>
            </div>

            <!-- Button Text -->
            <span
              class="relative z-10 text-gray-700 font-semibold text-base group-hover:text-gray-900 transition-colors duration-300"
            >
              Đăng nhập bằng Google
            </span>

            <!-- Shine effect on hover -->
            <div
              class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/30 to-transparent"
            ></div>
          </button>
        </form>

        <!-- Register Form -->
        <form
          v-else
          class="space-y-5 animate-fadeIn"
          @submit.prevent="handleRegisterSubmit()"
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
            :disabled="isSubmitting"
            class="w-full h-11 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <template v-if="!isSubmitting">
              <span>Đăng ký</span>
            </template>
            <template v-else>
              <LoadingOutlined spin />
              <span>Đang đăng ký...</span>
            </template>
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
import { LoadingOutlined } from "@ant-design/icons-vue";
import { router } from "@inertiajs/vue3";

const errors = ref({});

const activeTab = ref("login");

const formRegisterData = reactive({
  user_name: "",
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const isSubmitting = ref(false);

const formLoginData = reactive({
  email: "",
  password: "",
});

async function handleLoginSubmit() {
  if (isSubmitting.value) return;
  errors.value = {};

  const { email, password } = formLoginData;
  if (!email || !password) {
    if (!email) errors.value.email = ["Vui lòng nhập email"];
    if (!password) errors.value.password = ["Vui lòng nhập mật khẩu"];
    return;
  }
  isSubmitting.value = true;

  try {
    const { data } = await api.post("/login", formLoginData);

    localStorage.setItem("auth_token", data.token);
    api.defaults.headers.common["Authorization"] = `Bearer ${data.token}`;

    message.success("Đăng nhập thành công");
    router.visit('/admin/dashboard');
  } catch (error) {
    const res = error.response;
    if (res?.status === 422) {
      errors.value = res.data.errors;
    } else if (res?.status === 401) {
      errors.value = { email: [res.data.message] };
    } else {
      console.error("Login error:", error);
      message.error("Đã xảy ra lỗi khi đăng nhập");
    }
  } finally {
    isSubmitting.value = false;
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

async function handleRegisterSubmit() {
  if (isSubmitting.value) return;
  isSubmitting.value = true;
  errors.value = {};

  try {
    if (!formRegisterData.email || !formRegisterData.password) {
      message.warning("Vui lòng nhập đầy đủ thông tin");
      return;
    }

    const res = await api.post("/register", formRegisterData);

    message.success("Đăng ký tài khoản thành công");
    activeTab.value = "login";
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      message.error("Đăng ký thất bại, vui lòng thử lại");
    }
  } finally {
    isSubmitting.value = false;
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

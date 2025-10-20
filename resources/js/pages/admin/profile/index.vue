<template>
  <div class="min-h-screen py-4 px-4">
    <div v-if="user" class="max-w-6xl mx-auto space-y-8">
      <!-- Header -->
      <div
        class="bg-white shadow-lg hover:shadow-2xl transition-shadow duration-300 rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6"
      >
        <div class="flex items-center gap-4">
          <img
            :src="user.avatar || '/images/avatar_default.png'"
            alt="avatar"
            class="w-24 h-24 rounded-xl object-cover border border-gray-200"
          />
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ user.name }}
            </h1>
            <p class="text-gray-500">{{ user.email }}</p>
            <div class="mt-2">
              <span
                class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full"
                :class="
                  user.status === 'active'
                    ? 'bg-blue-100 text-blue-700'
                    : 'bg-red-100 text-red-600'
                "
              >
                <span
                  class="w-2 h-2 rounded-full mr-2"
                  :class="
                    user.status === 'active' ? 'bg-blue-600' : 'bg-red-600'
                  "
                ></span>
                {{
                  user.status === "active"
                    ? "Đang hoạt động"
                    : "Không hoạt động"
                }}
              </span>
            </div>
          </div>
        </div>

        <button
          @click="handleEdit"
          class="flex items-center justify-center gap-2 px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white rounded-lg text-sm font-medium shadow transition-colors duration-200"
        >
          <Icon icon="mdi:pencil-outline" class="w-4 h-4 text-white" />
          <span>Chỉnh sửa hồ sơ</span>
        </button>

        <!-- Modal chỉnh sửa hồ sơ (Ant Design Vue style) -->
        <a-modal
          v-model:open="isEditModalOpen"
          title="Chỉnh sửa hồ sơ"
          ok-text="Lưu thay đổi"
          cancel-text="Hủy"
          :confirm-loading="isSaving"
          width="700px"
          centered
          @ok="handleSaveProfile"
          @cancel="resetEditForm"
        >
          <div class="space-y-6 py-2">
            <!-- Avatar Upload -->
            <div
              class="flex flex-col items-center gap-4 p-6 rounded-lg bg-gray-200 border border-gray-200"
            >
              <div class="relative group">
                <img
                  :src="
                    previewUrl || user.avatar || '/images/avatar_default.png'
                  "
                  alt="Avatar preview"
                  class="h-32 w-32 rounded-full object-cover ring-4 ring-white shadow-md"
                />
                <label
                  for="avatar-upload"
                  class="absolute inset-0 flex items-center justify-center rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                >
                  <Icon icon="mdi:camera-outline" class="h-8 w-8 text-white" />
                </label>
                <input
                  id="avatar-upload"
                  type="file"
                  accept="image/*"
                  @change="handleAvatarChange"
                  class="hidden"
                />
              </div>
              <div class="text-center">
                <p class="text-sm font-medium text-gray-900">Ảnh đại diện</p>
                <p class="text-xs text-gray-500 mt-1">
                  Nhấp vào ảnh để thay đổi (JPG, PNG, tối đa 2MB)
                </p>
              </div>
            </div>

            <!-- Form Fields -->
            <div class="grid gap-6 sm:grid-cols-2">
              <!-- Họ và tên -->
              <div class="space-y-2 sm:col-span-2">
                <label
                  class="flex items-center gap-2 text-sm font-medium text-gray-700"
                >
                  <Icon
                    icon="mdi:account-outline"
                    class="h-4 w-4 text-blue-600"
                  />
                  Họ và tên
                </label>
                <a-input
                  v-model:value="editForm.name"
                  placeholder="Nhập họ và tên"
                  class="h-11"
                />
                <small v-if="errors.name" class="text-red-600">
                  {{ errors.name[0] }}
                </small>
              </div>

              <!-- Tên tài khoản -->
              <div class="space-y-2">
                <label
                  class="flex items-center gap-2 text-sm font-medium text-gray-700"
                >
                  <Icon icon="mdi:account" class="h-4 w-4 text-green-600" />
                  Tên tài khoản
                </label>
                <a-input
                  v-model:value="editForm.user_name"
                  placeholder="Nhập tên tài khoản"
                  class="h-11"
                />
                <small v-if="errors.user_name" class="text-red-600">
                  {{ errors.user_name[0] }}
                </small>
              </div>

              <!-- Email -->
              <div class="space-y-2">
                <label
                  class="flex items-center gap-2 text-sm font-medium text-gray-700"
                >
                  <Icon
                    icon="mdi:email-outline"
                    class="h-4 w-4 text-indigo-600"
                  />
                  Email
                </label>
                <a-input
                  v-model:value="editForm.email"
                  placeholder="Nhập email"
                  class="h-11"
                />
                <small v-if="errors.email" class="text-red-600">
                  {{ errors.email[0] }}
                </small>
              </div>
            </div>

            <!-- Info Box -->
            <div
              class="rounded-lg bg-blue-50 border border-blue-200 p-4 flex items-start gap-3"
            >
              <Icon
                icon="mdi:shield-outline"
                class="h-5 w-5 text-blue-600 mt-0.5"
              />
              <div>
                <p class="text-sm font-semibold text-gray-900">Lưu ý bảo mật</p>
                <p class="text-xs text-gray-600 leading-relaxed">
                  Thông tin cá nhân của bạn được bảo vệ và chỉ hiển thị theo cài
                  đặt quyền riêng tư. Hãy đảm bảo email của bạn luôn chính xác
                  để nhận thông báo quan trọng.
                </p>
              </div>
            </div>
          </div>
        </a-modal>
      </div>

      <!-- Main Info -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Mật khẩu -->
        <div
          class="col-span-2 p-6 rounded-xl bg-white shadow-lg hover:shadow-2xl transition-shadow duration-300"
        >
          <div class="flex items-center gap-3 mb-6">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-900"
            >
              <Icon
                icon="streamline-block:basic-ui-lock"
                class="text-white w-6 h-6"
              />
            </div>
            <div>
              <h2 class="text-xl font-semibold text-gray-900">
                Bảo mật tài khoản
              </h2>
              <p class="text-sm text-gray-500">Quản lý mật khẩu và bảo mật</p>
            </div>
          </div>

          <div class="space-y-6">
            <!-- Password section -->
            <div
              class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm"
            >
              <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <!-- Input mật khẩu -->
                <div class="flex-1">
                  <label
                    class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-1"
                  >
                    <KeyOutlined class="text-gray-500" />
                    Mật khẩu hiện tại
                  </label>

                  <div class="relative">
                    <a-input
                      :type="showCurrentPassword ? 'text' : 'password'"
                      value="••••••••••••"
                      disabled
                      class="bg-gray-50 pr-11 border-gray-200 hover:border-blue-400 focus:border-blue-500 rounded-lg"
                    />
                  </div>
                </div>

                <!-- Nút thay đổi -->
                <button
                  @click="isPasswordModalOpen = true"
                  class="font-medium rounded-lg mt-[23px] bg-blue-900 hover:bg-blue-800 transition-all sm:w-auto w-full shadow-sm text-white text-sm p-2 px-2"
                >
                  <span>Thay đổi</span>
                </button>
              </div>
            </div>

            <!-- Security tips -->
            <div class="rounded-lg bg-blue-50 p-4 space-y-2">
              <h3
                class="text-sm font-semibold text-gray-800 flex items-center gap-2"
              >
                <SafetyOutlined class="text-blue-600" />
                Mẹo bảo mật
              </h3>
              <ul class="space-y-1.5 text-sm text-gray-600">
                <li class="flex items-start gap-2">
                  <span class="text-blue-600 mt-0.5">•</span>
                  <span>Sử dụng mật khẩu mạnh với ít nhất 8 ký tự</span>
                </li>
                <li class="flex items-start gap-2">
                  <span class="text-blue-600 mt-0.5">•</span>
                  <span>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</span>
                </li>
                <li class="flex items-start gap-2">
                  <span class="text-blue-600 mt-0.5">•</span>
                  <span>Thay đổi mật khẩu định kỳ để tăng cường bảo mật</span>
                </li>
              </ul>
            </div>
          </div>

          <!-- Modal đổi mật khẩu -->
          <a-modal
            v-model:open="isPasswordModalOpen"
            title="Thay đổi mật khẩu"
            ok-text="Cập nhật mật khẩu"
            cancel-text="Hủy"
            :confirm-loading="isChangingPassword"
            @ok="handlePasswordChange"
            @cancel="resetPasswordForm"
            @after-close="resetPasswordForm"
          >
            <div class="space-y-4 py-2">
              <!-- <div class="space-y-2">
                <label class="font-medium text-sm">Mật khẩu hiện tại</label>
                <a-input-password
                  v-model:value="currentPassword"
                  placeholder="Nhập mật khẩu hiện tại"
                />
                <small v-if="errors.current_password" class="text-red-600">
                  {{ errors.current_password[0] }}
                </small>
              </div> -->

              <div class="space-y-2">
                <label class="font-medium text-sm">Mật khẩu mới</label>
                <a-input-password
                  v-model:value="newPassword"
                  placeholder="Nhập mật khẩu mới"
                />
                <small v-if="errors.new_password" class="text-red-600">
                  {{ errors.new_password[0] }}
                </small>
              </div>

              <div class="space-y-2">
                <label class="font-medium text-sm">Xác nhận mật khẩu mới</label>
                <a-input-password
                  v-model:value="confirmPassword"
                  placeholder="Nhập lại mật khẩu mới"
                />
                <small
                  v-if="errors.new_password_confirmation"
                  class="text-red-600"
                >
                  {{ errors.new_password_confirmation[0] }}
                </small>
              </div>

              <div class="rounded-lg bg-gray-50 p-3 space-y-1">
                <p class="text-xs font-medium text-gray-700">
                  Yêu cầu mật khẩu:
                </p>
                <ul class="text-xs text-gray-500 space-y-0.5">
                  <li>• Ít nhất 8 ký tự</li>
                  <li>• Bao gồm chữ hoa và chữ thường</li>
                  <li>• Có ít nhất một số và ký tự đặc biệt</li>
                </ul>
              </div>
            </div>
          </a-modal>
        </div>

        <!-- Thống kê nhanh -->
        <div
          class="rounded-xl bg-white shadow-lg hover:shadow-2xl transition-shadow duration-300 p-6"
        >
          <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Thống kê nhanh
          </h2>
          <div class="space-y-3">
            <div class="flex justify-between text-gray-700">
              <span>Trạng thái</span>
              <span
                class="px-3 py-0.5 text-xs font-medium rounded-full bg-blue-900 text-white"
                >{{
                  user.status === "active" ? "Đang hoạt động" : "Đã khóa"
                }}</span
              >
            </div>
            <div class="flex justify-between text-gray-700">
              <span>Quyền hạn</span>
              <span>{{ user.role?.name || "Thành viên" }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
              <span>Thành viên từ</span>
              <span>{{ formatYear(user.created_at) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Thông tin tài khoản + Hoạt động gần đây -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Thông tin tài khoản -->
        <div
          class="rounded-xl bg-white shadow-lg hover:shadow-2xl transition-shadow duration-300 p-6"
        >
          <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Thông tin tài khoản
          </h2>
          <div class="space-y-4">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100"
              >
                <svg
                  class="w-5 h-5 text-gray-500"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5.121 17.804A15.978 15.978 0 0112 15c2.489 0 4.847.573 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
              </div>
              <div>
                <p class="text-sm text-gray-500">Tên tài khoản</p>
                <p class="font-medium text-gray-900">{{ user.user_name }}</p>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100"
              >
                <Icon icon="mdi:email-outline" class="w-5 h-5 text-green-600" />
              </div>
              <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium text-gray-900">{{ user.email }}</p>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100"
              >
                <svg
                  class="w-5 h-5 text-yellow-600"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
              </div>
              <div>
                <p class="text-sm text-gray-500">Ngày tạo</p>
                <p class="font-medium text-gray-900">
                  {{ formatDate(user.created_at) }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Hoạt động gần đây -->
        <div
          class="rounded-xl bg-white shadow-lg hover:shadow-2xl transition-shadow duration-300 p-6"
        >
          <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Hoạt động gần đây
          </h2>
          <ul class="space-y-3 text-gray-700">
            <li class="flex items-center gap-3">
              <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
              <span
                >Cập nhật hồ sơ
                <span class="text-gray-400 text-sm">2 giờ trước</span></span
              >
            </li>
            <li class="flex items-center gap-3">
              <span class="w-2 h-2 bg-green-600 rounded-full"></span>
              <span>
                Đăng nhập hệ thống
                <span v-if="user.login_at" class="text-gray-400 text-sm">
                  {{ fromNow(user.login_at) }}
                </span>
              </span>
            </li>
            <li class="flex items-center gap-3">
              <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
              <span>
                Thay đổi mật khẩu
                <span class="text-gray-400 text-sm">
                  {{ fromNow(user.change_password_at) }}
                </span>
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div v-else class="text-center py-10 text-gray-500">
      Đang tải thông tin người dùng...
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import { message } from "ant-design-vue";
import api from "../../../api";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/vi";
import admin from "../../../layouts/admin.vue";

defineOptions({
  layout: admin,
});

dayjs.extend(relativeTime);
dayjs.locale("vi");

const user = ref({
  avatar: "",
  name: "",
  email: "",
  status: "",
  user_name: "",
  role: {},
  created_at: "",
});

const now = ref(dayjs());
const isPasswordModalOpen = ref(false);
const isChangingPassword = ref(false);
const showCurrentPassword = ref(false);
const currentPassword = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
const errors = ref({});

const isEditModalOpen = ref(false);
const isSaving = ref(false);
const previewUrl = ref(null);
const editForm = reactive({
  name: "",
  user_name: "",
  email: "",
  avatar: null,
});

const resetPasswordForm = () => {
  currentPassword.value = "";
  newPassword.value = "";
  confirmPassword.value = "";
  errors.value = {};
};

const handlePasswordChange = async () => {
  if (isChangingPassword.value) return;

  isChangingPassword.value = true;
  errors.value = {};

  try {
    const res = await api.put("/user/change-password", {
      current_password: currentPassword.value,
      new_password: newPassword.value,
      new_password_confirmation: confirmPassword.value,
    });

    if (res.status === 200) {
      message.success("Đổi mật khẩu thành công!");
      isPasswordModalOpen.value = false;
      resetPasswordForm();

      const newUser = await api.get("/user");
      user.value = newUser.data;
    }
  } catch (error) {
    if (error.response?.status === 422) {
      const data = error.response.data;
      if (data.errors) {
        errors.value = data.errors;
      } else if (data.message) {
        errors.value = { current_password: [data.message] };
      }
    } else {
      message.error("Không thể đổi mật khẩu. Vui lòng thử lại!");
    }
  } finally {
    isChangingPassword.value = false;
  }
};

const handleEdit = () => {
  editForm.name = user.value.name;
  editForm.user_name = user.value.user_name;
  editForm.email = user.value.email;
  previewUrl.value = user.value.avatar;
  isEditModalOpen.value = true;
};

const handleAvatarChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    editForm.avatar = file;
    previewUrl.value = URL.createObjectURL(file);
  }
};

const resetEditForm = () => {
  isEditModalOpen.value = false;
  editForm.name = "";
  editForm.user_name = "";
  editForm.email = "";
  editForm.avatar = null;
  previewUrl.value = null;
};

const handleSaveProfile = async () => {
  isSaving.value = true;
  try {
    const formData = new FormData();
    formData.append("name", editForm.name?.trim() || "");
    formData.append("user_name", editForm.user_name?.trim() || "");
    formData.append("email", editForm.email?.trim() || "");
    if (editForm.avatar) {
      formData.append("avatar", editForm.avatar);
    }

    formData.append("_method", "PUT");

    const { data } = await api.post("/user/profile", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    for (let [key, value] of formData.entries()) {
      console.log(key, value);
    }

    message.success("Cập nhật hồ sơ thành công!");
    user.value = data.user;
    resetEditForm();
  } catch (error) {
    if (error.response?.status === 422) {
      const data = error.response.data;
      if (data.errors) {
        errors.value = data.errors;
      } else if (data.message) {
        errors.value = { current_password: [data.message] };
      }
    } else {
      message.error("Không thể cập nhật hồ sơ. Vui lòng thử lại!");
    }
  } finally {
    isSaving.value = false;
  }
};

const formatDate = (dateStr) => {
  if (!dateStr) return "Không xác định";
  const date = dayjs(dateStr);
  return date.isValid() ? date.format("DD [tháng] M, YYYY") : "Không xác định";
};

const formatYear = (dateStr) => {
  if (!dateStr) return "Không rõ";
  const date = dayjs(dateStr);
  return date.isValid() ? date.format("YYYY") : "Không rõ";
};

const fromNow = (time) => {
  if (!time) return "";
  const minutes = now.value.diff(dayjs(time), "minute");
  const hours = now.value.diff(dayjs(time), "hour");
  const days = now.value.diff(dayjs(time), "day");

  if (minutes < 60) return `${minutes} phút trước`;
  else if (hours < 24) return `${hours} giờ trước`;
  else return `${days} ngày trước`;
};

onMounted(async () => {
  try {
    const res = await api.get("/user");
    const data = res.data;
    const timer = setInterval(() => {
      now.value = dayjs();
    }, 60000);

    user.value = {
      ...data,
      login_at: res.data.login_at,
      change_password_at: res.data.change_password_at,
    };
  } catch (error) {
    console.error("Không thể lấy thông tin user:", error);
  }
});

// onUnmounted(() => clearInterval(timer));
</script>

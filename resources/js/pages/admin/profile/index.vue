<template>
  <div class="min-h-screen py-4 px-4">
    <div v-if="user" class="max-w-6xl mx-auto space-y-8">
      <!-- Header -->
      <div
        class="bg-white shadow rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6"
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
                    : 'bg-gray-100 text-gray-600'
                "
              >
                <span
                  class="w-2 h-2 rounded-full mr-2"
                  :class="
                    user.status === 'active' ? 'bg-blue-600' : 'bg-gray-400'
                  "
                ></span>
                {{ user.status === "active" ? "Hoạt động" : "Không hoạt động" }}
              </span>
            </div>
          </div>
        </div>

        <button
          @click="handleEdit"
          class="flex items-center justify-center gap-2 px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white rounded-lg text-sm font-medium shadow"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.232 5.232l3.536 3.536M9 11l6.232-6.232a2.828 2.828 0 114 4L13 15l-4 1 1-4z"
            />
          </svg>
          Chỉnh sửa hồ sơ
        </button>
      </div>

      <!-- Main Info -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Giới thiệu -->
        <div class="bg-white p-6 rounded-2xl shadow col-span-2">
          <h2 class="text-lg font-semibold text-gray-900 mb-2">Giới thiệu</h2>
          <p class="text-gray-600 leading-relaxed">
            {{
              user.bio ||
              "Tôi là một nhà phát triển đam mê tạo ra các giao diện người dùng đẹp mắt và dễ tiếp cận. Công việc yêu thích của tôi nằm ở giao điểm giữa thiết kế và phát triển, tạo ra những trải nghiệm không chỉ đẹp mà còn hiệu quả và dễ sử dụng."
            }}
          </p>
        </div>

        <!-- Thống kê nhanh -->
        <div class="bg-white p-6 rounded-2xl shadow">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Thống kê nhanh
          </h2>
          <div class="space-y-3">
            <div class="flex justify-between text-gray-700">
              <span>Trạng thái</span>
              <span
                class="px-3 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700"
                >{{ user.status === "active" ? "Hoạt động" : "Đã khóa" }}</span
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
        <div class="bg-white p-6 rounded-2xl shadow">
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
                <svg
                  class="w-5 h-5 text-green-600"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16 12H8m8 0a4 4 0 10-8 0 4 4 0 008 0zM12 20v-8"
                  />
                </svg>
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
        <div class="bg-white p-6 rounded-2xl shadow">
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
              <span
                >Đăng nhập hệ thống
                <span class="text-gray-400 text-sm">5 giờ trước</span></span
              >
            </li>
            <li class="flex items-center gap-3">
              <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
              <span
                >Thay đổi mật khẩu
                <span class="text-gray-400 text-sm">3 ngày trước</span></span
              >
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
import { ref, onMounted } from "vue";
import { message } from "ant-design-vue";
import api from "../../../api";
import dayjs from "dayjs";
import "dayjs/locale/vi";
dayjs.locale("vi");

const user = ref({
  avatar: "",
  name: "",
  email: "",
  status: "",
  user_name: "",
  role: {},
  created_at: "",
  bio: "",
});

const handleEdit = () => {
  message.info("Chức năng chỉnh sửa hồ sơ đang được phát triển!");
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

onMounted(async () => {
  try {
    const res = await api.get("/user");
    const data = res.data;

    // Format luôn trong lúc gán dữ liệu
    user.value = {
      ...data,
      joined_year: formatYear(data.created_at),
      login_at: data.login_at
        ? dayjs(data.login_at).format("DD/MM/YYYY - HH:mm")
        : "Chưa có lượt đăng nhập",
      change_password_at: data.change_password_at
        ? dayjs(data.change_password_at).format("DD/MM/YYYY - HH:mm")
        : "Chưa thay đổi mật khẩu",
    };
    console.log("USER RESPONSE:", res.data);
  } catch (error) {
    console.error("Không thể lấy thông tin user:", error);
  }
});
</script>

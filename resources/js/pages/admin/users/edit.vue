<template>
  <form @submit.prevent="submitForm">
    <a-card title="Cập nhật tài khoản">
      <div class="grid sm:grid-cols-3 items-start">
        <!-- CỘT AVATAR -->
        <div class="col-span-1 flex flex-col items-center ml-6">
          <img
            :src="avatarPreview || user.avatar || '/images/avatar_default.png'"
            alt="Avatar"
            class="w-[200px] h-[200px] object-cover rounded-2xl mb-2"
          />
          <a-button
            class="mb-6 px-4 py-2 flex items-center justify-center text-white font-medium border bg-blue-600 rounded shadow"
            @click="$refs.fileInput.click()"
          >
            <UploadOutlined />
            <span>Chọn ảnh</span>
          </a-button>

          <input
            ref="fileInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="handleAvatarChange"
          />
        </div>

        <!-- FORM THÔNG TIN -->
        <div
          class="col-span-2 grid gap-y-2 sm:gap-5 sm:grid-cols-3 sm:items-start"
        >
          <!-- user_name -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>Tên tài khoản:
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Tên tài khoản"
              v-model:value="form.user_name"
              allow-clear
              :status="errors?.user_name ? 'error' : ''"
            />
            <small v-if="errors?.user_name" class="text-red-600">
              {{ errors.user_name[0] }}
            </small>
          </div>

          <!-- name -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>Họ & tên:
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Họ & tên"
              v-model:value="form.name"
              allow-clear
              :status="errors?.name ? 'error' : ''"
            />
            <small v-if="errors?.name" class="text-red-600">
              {{ errors.name[0] }}
            </small>
          </div>

          <!-- email -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>Email:
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Email"
              v-model:value="form.email"
              allow-clear
              :status="errors?.email ? 'error' : ''"
            />
            <small v-if="errors?.email" class="text-red-600">
              {{ errors.email[0] }}
            </small>
          </div>

          <!-- roles -->
          <label class="col-span-1 flex items-center md:justify-end text-start">
            <span class="text-red-600 mr-1">*</span>Vai trò:
          </label>
          <div class="col-span-2">
            <a-select
              show-search
              placeholder="Chọn vai trò"
              class="w-full"
              :options="roles"
              allow-clear
              v-model:value="form.roles_id"
            />
          </div>

          <!-- Đổi mật khẩu -->
          <label class="col-span-1 flex items-center md:justify-end"></label>
          <div class="col-span-2">
            <a-checkbox v-model:checked="changePassword"
              >Đổi mật khẩu</a-checkbox
            >
          </div>

          <template v-if="changePassword">
            <label class="col-span-1 flex items-center md:justify-end">
              <span class="text-red-600 mr-1">*</span>Password:
            </label>
            <div class="col-span-2">
              <a-input-password
                placeholder="Password"
                v-model:value="form.password"
                allow-clear
                :status="errors?.password ? 'error' : ''"
              />
              <small v-if="errors?.password" class="text-red-600">
                {{ errors.password[0] }}
              </small>
            </div>

            <label class="col-span-1 flex items-center md:justify-end">
              <span class="text-red-600 mr-1">*</span>Xác nhận mật khẩu:
            </label>
            <div class="col-span-2">
              <a-input-password
                placeholder="Xác nhận mật khẩu"
                v-model:value="form.password_confirmation"
                allow-clear
                :status="errors?.password_confirmation ? 'error' : ''"
              />
              <small v-if="errors?.password_confirmation" class="text-red-600">
                {{ errors.password_confirmation[0] }}
              </small>
            </div>
          </template>

          <!-- Login info -->
          <label class="col-span-1 flex items-center md:justify-end"
            >Lần đăng nhập gần đây:</label
          >
          <div class="col-span-2">
            <span>{{ formattedLoginAt }}</span>
          </div>

          <label class="col-span-1 flex items-center md:justify-end"
            >Lần đổi mật khẩu gần đây:</label
          >
          <div class="col-span-2">
            <span>{{ formattedChangePasswordAt }}</span>
          </div>
        </div>

        <!-- BUTTONS -->
        <div
          class="gap-3 col-span-2 text-center font-semibold sm:col-span-3 flex flex-col mt-4 md:flex-row md:justify-end md:items-end cursor-pointer"
        >
          <a-button
            html-type="submit"
            class="!bg-blue-600 !text-white hover:!bg-blue-500 px-6"
            :loading="isSubmitting"
          >
            Lưu
          </a-button>

          <a-button
            class="!bg-gray-300 hover:!bg-gray-200 !text-black shadow-sm px-6"
          >
            <Link href="/admin/users">Hủy</Link>
          </a-button>

          <a-button
            v-if="form.status === 'active'"
            type="primary"
            danger
            class="px-6"
            @click="toggleStatus('inactive')"
          >
            Block
          </a-button>

          <a-button
            v-else
            type="default"
            class="!bg-green-500 !text-white hover:!bg-green-400 px-6"
            @click="toggleStatus('active')"
          >
            Unblock
          </a-button>
        </div>
      </div>
    </a-card>
  </form>
</template>

<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { message } from "ant-design-vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import dayjs from "dayjs";
import admin from "../../../layouts/admin.vue";
import { Link } from "@inertiajs/vue3";
defineOptions({ layout: admin });

// Nhận props từ controller
const props = defineProps({
  user: { type: Object, required: true },
  roles: { type: Array, required: true },
});

// Khởi tạo reactive state
const avatarPreview = ref(null);
const changePassword = ref(false);
const isSubmitting = ref(false);
const errors = ref({});

const form = ref({
  user_name: props.user.user_name,
  name: props.user.name,
  email: props.user.email,
  roles_id: props.user.roles_id,
  status: props.user.status,
  avatar: null,
  password: "",
  password_confirmation: "",
});

// Xử lý chọn ảnh
const handleAvatarChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.value.avatar = file;
    avatarPreview.value = URL.createObjectURL(file);
  }
};

// Gửi form cập nhật
const submitForm = async () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;
  errors.value = null;

  try {
    const formData = new FormData();
    Object.entries(form.value).forEach(([k, v]) => {
      if (v !== null && v !== undefined) formData.append(k, v);
    });
    formData.append("_method", "PUT");
    formData.append("change_password", changePassword.value ? 1 : 0);

    const res = await axios.post(`/admin/users/${props.user.id}`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    message.success(res.data.message || "Cập nhật người dùng thành công!");
    errors.value = null;
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors || {};
      const firstError = Object.values(error.response.data.errors)[0][0];
      message.error(firstError);
    } else {
      message.error("Cập nhật thất bại, vui lòng thử lại!");
    }
  } finally {
    isSubmitting.value = false;
  }
};

// Cập nhật trạng thái active/inactive
const toggleStatus = async (newStatus) => {
  try {
    const res = await axios.put(`/admin/users/${props.user.id}/status`, {
      status: newStatus,
    });
    message.success("Cập nhật trạng thái thành công!");
    form.value.status = res.data.user.status;
  } catch (error) {
    console.error("Lỗi toggleStatus:", error);
    message.error("Không thể cập nhật trạng thái!");
  }
};

// Format thời gian
const formattedLoginAt = computed(() =>
  props.user.login_at
    ? dayjs(props.user.login_at).format("DD/MM/YY - HH:mm")
    : "Chưa có lượt đăng nhập"
);
const formattedChangePasswordAt = computed(() =>
  props.user.change_password_at
    ? dayjs(props.user.change_password_at).format("DD/MM/YY - HH:mm")
    : "Chưa thay đổi mật khẩu"
);
</script>

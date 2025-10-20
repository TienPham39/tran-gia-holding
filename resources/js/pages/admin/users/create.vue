<template>
  <form @submit.prevent="submit">
    <a-card title="Tạo tài khoản mới">
      <div class="grid sm:grid-cols-3 items-start">
        <!-- Cột Avatar -->
        <div class="col-span-1 flex flex-col items-center">
          <img
            :src="avatarPreview || '/images/avatar_default.png'"
            alt="Avatar"
            class="w-[200px] h-[200px] sm:w-[300px] sm:h-[300px] object-cover rounded-2xl max-w-full mb-2"
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

        <!-- Cột Form -->
        <div class="col-span-2 grid gap-5 sm:grid-cols-3 sm:items-start">
          <!-- Tên tài khoản -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': form.errors.user_name }">
              Tên tài khoản:
            </span>
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Tên tài khoản"
              v-model:value="form.user_name"
              class="w-full"
              allow-clear
              :status="form.errors.user_name ? 'error' : ''"
            />
            <small v-if="form.errors.user_name" class="text-red-600">
              {{ form.errors.user_name }}
            </small>
          </div>

          <!-- Họ & tên -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': form.errors.name }">Họ & tên:</span>
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Họ & tên"
              v-model:value="form.name"
              class="w-full"
              allow-clear
              :status="form.errors.name ? 'error' : ''"
            />
            <small v-if="form.errors.name" class="text-red-600">
              {{ form.errors.name }}
            </small>
          </div>

          <!-- Email -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': form.errors.email }">Email:</span>
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Email"
              v-model:value="form.email"
              class="w-full"
              allow-clear
              :status="form.errors.email ? 'error' : ''"
            />
            <small v-if="form.errors.email" class="text-red-600">
              {{ form.errors.email }}
            </small>
          </div>

          <!-- Password -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': form.errors.password }">
              Password:
            </span>
          </label>
          <div class="col-span-2">
            <a-input-password
              placeholder="Password"
              v-model:value="form.password"
              class="w-full"
              allow-clear
              :status="form.errors.password ? 'error' : ''"
            />
            <small v-if="form.errors.password" class="text-red-600">
              {{ form.errors.password }}
            </small>
          </div>

          <!-- Xác nhận Password -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': form.errors.password_confirmation }">
              Xác nhận mật khẩu:
            </span>
          </label>
          <div class="col-span-2">
            <a-input-password
              placeholder="Xác nhận mật khẩu"
              v-model:value="form.password_confirmation"
              class="w-full"
              allow-clear
              :status="form.errors.password_confirmation ? 'error' : ''"
            />
            <small v-if="form.errors.password_confirmation" class="text-red-600">
              {{ form.errors.password_confirmation }}
            </small>
          </div>

          <!-- Vai trò -->
          <label class="col-span-1 flex items-center md:justify-end text-start">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': form.errors.roles_id }">Vai trò:</span>
          </label>
          <div class="col-span-2 mb-6">
            <a-select
              show-search
              placeholder="Chọn vai trò"
              class="w-full"
              :options="roles"
              :filter-option="filterOption"
              allow-clear
              v-model:value="form.roles_id"
              :status="form.errors.roles_id ? 'error' : ''"
            />
            <small v-if="form.errors.roles_id" class="text-red-600">
              {{ form.errors.roles_id }}
            </small>
          </div>
        </div>

        <!-- Buttons -->
        <div
          class="gap-4 col-span-2 text-center font-semibold sm:col-span-3 flex flex-col md:flex-row md:justify-end md:items-end cursor-pointer"
        >
          <a-button
            html-type="submit"
            class="!bg-blue-600 !text-white hover:!bg-blue-500 px-6"
            :loading="form.processing"
          >
            Lưu
          </a-button>

          <a-button
            class="!bg-gray-300 hover:!bg-gray-200 !text-black shadow-sm px-6"
          >
            <Link href="/admin/users">Hủy</Link>
          </a-button>
        </div>
      </div>
    </a-card>
  </form>
</template>

<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import { message } from "ant-design-vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });
defineProps({ roles: Array });

const form = useForm({
  user_name: "",
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  status: "active",
  roles_id: null,
  avatar: null,
});

const avatarPreview = ref(null);

const handleAvatarChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.avatar = file;
    avatarPreview.value = URL.createObjectURL(file);
  }
};

const filterOption = (input, option) =>
  option.label.toLowerCase().includes(input.toLowerCase());

const submit = () => {
  form.post(route("admin.users.store"), {
    forceFormData: true,
    onSuccess: () => {
      message.success("Tạo người dùng thành công!");
    },
    onError: () => {
      message.error("Không thể tạo người dùng. Vui lòng kiểm tra lại!");
    },
  });
};
</script>

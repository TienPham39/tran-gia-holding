<template>
  <form @submit.prevent="updateUser()">
    <a-card title="Cập nhật tài khoản">
      <div class="grid sm:grid-cols-3 items-start">
        <!-- Cột Avatar -->
        <div class="col-span-1 flex flex-col items-center ml-6">
          <img
            src="/images/avatar_default.png"
            alt="Avatar"
            class="w-[200px] h-[200px] sm:w-[300px] sm:h-[300px] object-cover rounded max-w-full"
          />
          <a-button
            class="mb-6 px-4 py-2 flex items-center justify-center text-white font-medium border bg-blue-600 rounded shadow"
          >
            <UploadOutlined />
            <span>Chọn ảnh</span>
          </a-button>
        </div>

        <!-- Cột Form -->
        <div
          class="col-span-2 grid gap-y-2 sm:gap-5 sm:grid-cols-3 sm:items-start"
        >
          <!-- Tên tài khoản -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': errors.user_name }"
              >Tên tài khoản:</span
            >
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Tên tài khoản"
              v-model:value="user_name"
              class="w-full"
              allow-clear
              :status="errors.user_name ? 'error' : ''"
            />
            <small v-if="errors.user_name" class="text-red-600">
              {{ errors.user_name[0] }}
            </small>
          </div>

          <!-- Họ & tên -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': errors.name }">Họ & tên:</span>
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Họ & tên"
              v-model:value="name"
              class="w-full"
              allow-clear
              :status="errors.name ? 'error' : ''"
            />
            <small v-if="errors.name" class="text-red-600">
              {{ errors.name[0] }}
            </small>
          </div>

          <!-- Email -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': errors.email }">Email:</span>
          </label>
          <div class="col-span-2">
            <a-input
              placeholder="Email"
              v-model:value="email"
              class="w-full"
              allow-clear
              :status="errors.email ? 'error' : ''"
            />
            <small v-if="errors.email" class="text-red-600">
              {{ errors.email[0] }}
            </small>
          </div>

          <!-- Vai trò -->
          <label class="col-span-1 flex items-center md:justify-end text-start">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': errors.roles_id }">Vai trò:</span>
          </label>
          <div class="col-span-2">
            <a-select
              show-search
              placeholder="Chọn vai trò"
              class="w-full"
              :options="role"
              :filter-option="filterOption"
              allow-clear
              v-model:value="roles_id"
              :status="errors.roles_id ? 'error' : ''"
            />
            <small v-if="errors.roles_id" class="text-red-600">
              {{ errors.roles_id[0] }}
            </small>
          </div>

          <!-- Change Password -->
          <label class="col-span-1 flex items-center md:justify-end"> </label>
          <div class="col-span-2">
            <a-checkbox v-model:checked="change_password"
              >Đổi mật khẩu</a-checkbox
            >
          </div>

          <!-- Các trường Password chỉ hiện khi check -->
          <template v-if="change_password == true">
            <!-- Password -->
            <label class="col-span-1 flex items-center md:justify-end">
              <span class="text-red-600 mr-1">*</span>
              <span :class="{ 'text-red-600': errors.password }"
                >Password:</span
              >
            </label>
            <div class="col-span-2">
              <a-input-password
                placeholder="Password"
                v-model:value="password"
                class="w-full"
                allow-clear
                :status="errors.password ? 'error' : ''"
              />
              <small v-if="errors.password" class="text-red-600">
                {{ errors.password[0] }}
              </small>
            </div>

            <!-- Xác nhận mật khẩu -->
            <label class="col-span-1 flex items-center md:justify-end">
              <span class="text-red-600 mr-1">*</span>
              <span :class="{ 'text-red-600': errors.password }"
                >Xác nhận mật khẩu:</span
              >
            </label>
            <div class="col-span-2">
              <a-input-password
                placeholder="Xác nhận mật khẩu"
                v-model:value="password_confirmation"
                class="w-full"
                allow-clear
                :status="errors.password ? 'error' : ''"
              />
              <small v-if="errors.password" class="text-red-600">
                {{ errors.password[0] }}
              </small>
            </div>
          </template>

          <label class="col-span-1 flex items-center md:justify-end">
            <span>Lần đăng nhập gần đây:</span>
          </label>
          <div class="col-span-2">
            <span>{{ login_at }}</span>
          </div>

          <label class="col-span-1 flex items-center md:justify-end">
            <span>Lần đổi mật khẩu gần đây:</span>
          </label>
          <div class="col-span-2">
            <span>{{ change_password_at }}</span>
          </div>
        </div>

        <div
          class="gap-3 col-span-2 text-center font-semibold sm:col-span-3 flex flex-col mt-4 md:flex-row md:justify-end md:items-end cursor-pointer"
        >
          <a-button
            html-type="submit"
            class="!bg-blue-600 !text-white hover:!bg-blue-500 px-6"
          >
            Lưu
          </a-button>

          <a-button
            class="!bg-gray-300 hover:!bg-gray-200 !text-black shadow-sm px-6"
          >
            <router-link :to="{ name: 'admin-users' }"> Hủy </router-link>
          </a-button>

          <a-button
            v-if="status === 'active'"
            type="primary"
            danger
            class="px-6"
            @click="updateUserStatus(id, 'inactive')"
          >
            Block
          </a-button>

          <a-button
            v-else
            type="default"
            class="!bg-green-500 !text-white hover:!bg-green-400 px-6"
            @click="updateUserStatus(id, 'active')"
          >
            Unblock
          </a-button>
        </div>
      </div>
    </a-card>
  </form>
</template>

<script>
import api from "../../../api";
import { defineComponent, onMounted, ref, reactive, toRefs } from "vue";
import { useRouter, useRoute } from "vue-router";
import { message } from "ant-design-vue";
import dayjs from "dayjs";

export default defineComponent({
  setup() {
    const router = useRouter();
    const route = useRoute();
    const role = ref([]);
    const user = reactive({
      id: null,
      user_name: "",
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      status: "active",
      roles_id: null,
      change_password: false,
      login_at: "",
      change_password_at: "",
    });

    const errors = ref({});

    async function getUsersEdit() {
      try {
        const response = await api.get(
          `/users/${route.params.id}/edit`
        );
        user.id = response.data.users.id;
        user.user_name = response.data.users.user_name;
        user.name = response.data.users.name;
        user.email = response.data.users.email;
        user.status = response.data.users.status;
        user.roles_id = response.data.users.roles_id;
        user.change_password = response.data.users.change_password;

        response.data.users.login_at
          ? (user.login_at = dayjs(response.data.users.login_at).format(
              "DD/MM/YY - HH:mm"
            ))
          : (user.login_at = "Chưa có lượt đăng nhập");

        response.data.users.change_password_at
          ? (user.change_password_at = dayjs(
              response.data.users.change_password_at
            ).format("DD/MM/YY - HH:mm"))
          : (user.change_password_at = "Chưa thay đổi mật khẩu");

        role.value = response.data.roles;
      } catch (error) {
        errors.value = error.response.data.errors;
      }
    }

    async function updateUser() {
      try {
        const response = await api.put(
          `/users/${route.params.id}`,
          user
        );
        if (response.status == 200) {
          message.success("Cập nhật thành công");
          router.push({ name: "admin-users" });
        }
      } catch (error) {
        errors.value = error.response.data.errors;
      }
    }

    async function updateUserStatus(id, status) {
      try {
        const response = await api.put(
          `/users/${id}/status`,
          { status }
        );
        if (response.status == 200) {
          message.success(response.data.message);
          router.push({ name: "admin-users" });
        }
        getUsersEdit();
      } catch (err) {
        message.error("Cập nhật trạng thái thất bại");
      }
    }

    const filterOption = (input, option) => {
      return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
    };

    getUsersEdit();

    return {
      role,
      filterOption,
      updateUser,
      updateUserStatus,
      ...toRefs(user),
      errors,
    };
  },
});
</script>

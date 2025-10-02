<template>
  <form @submit.prevent="createUsers()">
    <a-card title="Tạo tài khoản mới">
      <div class="grid sm:grid-cols-3 items-start">
        <!-- Cột Avatar -->
        <div class="col-span-1 flex flex-col items-center">
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
        <div class="col-span-2 grid gap-5 sm:grid-cols-3 sm:items-start">
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

          <!-- Password -->
          <label class="col-span-1 flex items-center md:justify-end">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': errors.password }">Password:</span>
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

          <!-- Xác nhận Pass -->
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

          <!-- Vai trò -->
          <label class="col-span-1 flex items-center md:justify-end text-start">
            <span class="text-red-600 mr-1">*</span>
            <span :class="{ 'text-red-600': errors.roles_id }">Vai trò:</span>
          </label>
          <div class="col-span-2 mb-6">
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
        </div>
        <div
          class="gap-4 col-span-2 text-center font-semibold sm:col-span-3 flex flex-col md:flex-row md:justify-end md:items-end cursor-pointer"
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
        </div>
      </div>
    </a-card>
  </form>
</template>

<script>
import api from "../../../api";
import { defineComponent, onMounted, ref, reactive, toRefs } from "vue";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";

export default defineComponent({
  setup() {
    const router = useRouter();
    const role = ref([]);
    const user = reactive({
      user_name: "",
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      status: "active",
      roles_id: null,
    });

    const errors = ref({});

    async function createUsers() {
      try {
        const response = await api.post("/users", {
          ...user,
        });
        if (response.status == 200) {
          message.success("Tạo người dùng thành công!");
          router.push({ name: "admin-users" });
        }

        // Reset form
        Object.assign(user, {
          user_name: "",
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
          status: "active",
          roles_id: [],
        });

        errors.value = {};
      } catch (error) {
        console.error("Lỗi khi tạo user:", error);
        errors.value = error.response?.data?.errors || {};
      }
    }

    async function getUsersCreate() {
      try {
        const response = await api.get(
          "/api/user/create",
          { ...role }
        );
        role.value = response.data.roles;
      } catch (error) {
        console.error("Lỗi khi load role user:", error);
      }
    }

    const filterOption = (input, option) => {
      return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
    };

    onMounted(() => {
      getUsersCreate();
    });

    return { role, filterOption, createUsers, ...toRefs(user), errors };
  },
});
</script>

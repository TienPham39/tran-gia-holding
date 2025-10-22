<template>
  <div
    class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300"
  >
    <a-card title="Quản lý người dùng" :bordered="false">
      <template #extra>
        <Link
          :href="route('admin.users.create')"
          class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-white! bg-blue-900! rounded-full shadow hover:bg-blue-800! transition-all duration-200"
        >
          <span>Tạo người dùng</span>
        </Link>
      </template>

      <a-table
        :dataSource="users"
        :columns="columns"
        :scroll="{ x: 'max-content' }"
        :pagination="pagination"
        @change="handleTableChange"
      >
        <template #bodyCell="{ column, index, record }">
          <template v-if="column.key === 'index'">
            <span>
              {{ (pagination.current - 1) * pagination.pageSize + index + 1 }}
            </span>
          </template>

          <!-- Avatar -->
          <template v-else-if="column.key === 'avatar'">
            <a-avatar
              :size="50"
              :src="getAvatarUrl(record.avatar)"
              @error="(e) => (e.target.src = '/images/avatar_default.png')"
            />
          </template>

          <!-- Roles -->
          <template v-if="column.key === 'role'">
            <a-tag v-if="record.role === 'Admin'" class="font-semibold">
              Admin
            </a-tag>
            <a-tag
              v-else-if="record.role === 'Marketing Manager'"
              class="font-semibold"
            >
              Marketing Manager
            </a-tag>
            <a-tag v-else class="font-semibold"> Khác </a-tag>
          </template>

          <!-- Status -->
          <template v-if="column.key === 'status'">
            <a-tag
              v-if="record.status && record.status.toLowerCase() === 'active'"
              class="text-white! bg-blue-600! font-semibold"
            >
              Active
            </a-tag>
            <a-tag v-else class="text-white! bg-red-600! font-semibold"
              >Inactive</a-tag
            >
          </template>

          <!-- Hành động -->
          <template v-if="column.key === 'action'">
            <a-space>
              <Link :href="route('admin.users.edit', record.id)">
                <a-button type="link" class="text-blue-600">
                  <EditOutlined />
                </a-button>
              </Link>

              <a-button
                @click="deleteUser(record.id)"
                type="link"
                class="text-red-600! hover:text-red-400!"
              >
                <DeleteOutlined />
              </a-button>
            </a-space>
          </template>
        </template>
      </a-table>
    </a-card>
  </div>
</template>

<script setup>
import { ref, onMounted, createVNode } from "vue";
import api from "../../../api";
import { Modal, message } from "ant-design-vue";
import {
  ExclamationCircleOutlined,
  DeleteOutlined,
  EditOutlined,
} from "@ant-design/icons-vue";
import admin from "../../../layouts/admin.vue";
import { usePage, router, Link } from "@inertiajs/vue3";

defineOptions({
  layout: admin,
});

const { props } = usePage();
const users = ref(props.users.data);
const pagination = ref({
  current: props.users.current_page,
  total: props.users.total,
  pageSize: props.users.per_page,
});

const columns = [
  { title: "#", key: "index" },
  { title: "Avatar", dataIndex: "avatar", key: "avatar", align: "center" },
  { title: "Tài khoản", dataIndex: "user_name", key: "user_name" },
  { title: "Họ tên", dataIndex: "name", key: "name" },
  { title: "Email", dataIndex: "email", key: "email" },
  {
    title: "Role",
    dataIndex: "role",
    key: "role",
    align: "center",
    responsive: ["sm"],
  },
  {
    title: "Tình trạng",
    dataIndex: "status",
    key: "status",
    align: "center",
    responsive: ["sm"],
  },
  { title: "Hành động", key: "action", fixed: "right", align: "center" },
];

function getAvatarUrl(avatar) {
  if (!avatar) return "/images/avatar_default.png";
  if (avatar.startsWith("data:image/")) return avatar;
  if (avatar.startsWith("/storage/")) {
    return `${window.location.origin}${avatar}`;
  }
  return avatar;
}

function handleTableChange(paginationData) {
  router.visit(`/admin/users?page=${paginationData.current}`, {
    preserveScroll: true,
    preserveState: false,
  });
}

async function deleteUser(id) {
  Modal.confirm({
    title: "Bạn có chắc chắn muốn xóa người dùng này?",
    icon: createVNode(ExclamationCircleOutlined),
    content: "Hành động này sẽ xóa vĩnh viễn và không thể hoàn tác.",
    okText: "Xóa",
    okType: "danger",
    cancelText: "Hủy",
    async onOk() {
      await router.post(route("admin.users.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
          message.success("Xóa người dùng thành công!");
          router.reload({ only: ["users"] });
        },
        onError: () => {
          message.error("Xóa người dùng thất bại!");
        },
      });
    },
  });
}
</script>

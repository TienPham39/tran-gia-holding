<template>
  <div
    class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300"
  >
    <a-card title="Quản lý người dùng" :bordered="false">
      <template #extra>
        <router-link
          :to="{ name: 'admin-users-create' }"
          class="flex items-center gap-2"
        >
          <PlusOutlined /> Tạo người dùng
        </router-link>
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
              :src="record.avatar || '/images/avatar_default.png'"
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
              class="!text-white !bg-blue-600 font-semibold"
            >
              Active
            </a-tag>
            <a-tag v-else class="!text-white !bg-red-600 font-semibold">Inactive</a-tag>
          </template>

          <!-- Hành động -->
          <template v-if="column.key === 'action'">
            <a-space>
              <router-link
                :to="{ name: 'admin-users-edit', params: { id: record.id } }"
              >
                <a-button type="link" class="text-blue-600">
                  <EditOutlined />
                </a-button>
              </router-link>
              <a-button
                @click="deleteUser(record.id)"
                type="link"
                class="!text-red-600 hover:!text-red-400"
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

<script>
import { defineComponent, ref, onMounted } from "vue";
import api from "../../../api";
import { Modal, message } from "ant-design-vue";
import { createVNode } from "vue";
import { ExclamationCircleOutlined } from "@ant-design/icons-vue";

export default defineComponent({
  setup() {
    const users = ref([]);
    const pagination = ref({
      current: 1, // Trang hiện tại
      pageSize: 5, // Số bản ghi mỗi trang
      total: 0, // Tổng số bản ghi
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

    async function getUsers(page = 1) {
      try {
        const response = await api.get(
          `/users?page=${page}`
        );
        users.value = response.data.data;
        pagination.value.total = response.data.total;
        pagination.value.current = response.data.current_page;
        pagination.value.pageSize = response.data.per_page;
      } catch (error) {
        console.error("Lỗi khi load users:", error);
      }
    }

    const handleTableChange = (pagination) => {
      getUsers(pagination.current); // Gọi lại hàm getUsers khi trang thay đổi
    };

    async function deleteUser(id) {
      Modal.confirm({
        title: "Bạn có chắc chắn muốn xóa người dùng này?",
        icon: createVNode(ExclamationCircleOutlined),
        content: "Hành động này sẽ xóa vĩnh viễn và không thể hoàn tác.",
        okText: "Xóa",
        okType: "danger",
        cancelText: "Hủy",
        async onOk() {
          try {
            const response = await api.delete(
              `/users/${id}`
            );
            if (response.status === 200) {
              message.success(response.data.message);
              getUsers();
            }
          } catch (error) {
            console.error(error);
            message.error(
              error.response?.data?.message || "Xóa người dùng thất bại"
            );
          }
        },
        onCancel() {
          console.log("Người dùng đã hủy xóa");
        },
      });
    }

    onMounted(() => {
      getUsers(pagination.value.current);
    });

    return {
      users,
      columns,
      pagination,
      getUsers,
      handleTableChange,
      deleteUser,
    };
  },
});
</script>

<template>
  <div class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300">
    <a-card title="Quản lý liên hệ" :bordered="false">
      <!-- TABLE -->
      <a-table :dataSource="contacts" :columns="columns" :pagination="pagination" rowKey="id"
        @change="handleTableChange">
        <template #bodyCell="{ column, index, record }">
          <!-- STT -->
          <template v-if="column.key === 'index'">
            {{ (pagination.current - 1) * pagination.pageSize + index + 1 }}
          </template>

          <!-- MESSAGE -->
          <template v-else-if="column.key === 'message'">
            <div class="max-w-[350px] truncate">
              {{ record.message }}
            </div>
          </template>

          <!-- STATUS -->
          <template v-else-if="column.key === 'status'">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold" :class="record.status === 'new'
              ? 'bg-red-100 text-red-700'
              : 'bg-green-100 text-green-700'">
              {{ record.status === 'new' ? 'Chưa đọc' : 'Đã đọc' }}
            </span>
          </template>

          <!-- CREATED AT -->
          <template v-else-if="column.key === 'created_at'">
            {{ new Date(record.created_at).toLocaleString("vi-VN") }}
          </template>

          <!-- ACTION -->
          <template v-else-if="column.key === 'action'">
            <a-space class="">
              <!-- MARK AS READ -->
              <!-- <Tooltip title="Đánh dấu đã đọc">
                <a-button v-if="record.status === 'new'" type="link" class="text-green-600 hover:text-green-500"
                  @click="markAsRead(record)">
                  <CheckCircleOutlined />
                </a-button>
              </Tooltip> -->
              <Tooltip title="Xem chi tiết">
                <a-button type="link" class="text-blue-600 hover:text-blue-500"
                  @click="router.visit(route('admin.contacts.show', record.id))">
                  <EyeOutlined />
                </a-button>
              </Tooltip>

              <!-- DELETE -->
              <Tooltip title="Xóa liên hệ">
                <a-button type="link" class="text-red-600! hover:text-red-400!" @click.stop="deleteContact(record.id)">
                  <DeleteOutlined />
                </a-button>
              </Tooltip>
            </a-space>
          </template>
        </template>
      </a-table>
    </a-card>
  </div>
</template>

<script setup>
import admin from "@/layouts/admin.vue";
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import api from "@/api";
import { Tooltip, Modal, message } from "ant-design-vue";
import { DeleteOutlined, CheckCircleOutlined, ExclamationCircleOutlined, EyeOutlined } from "@ant-design/icons-vue";
import { h } from "vue";

defineOptions({
  layout: admin,
});

const page = usePage();

// DATA (server-side)
const contacts = ref(page.props.contacts.data);

// PAGINATION (server-side)
const pagination = ref({
  current: page.props.contacts.current_page,
  total: page.props.contacts.total,
  pageSize: page.props.contacts.per_page,
});

// TABLE CHANGE → reload page
function handleTableChange(p) {
  router.visit(`/admin/contacts?page=${p.current}`, {
    preserveScroll: true,
    preserveState: false,
  });
}

// COLUMNS
const columns = [
  { title: "#", key: "index", width: 60, align: "center" },
  { title: "Họ tên", dataIndex: "name", key: "name", width: 150, },
  { title: "SĐT", dataIndex: "phone", key: "phone", width: 150 },
  { title: "Email", dataIndex: "email", key: "email", width: 150 },
  {
    title: "Trạng thái",
    key: "status",
    width: 120,
    align: "center",
  },
  {
    title: "Hành động",
    key: "action",
    width: 160,
    align: "center"
  },
];

// ACTION
// async function markAsRead(record) {
//   try {
//     await api.put(route("admin.contacts.markAsRead", record.id));
//     record.status = "read";
//     message.success("Đã đánh dấu liên hệ là đã đọc");
//   } catch (error) {
//     console.error(error);
//     message.error("Không thể cập nhật trạng thái");
//   }
// }

// function viewContact(record) {
//   Modal.info({
//     title: "Chi tiết liên hệ",
//     width: 600,
//     okText: "Đóng",
//     content: h("div", { class: "space-y-3" }, [
//       h("p", [h("strong", "Họ tên: "), record.name]),
//       h("p", [h("strong", "Email: "), record.email]),
//       h("p", [h("strong", "SĐT: "), record.phone]),
//       h("p", [h("strong", "Nội dung:")]),
//       h(
//         "div",
//         {
//           class:
//             "p-3 bg-gray-100 rounded-md whitespace-pre-line text-gray-800",
//         },
//         record.message
//       ),
//       h(
//         "p",
//         { class: "text-sm text-gray-500 mt-2" },
//         "Gửi lúc: " + new Date(record.created_at).toLocaleString("vi-VN")
//       ),
//     ]),
//   });

//   if (record.status === "new") {
//     markAsRead(record);
//   }
// }

async function deleteContact(id) {
  Modal.confirm({
    title: "Xác nhận xóa liên hệ",
    icon: h(ExclamationCircleOutlined),
    content: "Bạn có chắc chắn muốn xóa liên hệ này? Hành động này không thể hoàn tác.",
    okText: "Xóa",
    okType: "danger",
    cancelText: "Hủy",

    async onOk() {
      try {
        await api.delete(`/admin/contacts/${id}`);

        message.success("Xóa liên hệ thành công!");

        contacts.value = contacts.value.filter(
          (c) => c.id !== id
        );
        pagination.value.total--;
      } catch (error) {
        console.error(error);
        message.error("Xóa liên hệ thất bại!");
      }
    },
  });
}
</script>

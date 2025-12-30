<template>
  <div class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300">
    <a-card title="Quản lý tin tức" :bordered="false">
      <!-- Nút tạo tin tức -->
      <template #extra>
        <Link :href="route('admin.news.create')"
          class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-white! bg-[#8F0000]! hover:bg-[#7A0000]! rounded-full shadow transition-all duration-200">
          <span>Tạo tin tức</span>
        </Link>
      </template>

      <!-- Bảng -->
      <a-table :dataSource="news" :columns="columns" :scroll="{ x: 'max-content' }" :pagination="pagination"
        @change="handleTableChange" rowKey="id">
        <template #bodyCell="{ column, index, record }">
          <!-- STT -->
          <template v-if="column.key === 'index'">
            {{ (pagination.current - 1) * pagination.pageSize + index + 1 }}
          </template>

          <!-- Thumbnail -->
          <template v-else-if="column.key === 'thumbnail'">
            <img
              :src="record.thumbnail_base64 ?? `/storage/${record.thumbnail}`"
              class="w-20 h-14 object-cover rounded border"
              @error="(e) => (e.target.src = '/images/no-image.png')"
            />
          </template>

          <!-- Category -->
          <template v-if="column.key === 'category'">
            <div v-if="record.category" class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white"
              :class="categoryClass(record.category.id)">
              {{ record.category.name }}
            </div>

            <div v-else class="inline-block px-3 py-1 rounded-full text-xs bg-gray-300 text-gray-700">
              Không có
            </div>
          </template>

          <!-- Created At -->
          <template v-if="column.key === 'created_at'">
            {{ new Date(record.created_at).toLocaleDateString("vi-VN") }}
          </template>

          <!-- Action -->
          <template v-if="column.key === 'action'">
            <a-space>
              <a-button @click="editNews(record.id)" type="link" class="text-blue-600">
                <EditOutlined />
              </a-button>

              <a-button @click="deleteNews(record.id)" type="link" class="text-red-600! hover:text-red-400!">
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
import { ref, h } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";
import { Modal, message } from "ant-design-vue";
import {
  ExclamationCircleOutlined,
  DeleteOutlined,
  EditOutlined,
} from "@ant-design/icons-vue";
import admin from "../../../layouts/admin.vue";

defineOptions({
  layout: admin,
});

const { props } = usePage();

// Lấy news từ server
const news = ref(props.news.data);

const pagination = ref({
  current: props.news.current_page,
  total: props.news.total,
  pageSize: props.news.per_page,
});

// Cột bảng
const columns = [
  { title: "#", key: "index" },
  {
    title: "Thumbnail",
    key: "thumbnail",
    dataIndex: "thumbnail",
    align: "center",
  },
  {
    title: "Tiêu đề",
    key: "title",
    dataIndex: "title",
    ellipsis: { showTitle: false },
    className: "title-col",
  },
  { title: "Danh mục", key: "category", align: "left" },
  { title: "Tác giả", key: "author", dataIndex: "author" },
  { title: "Ngày tạo", key: "created_at", align: "center" },
  { title: "Hành động", key: "action", align: "center", fixed: "right" },
];

function handleTableChange(p) {
  router.visit(`/admin/news?page=${p.current}`, {
    preserveScroll: true,
    preserveState: false,
  });
}

function categoryClass(id) {
  return (
    {
      1: "bg-gray-500", // Tin tức
      2: "bg-[#003505]", // Tin tức thị trường
      3: "bg-[#0077B6]", // Quy hoạch vùng
      4: "bg-[#830000]", // Trần Gia Holding
    }[id] || "bg-gray-400"
  );
}

function deleteNews(id) {
  Modal.confirm({
    title: "Bạn có chắc muốn xóa tin tức này?",
    icon: h(ExclamationCircleOutlined),
    okText: "Xóa",
    okType: "danger",
    cancelText: "Hủy",

    async onOk() {
      await router.post(
        `/admin/news/${id}/destroy`,
        {},
        {
          preserveScroll: true,
          onSuccess: () => {
            message.success("Đã xóa tin tức!");
            router.visit('/admin/news', {
              preserveScroll: true,
              replace: true,
            });
          }
        }
      );
    },
  });
}
function editNews(id) {
  router.visit(`/admin/news/${id}/edit`, {
    preserveScroll: true,
  });
}
</script>

<style>
.title-col {
  max-width: 350px !important;
  white-space: nowrap !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  display: inline-block !important;
}
</style>

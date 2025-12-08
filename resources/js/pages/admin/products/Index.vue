<template>
  <div class="w-full">
    <CustomTable
      :data="products"
      :columns="columns"
      :pagination="pagination"
      :getThumbnail="getThumbnail"
      :categoryClass="categoryClass"
      @change="handleTableChange"
    >
      <template #action="{ record }">
        <a-button
          @click="editProduct(record.id)"
          type="link"
          class="text-blue-600"
          title="Sửa sản phẩm"
        >
          <EditOutlined />
        </a-button>
        <a-button
          @click="deleteProduct(record.id)"
          type="link"
          class="!text-red-600 hover:!text-red-400"
          title="Xóa sản phẩm"
        >
          <DeleteOutlined />
        </a-button>
      </template>
    </CustomTable>
  </div>
</template>

<script setup>
import admin from "@/layouts/admin.vue";
import CustomTable from "@/components/admin/CustomTable.vue";
import { EditOutlined, DeleteOutlined } from "@ant-design/icons-vue";
import { ref } from "vue";

// Sample/mock setup, replace with real logic
const products = ref([]);
const columns = ref([
  { title: 'ID', dataIndex: 'id', key: 'id' },
  { title: 'Tên sản phẩm', dataIndex: 'name', key: 'name' },
  { title: 'Hình ảnh', dataIndex: 'thumbnail', key: 'thumbnail', slot: 'thumbnail' },
  { title: 'Danh mục', dataIndex: 'category', key: 'category' },
  { title: 'Hành động', key: 'action', slot: 'action' },
]);
const pagination = ref({
  current: 1,
  pageSize: 10,
  total: 0,
});

function getThumbnail(record) {
  // Giả sử record.thumbnail là URL
  return record.thumbnail || '/images/no-image.png';
}

function categoryClass(record) {
  return '';
}

function handleTableChange(pagination, filters, sorter) {
  // Xử lý khi thay đổi page, bộ lọc, sắp xếp
}

function editProduct(id) {
  // Xử lý sửa sản phẩm
}

function deleteProduct(id) {
  // Xử lý xóa sản phẩm
}

defineOptions({
  layout: admin,
});
</script>
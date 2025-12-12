<template>
  <div class="w-full">
    <CustomTable
      :title="'Danh Sách Sản Phẩm'"
      :data="products"
      :columns="columns"
      :pagination="pagination"
      :getThumbnail="getThumbnail"
      :categoryClass="categoryClass"
      @change="handleTableChange"
    >
      <template #btn>
        <div class="flex justify-end gap-2">
          <Link :href="route('admin.products.create')">
            <a-button type="primary">Thêm Sản Phẩm</a-button>
          </Link>
          <Link :href="route('admin.products.categories.create')">
            <a-button>Thêm Loại</a-button>
          </Link>
        </div>
      </template>
      <template #is_highlight="{ record }">
        <a-switch
          :checked="record.is_highlight"
          @change="toggleHighlight(record)"
          checked-children="Có"
          un-checked-children="Không"
        />
      </template>
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
import { ref } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import { EditOutlined, DeleteOutlined } from "@ant-design/icons-vue";
import api from "@/api";
import { message } from "ant-design-vue";

const page = usePage();
const products = ref(page.props.products || []);

const columns = ref([
  { title: 'Tên sản phẩm', dataIndex: 'name', key: 'name' },
  { title: 'Loại', dataIndex: 'product_type_name', key: 'product_type_name' },
  { title: 'Hình ảnh', dataIndex: 'thumbnail', key: 'thumbnail', slot: 'thumbnail' },
  { title: 'Nổi bật', key: 'is_highlight', slot: 'is_highlight', width: 100, align: 'center' },
  { title: 'Hành động', key: 'action', slot: 'action' },
]);

const pagination = ref({
  current: 1,
  pageSize: 10,
  total: products.value.length || 0,
});

function getThumbnail(record) {
  return record.thumbnail || '/images/no-image.png';
}

function categoryClass(record) {
  return '';
}

function handleTableChange(newPagination, filters, sorter) {
  pagination.value = {
    ...pagination.value,
    current: newPagination.current,
    pageSize: newPagination.pageSize,
  };
}

function editProduct(id) {
  window.location.href = route('admin.products.edit', id);
}

async function toggleHighlight(record) {
  try {
    const response = await api.post(route('admin.products.toggleHighlight', record.id));
    
    if (response.data.success) {
      // Cập nhật giá trị trong local state
      record.is_highlight = response.data.data.is_highlight;
      message.success('Cập nhật thành công!');
    } else {
      message.error(response.data.message || 'Cập nhật thất bại');
    }
  } catch (error) {
    console.error('Error toggling highlight:', error);
    message.error('Có lỗi xảy ra khi cập nhật');
  }
}

function deleteProduct(id) {
  // Xử lý xóa sản phẩm - có thể thêm confirmation modal
  if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
    // Gọi API xóa
    // Có thể implement sau
  }
}

defineOptions({
  layout: admin,
});
</script>
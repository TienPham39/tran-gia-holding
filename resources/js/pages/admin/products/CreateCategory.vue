<template>
  <div class="w-full">
    <AddableTable
      :title="'Quản lý Danh Mục'"
      :data="categories"
      :columns="columns"
      :pagination="pagination"
      save-route="admin.products.categories.store"
      edit-route="admin.products.types.update"
      delete-route="admin.products.types.delete"
      @change="handleTableChange"
      @save="handleSave"
      @update="handleUpdate"
      @delete="handleDelete"
    />
  </div>
</template>

<script setup>
import admin from "@/layouts/admin.vue";
import AddableTable from "@/components/admin/AddableTable.vue";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import api from "@/api";
import { message } from "ant-design-vue";

defineOptions({
  layout: admin,
});

// Lấy dữ liệu từ server nếu có
const page = usePage();
const categories = ref(page.props.categories || []);
const loading = ref(false);

// Định nghĩa các cột
// Ví dụ: columns = [A, B, C, D, Action]
// data sẽ có các field tương ứng: { a: valueA, b: valueB, c: valueC, d: valueD }
const columns = ref([
  { 
    title: 'Tên danh mục', 
    dataIndex: 'name', 
    key: 'name',
    type: 'text' // Mặc định là text input
  },
  { 
    title: 'Slug', 
    dataIndex: 'slug', 
    key: 'slug', 
    type: 'text' // Textarea cho mô tả dài
  },
  { 
    title: 'Hành động', 
    key: 'action' 
  },
]);

const pagination = ref({
  current: 1,
  pageSize: 10,
  total: categories.value.length || 0,
});

// Hàm lấy dữ liệu product types
async function fetchProductTypes() {
  loading.value = true;
  try {
    const response = await api.get(route('admin.products.types'));
    if (response.data.success && response.data.data) {
      categories.value = response.data.data;
      pagination.value.total = categories.value.length;
    }
  } catch (error) {
    console.error("Error fetching product types:", error);
    message.error("Không thể tải dữ liệu danh mục!");
  } finally {
    loading.value = false;
  }
}

// Lấy dữ liệu khi component được mount
onMounted(() => {
  fetchProductTypes();
});

function handleTableChange(pagination, filters, sorter) {
  // Xử lý khi thay đổi page, bộ lọc, sắp xếp
  console.log("Table changed:", { pagination, filters, sorter });
}

function handleSave(data) {
  // Xử lý trước khi lưu nếu cần
  console.log("Saving data:", data);
  // Sau khi lưu thành công, reload dữ liệu
  fetchProductTypes();
}

function handleUpdate(id) {
  // Sau khi cập nhật thành công, reload dữ liệu
  fetchProductTypes();
}

function handleDelete(id) {
  // Sau khi xóa thành công, reload dữ liệu
  fetchProductTypes();
}
</script>

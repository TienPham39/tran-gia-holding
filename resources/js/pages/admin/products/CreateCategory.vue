<template>
  <div class="w-full">
    <AddableTable
      :title="'Quản lý Danh Mục Sản Phẩm'"
      :data="categories"
      :columns="columns"
      :pagination="pagination"
      save-route="admin.products.categories.store"
      edit-route="admin.products.types.update"
      delete-route="admin.products.types.delete"
      :auto-reload="false"
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

// Định nghĩa các cột (không hiển thị slug trong giao diện)
const columns = ref([
  { 
    title: 'Tên danh mục', 
    dataIndex: 'name', 
    key: 'name',
    type: 'text',
    required: true
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

// Hàm lấy dữ liệu product types (categories)
async function fetchProductTypes() {
  loading.value = true;
  try {
    const response = await api.get(route('admin.products.types'));
    if (response.data.success && response.data.data) {
      categories.value = response.data.data;
      pagination.value.total = categories.value.length;
    } else {
      categories.value = [];
      pagination.value.total = 0;
    }
  } catch (error) {
    console.error("Error fetching product types:", error);
    message.error("Không thể tải dữ liệu danh mục!");
    categories.value = [];
    pagination.value.total = 0;
  } finally {
    loading.value = false;
  }
}

// Lấy dữ liệu khi component được mount
// Nếu đã có dữ liệu từ Inertia props, vẫn fetch lại để đảm bảo dữ liệu mới nhất
onMounted(() => {
  // Cập nhật pagination với dữ liệu hiện có
  if (categories.value.length > 0) {
    pagination.value.total = categories.value.length;
  }
  // Fetch lại để đảm bảo dữ liệu mới nhất
  fetchProductTypes();
});

// Xử lý khi thay đổi pagination, filters, sorter
function handleTableChange(newPagination, filters, sorter) {
  pagination.value = {
    ...pagination.value,
    current: newPagination.current,
    pageSize: newPagination.pageSize,
  };
}

// Xử lý sau khi lưu thành công
// Fetch lại dữ liệu ngay sau khi save thành công để cập nhật danh sách
function handleSave(data) {
  console.log("Data saved:", data);
  // Fetch lại dữ liệu ngay lập tức để cập nhật danh sách
  // Sử dụng setTimeout nhỏ để đảm bảo server đã xử lý xong request
  setTimeout(() => {
    fetchProductTypes();
  }, 300);
}

// Xử lý sau khi cập nhật thành công
function handleUpdate(id, data) {
  console.log("Data updated:", { id, data });
  // Fetch lại dữ liệu sau khi update
  fetchProductTypes();
}

// Xử lý sau khi xóa thành công
function handleDelete(id) {
  console.log("Data deleted:", id);
  // Fetch lại dữ liệu sau khi delete
  fetchProductTypes();
}
</script>

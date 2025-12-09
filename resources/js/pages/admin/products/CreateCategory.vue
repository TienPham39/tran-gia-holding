<template>
  <div class="w-full">
    <AddableTable
      :title="'Quản lý Danh Mục'"
      :data="categories"
      :columns="columns"
      :pagination="pagination"
      save-route="admin.products.createCategory"
      @change="handleTableChange"
      @save="handleSave"
    />
  </div>
</template>

<script setup>
import admin from "@/layouts/admin.vue";
import AddableTable from "@/components/admin/AddableTable.vue";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
  layout: admin,
});

// Lấy dữ liệu từ server nếu có
const page = usePage();
const categories = ref(page.props.categories || []);

// Định nghĩa các cột
// Ví dụ: columns = [A, B, C, D, Action]
// data sẽ có các field tương ứng: { a: valueA, b: valueB, c: valueC, d: valueD }
const columns = ref([
  { 
    title: 'Tên danh mục', 
    dataIndex: 'name', 
    key: 'name' 
  },
  { 
    title: 'Mô tả', 
    dataIndex: 'description', 
    key: 'description' 
  },
  { 
    title: 'Slug', 
    dataIndex: 'slug', 
    key: 'slug' 
  },
  { 
    title: 'Trạng thái', 
    dataIndex: 'status', 
    key: 'status' 
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

function handleTableChange(pagination, filters, sorter) {
  // Xử lý khi thay đổi page, bộ lọc, sắp xếp
  console.log("Table changed:", { pagination, filters, sorter });
}

function handleSave(data) {
  // Xử lý trước khi lưu nếu cần
  console.log("Saving data:", data);
}
</script>

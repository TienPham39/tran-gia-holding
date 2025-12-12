<template>
  <div
    class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300"
  >
    <a-card :bordered="false">
      <template #title>
        <div class="flex items-center justify-between">
          <span>{{ title }}</span>
          <span v-if="$slots.btn">
            <slot name="btn"></slot>
          </span>
        </div>
      </template>
      <template v-if="$slots.extra" #extra>
        <slot name="extra"></slot>
      </template>

      <!-- Bảng -->
      <a-table
        :dataSource="data"
        :columns="processedColumns"
        :scroll="{ x: 'max-content' }"
        :pagination="pagination"
        @change="handleTableChange"
        rowKey="id"
      >
        <template #bodyCell="{ column, index, record }">
          <!-- STT -->
          <template v-if="column.key === 'index'">
            {{ (pagination.current - 1) * pagination.pageSize + index + 1 }}
          </template>

          <!-- Thumbnail slot -->
          <template v-else-if="column.key === 'thumbnail' && $slots.thumbnail">
            <slot name="thumbnail" :record="record" :index="index"></slot>
          </template>
          <template v-else-if="column.key === 'thumbnail' && getThumbnail">
            <img
              :src="getThumbnail(record)"
              class="w-20 h-14 object-cover rounded border"
              @error="(e) => (e.target.src = '/images/no-image.png')"
            />
          </template>

          <!-- Category slot -->
          <template v-if="column.key === 'category' && $slots.category">
            <slot name="category" :record="record"></slot>
          </template>
          <template v-else-if="column.key === 'category' && categoryClass">
            <div
              v-if="record.category"
              class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white"
              :class="categoryClass(record)"
            >
              {{ record.category.name || record.category }}
            </div>
            <div
              v-else
              class="inline-block px-3 py-1 rounded-full text-xs bg-gray-300 text-gray-700"
            >
              Không có
            </div>
          </template>

          <!-- Created At -->
          <template v-if="column.key === 'created_at'">
            {{ new Date(record.created_at).toLocaleDateString("vi-VN") }}
          </template>

          <!-- Action slot -->
          <template v-else-if="column.key === 'action' && $slots.action">
            <slot name="action" :record="record" :index="index"></slot>
          </template>

          <!-- is_highlight slot -->
          <template v-else-if="column.key === 'is_highlight' && $slots.is_highlight">
            <slot name="is_highlight" :record="record" :index="index"></slot>
          </template>

          <!-- Custom slot cho các cột khác -->
          <template v-else-if="column.slot && $slots[column.slot]">
            <slot :name="column.slot" :record="record" :column="column" :index="index"></slot>
          </template>

          <!-- Default slot cho các cột khác -->
          <template v-else-if="column.slot">
            <slot :name="column.slot" :record="record" :column="column" :index="index"></slot>
          </template>

          <!-- Hiển thị giá trị mặc định -->
          <template v-else>
            {{ record[column.dataIndex || column.key] }}
          </template>
        </template>
      </a-table>
    </a-card>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  // Dữ liệu bảng dạng array
  data: {
    type: Array,
    required: true,
    default: () => [],
  },
  // Các cột hiển thị dạng array
  columns: {
    type: Array,
    required: true,
    default: () => [],
  },
  // Cấu hình phân trang
  pagination: {
    type: Object,
    required: true,
    default: () => ({
      current: 1,
      pageSize: 10,
      total: 0,
    }),
  },
  // Hàm lấy thumbnail theo record
  getThumbnail: {
    type: Function,
    default: null,
  },
  // Hàm lấy class cho category
  categoryClass: {
    type: Function,
    default: null,
  },
  // Tiêu đề card
  title: {
    type: String,
    default: "Quản lý",
  },
});

const emit = defineEmits(["change"]);

// Xử lý columns để thêm cột STT nếu cần
const processedColumns = computed(() => {
  const cols = [...props.columns];
  
  // Kiểm tra xem đã có cột index chưa
  const hasIndex = cols.some((col) => col.key === "index");
  
  if (!hasIndex) {
    cols.unshift({ title: "#", key: "index", width: 60, align: "center" });
  }
  
  return cols;
});

function handleTableChange(pagination, filters, sorter) {
  emit("change", pagination, filters, sorter);
}
</script>

<style scoped>
.title-col {
  max-width: 350px !important;
  white-space: nowrap !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  display: inline-block !important;
}
</style>

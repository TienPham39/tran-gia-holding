<template>
  <div
    class="bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-2xl transition-shadow duration-300"
  >
    <a-card :bordered="false">
      <template #title>
        <div class="flex items-center justify-between">
          <span>{{ title }}</span>
          <span>
            <a-button 
              type="primary" 
              @click="toggleAddMode"
              :disabled="isAdding"
            >
              {{ isAdding ? 'Đang thêm...' : 'Thêm mới' }}
            </a-button>
          </span>
        </div>
      </template>

      <!-- Bảng -->
      <a-table
        :dataSource="tableData"
        :columns="processedColumns"
        :scroll="{ x: 'max-content' }"
        :pagination="pagination"
        @change="handleTableChange"
        rowKey="id"
      >
        <template #bodyCell="{ column, index, record }">
          <!-- Dòng thêm mới -->
          <template v-if="record.isNewRow">
            <!-- Input cho các cột (trừ Action và index) -->
            <template v-if="column.key !== 'action' && column.key !== 'index'">
              <!-- Dropdown Select -->
              <a-select
                v-if="column.type === 'select'"
                v-model:value="newRowData[column.dataIndex || column.key]"
                :placeholder="`Chọn ${column.title}`"
                class="w-full"
                :allowClear="column.allowClear !== false"
              >
                <a-select-option
                  v-for="option in column.options || []"
                  :key="option.value"
                  :value="option.value"
                >
                  {{ option.label }}
                </a-select-option>
              </a-select>

              <!-- Number Input -->
              <a-input-number
                v-else-if="column.type === 'number'"
                v-model:value="newRowData[column.dataIndex || column.key]"
                :placeholder="`Nhập ${column.title}`"
                class="w-full"
                :min="column.min"
                :max="column.max"
                :step="column.step"
              />

              <!-- Textarea -->
              <a-input
                v-else-if="column.type === 'textarea'"
                v-model:value="newRowData[column.dataIndex || column.key]"
                :placeholder="`Nhập ${column.title}`"
                class="w-full"
                type="textarea"
                :rows="column.rows || 3"
                :autoSize="column.autoSize"
              />

              <!-- Date Picker -->
              <a-date-picker
                v-else-if="column.type === 'date'"
                v-model:value="newRowData[column.dataIndex || column.key]"
                :placeholder="`Chọn ${column.title}`"
                class="w-full"
                :format="column.format || 'DD/MM/YYYY'"
              />

              <!-- Default Text Input -->
              <a-input
                v-else
                v-model:value="newRowData[column.dataIndex || column.key]"
                :placeholder="`Nhập ${column.title}`"
                class="w-full"
                :type="column.type || 'text'"
                :maxLength="column.maxLength"
              />
            </template>
            
            <!-- Cột Action với nút check -->
            <template v-else-if="column.key === 'action'">
              <a-space>
                <a-button
                  type="primary"
                  shape="circle"
                  :loading="isSaving"
                  @click="handleSave"
                >
                  <template #icon>
                    <CheckOutlined />
                  </template>
                </a-button>
                <a-button
                  type="default"
                  shape="circle"
                  @click="cancelAdd"
                >
                  <template #icon>
                    <CloseOutlined />
                  </template>
                </a-button>
              </a-space>
            </template>
          </template>

          <!-- Dòng dữ liệu bình thường -->
          <template v-else>
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
            <template v-if="column.key === 'action' && $slots.action">
              <slot name="action" :record="record" :index="index"></slot>
            </template>

            <!-- Action buttons (Edit & Delete) -->
            <template v-else-if="column.key === 'action' && !record.isEditing">
              <a-space>
                <a-button
                  v-if="editRoute"
                  type="link"
                  class="text-blue-600"
                  @click="handleEdit(record)"
                  title="Chỉnh sửa"
                >
                  <EditOutlined />
                </a-button>
                <a-button
                  v-if="deleteRoute"
                  type="link"
                  class="!text-red-600 hover:!text-red-400"
                  @click="handleDelete(record)"
                  title="Xóa"
                >
                  <DeleteOutlined />
                </a-button>
              </a-space>
            </template>

            <!-- Edit mode inputs -->
            <template v-else-if="column.key !== 'action' && column.key !== 'index' && record.isEditing">
              <!-- Dropdown Select -->
              <a-select
                v-if="column.type === 'select'"
                v-model:value="editingData[record.id][column.dataIndex || column.key]"
                :placeholder="`Chọn ${column.title}`"
                class="w-full"
                :allowClear="column.allowClear !== false"
              >
                <a-select-option
                  v-for="option in column.options || []"
                  :key="option.value"
                  :value="option.value"
                >
                  {{ option.label }}
                </a-select-option>
              </a-select>

              <!-- Number Input -->
              <a-input-number
                v-else-if="column.type === 'number'"
                v-model:value="editingData[record.id][column.dataIndex || column.key]"
                :placeholder="`Nhập ${column.title}`"
                class="w-full"
                :min="column.min"
                :max="column.max"
                :step="column.step"
              />

              <!-- Textarea -->
              <a-input
                v-else-if="column.type === 'textarea'"
                v-model:value="editingData[record.id][column.dataIndex || column.key]"
                :placeholder="`Nhập ${column.title}`"
                class="w-full"
                type="textarea"
                :rows="column.rows || 3"
                :autoSize="column.autoSize"
              />

              <!-- Date Picker -->
              <a-date-picker
                v-else-if="column.type === 'date'"
                v-model:value="editingData[record.id][column.dataIndex || column.key]"
                :placeholder="`Chọn ${column.title}`"
                class="w-full"
                :format="column.format || 'DD/MM/YYYY'"
              />

              <!-- Default Text Input -->
              <a-input
                v-else
                v-model:value="editingData[record.id][column.dataIndex || column.key]"
                :placeholder="`Nhập ${column.title}`"
                class="w-full"
                :type="column.type || 'text'"
                :maxLength="column.maxLength"
              />
            </template>

            <!-- Action buttons in edit mode -->
            <template v-else-if="column.key === 'action' && record.isEditing">
              <a-space>
                <a-button
                  type="primary"
                  shape="circle"
                  :loading="isUpdating[record.id]"
                  @click="handleUpdate(record)"
                >
                  <template #icon>
                    <CheckOutlined />
                  </template>
                </a-button>
                <a-button
                  type="default"
                  shape="circle"
                  @click="cancelEdit(record)"
                >
                  <template #icon>
                    <CloseOutlined />
                  </template>
                </a-button>
              </a-space>
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
        </template>
      </a-table>
    </a-card>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { Modal, message } from "ant-design-vue";
import { CheckOutlined, CloseOutlined, EditOutlined, DeleteOutlined } from "@ant-design/icons-vue";
import { createVNode } from "vue";
import { ExclamationCircleOutlined } from "@ant-design/icons-vue";
import api from "@/api";

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
  // Route để POST dữ liệu
  saveRoute: {
    type: String,
    default: "admin.products.categories.store",
  },
  // Route để PUT cập nhật dữ liệu (cần có {id} placeholder)
  editRoute: {
    type: String,
    default: null,
  },
  // Route để DELETE xóa dữ liệu (cần có {id} placeholder)
  deleteRoute: {
    type: String,
    default: null,
  },
});

const emit = defineEmits(["change", "save", "update", "delete"]);

// State cho chế độ thêm mới
const isAdding = ref(false);
const isSaving = ref(false);
const newRowData = ref({});

// State cho chế độ chỉnh sửa
const editingData = ref({});
const isUpdating = ref({});

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

// Dữ liệu bảng bao gồm cả dòng thêm mới và đang chỉnh sửa
const tableData = computed(() => {
  const data = props.data.map(item => ({
    ...item,
    isEditing: editingData.value[item.id] !== undefined,
  }));
  
  // Nếu đang ở chế độ thêm mới, thêm dòng input vào đầu bảng
  if (isAdding.value) {
    data.unshift({
      id: 'new-row',
      isNewRow: true,
      ...newRowData.value
    });
  }
  
  return data;
});

// Lấy danh sách các cột cần input (loại bỏ Action và index)
const inputColumns = computed(() => {
  return props.columns.filter(
    col => col.key !== 'action' && col.key !== 'index'
  );
});

// Bật/tắt chế độ thêm mới
function toggleAddMode() {
  if (isAdding.value) {
    cancelAdd();
  } else {
    isAdding.value = true;
    // Khởi tạo object rỗng cho các cột input
    newRowData.value = {};
    inputColumns.value.forEach(col => {
      newRowData.value[col.dataIndex || col.key] = '';
    });
  }
}

// Hủy thêm mới
function cancelAdd() {
  isAdding.value = false;
  newRowData.value = {};
}

// Xử lý lưu dữ liệu
function handleSave() {
  // Kiểm tra dữ liệu có đầy đủ không
  const emptyFields = inputColumns.value.filter(col => {
    const key = col.dataIndex || col.key;
    return !newRowData.value[key] || newRowData.value[key].toString().trim() === '';
  });

  if (emptyFields.length > 0) {
    message.warning('Vui lòng điền đầy đủ thông tin!');
    return;
  }

  // Hiển thị xác nhận
  Modal.confirm({
    title: "Xác nhận",
    icon: createVNode(ExclamationCircleOutlined),
    content: "Bạn có chắc chắn muốn Lưu?",
    okText: "Lưu",
    okType: "primary",
    cancelText: "Hủy",
    async onOk() {
      isSaving.value = true;
      
      try {
        // Emit event để parent component xử lý
        emit("save", newRowData.value);
        
        // POST dữ liệu đến route
        await router.post(route(props.saveRoute), newRowData.value, {
          preserveScroll: true,
          onSuccess: () => {
            message.success("Lưu thành công!");
            cancelAdd();
            // Reload trang để cập nhật dữ liệu
            router.reload();
          },
          onError: (errors) => {
            message.error("Lưu thất bại! Vui lòng thử lại.");
            console.error("Errors:", errors);
          },
          onFinish: () => {
            isSaving.value = false;
          },
        });
      } catch (error) {
        console.error("Save error:", error);
        message.error("Đã xảy ra lỗi khi lưu!");
        isSaving.value = false;
      }
    },
  });
}

function handleTableChange(pagination, filters, sorter) {
  emit("change", pagination, filters, sorter);
}

// Xử lý chỉnh sửa
function handleEdit(record) {
  // Khởi tạo dữ liệu chỉnh sửa cho record này
  editingData.value[record.id] = {};
  inputColumns.value.forEach(col => {
    const key = col.dataIndex || col.key;
    editingData.value[record.id][key] = record[key] || '';
  });
}

// Hủy chỉnh sửa
function cancelEdit(record) {
  delete editingData.value[record.id];
}

// Xử lý cập nhật
async function handleUpdate(record) {
  const data = editingData.value[record.id];
  
  // Kiểm tra dữ liệu có đầy đủ không
  const emptyFields = inputColumns.value.filter(col => {
    const key = col.dataIndex || col.key;
    return !data[key] || data[key].toString().trim() === '';
  });

  if (emptyFields.length > 0) {
    message.warning('Vui lòng điền đầy đủ thông tin!');
    return;
  }

  if (!props.editRoute) {
    message.error('Edit route chưa được cấu hình!');
    return;
  }

  // Hiển thị xác nhận
  Modal.confirm({
    title: "Xác nhận",
    icon: createVNode(ExclamationCircleOutlined),
    content: "Bạn có chắc chắn muốn cập nhật?",
    okText: "Cập nhật",
    okType: "primary",
    cancelText: "Hủy",
    async onOk() {
      isUpdating.value[record.id] = true;
      
      try {
        // PUT dữ liệu đến route
        const routeUrl = route(props.editRoute, record.id);
        await api.put(routeUrl, data);
        
        message.success("Cập nhật thành công!");
        cancelEdit(record);
        
        // Emit event để parent component reload dữ liệu
        emit("update", record.id, data);
      } catch (error) {
        console.error("Update error:", error);
        message.error("Cập nhật thất bại! Vui lòng thử lại.");
      } finally {
        isUpdating.value[record.id] = false;
      }
    },
  });
}

// Xử lý xóa
function handleDelete(record) {
  if (!props.deleteRoute) {
    message.error('Delete route chưa được cấu hình!');
    return;
  }

  Modal.confirm({
    title: "Xác nhận xóa",
    icon: createVNode(ExclamationCircleOutlined),
    content: "Bạn có chắc chắn muốn xóa mục này?",
    okText: "Xóa",
    okType: "danger",
    cancelText: "Hủy",
    async onOk() {
      try {
        // DELETE request đến route
        const routeUrl = route(props.deleteRoute, record.id);
        await api.delete(routeUrl);
        
        message.success("Xóa thành công!");
        
        // Emit event để parent component reload dữ liệu
        emit("delete", record.id);
      } catch (error) {
        console.error("Delete error:", error);
        message.error("Xóa thất bại! Vui lòng thử lại.");
      }
    },
  });
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


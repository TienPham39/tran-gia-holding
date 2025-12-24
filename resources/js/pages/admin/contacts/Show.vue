<template>
  <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6 max-w-full">
    <PageHeader @back="router.visit(route('admin.contacts.index'))">
      <template #title>
        <span class="font-banque text-[#8F0000]">
          Chi tiết liên hệ
        </span>
      </template>
    </PageHeader>

    <div class="font-mont grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <div>
        <p class="font-semibold text-gray-600">Họ tên</p>
        <p class="text-lg">{{ contact.name }}</p>
      </div>

      <div>
        <p class="font-semibold text-gray-600">Email</p>
        <p>{{ contact.email }}</p>
      </div>

      <div>
        <p class="font-semibold text-gray-600">Số điện thoại</p>
        <p>{{ contact.phone }}</p>
      </div>

      <div>
        <p class="font-semibold text-gray-600">Trạng thái</p>
        <a-tag :color="contact.status === 'new' ? 'red' : 'green'">
          {{ contact.status === 'new' ? 'Chưa đọc' : 'Đã đọc' }}
        </a-tag>
      </div>
    </div>

    <div class="mt-6">
      <p class="font-semibold text-gray-600 mb-2">Nội dung liên hệ</p>
      <div class="p-4 bg-gray-100 rounded-md whitespace-pre-line">
        {{ contact.message }}
      </div>
    </div>

    <div class="mt-8 flex justify-end gap-3">
      <!-- ĐÁNH DẤU ĐÃ ĐỌC -->
      <a-button v-if="contact.status === 'new'" type="primary" ghost html-type="button" @click.prevent="markAsRead">
        Đánh dấu đã đọc
      </a-button>

      <!-- XÓA -->
      <a-button danger @click="confirmDelete">
        Xóa liên hệ
      </a-button>
    </div>
  </div>
</template>

<script setup>
import admin from "@/layouts/admin.vue";
import { router, usePage } from "@inertiajs/vue3";
import { Modal, message, PageHeader } from "ant-design-vue";
import api from "@/api.js";
import { ref } from "vue";

defineOptions({ layout: admin });

const { contact } = usePage().props;

async function markAsRead() {
  try {
    await api.post(
      route("admin.contacts.markAsRead", contact.id)
    );
    contact.status = "read";
    message.success("Đã đánh dấu liên hệ là đã đọc");
  } catch (e) {
    message.error("Không thể cập nhật trạng thái");
  }
}

function confirmDelete() {
  Modal.confirm({
    title: "Xác nhận xóa liên hệ",
    content: "Bạn có chắc chắn muốn xóa liên hệ này?",
    okType: "danger",
    async onOk() {
      await router.post(route("admin.contacts.destroy", contact.id), {}, {
        onSuccess: () => {
          message.success("Đã xóa liên hệ");
        },
      });
    },
  });
}
</script>

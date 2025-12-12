<template>
  <NewsForm mode="edit" :news="news" @submit="update" @done="stopLoading" ref="newsForm" />
</template>

<script setup>
import api from "@/api.js";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { message } from "ant-design-vue";
import NewsForm from "@/components/admin/NewsForm.vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });

const news = usePage().props.news;
const newsForm = ref(null);

async function update(payload) {
  try {
    // Đảm bảo có CSRF cookie trước khi gửi
    await api.ensureCsrfCookie();
    
    // Tạo FormData để gửi file
    const formData = new FormData();
    formData.append('title', payload.title);
    formData.append('excerpt', payload.excerpt || '');
    formData.append('content', payload.content || '');
    formData.append('category_id', payload.category_id);
    
    // Thêm CSRF token vào FormData
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
      formData.append('_token', csrfToken);
    }
    
    // Thumbnail file (chỉ gửi nếu có file mới)
    if (payload.thumbnail) {
      formData.append('thumbnail', payload.thumbnail);
    }
    
    // Gallery files (chỉ gửi nếu có files mới)
    if (payload.gallery && payload.gallery.length > 0) {
      payload.gallery.forEach((file) => {
        formData.append('gallery[]', file);
      });
    }

    await api.post(`/admin/news/${news.id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      timeout: 60000, // 60 giây cho upload file
      onUploadProgress: (progressEvent) => {
        const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        console.log(`Upload progress: ${percentCompleted}%`);
      },
    });
    
    message.success("Cập nhật thành công!");
  } catch (e) {
    console.error("Lỗi cập nhật tin:", e);
    message.error("Lỗi cập nhật tin");
  } finally {
    newsForm.value?.$emit("done");
  }
}

function stopLoading() {
  newsForm.value.stopLoading();
}
</script>

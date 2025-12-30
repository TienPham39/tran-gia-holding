<template>
  <h2 class="text-xl font-bold border-b py-2 px-5 mb-2 uppercase font-banque text-[#8F0000]">
    tạo tin tức mới
  </h2>

  <NewsForm mode="create" @submit="store" ref="newsForm" @done="stopLoading"/>
</template>

<script setup>
import api from "@/api.js";
import { ref } from "vue";
import { message } from "ant-design-vue";
import NewsForm from "@/components/admin/NewsForm.vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });

const newsForm = ref(null);

async function store(payload) {
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
    
    // Thumbnail file
    if (payload.thumbnail) {
      formData.append('thumbnail', payload.thumbnail);
    }
    
    // Gallery files
    if (payload.gallery && payload.gallery.length > 0) {
      payload.gallery.forEach((file) => {
        formData.append('gallery[]', file);
      });
    }

    await api.post("/admin/news", formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      timeout: 60000, // 60 giây cho upload file
      onUploadProgress: (progressEvent) => {
        const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        console.log(`Upload progress: ${percentCompleted}%`);
      },
    });
    
    message.success("Tạo tin thành công!");
    newsForm.value.resetForm();
  } catch (e) {
    console.error("Lỗi tạo tin:", e);
    message.error("Lỗi tạo tin");
  } finally {
    newsForm.value?.$emit("done");
  }
}

function stopLoading() {
  newsForm.value.stopLoading();
}
</script>

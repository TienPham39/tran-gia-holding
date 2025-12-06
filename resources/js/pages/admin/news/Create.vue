<template>
  <NewsForm mode="create" @submit="store" ref="newsForm" />
</template>

<script setup>
import axios from "@/api.js";
import { ref } from "vue";
import { message } from "ant-design-vue";
import NewsForm from "@/components/admin/NewsForm.vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });

const newsForm = ref(null);

async function store(payload) {
  try {
    await axios.post("/admin/news", payload);
    message.success("Tạo tin thành công!");

    newsForm.value.resetForm();
  } catch (e) {
    message.error("Lỗi tạo tin");
  }
}
</script>

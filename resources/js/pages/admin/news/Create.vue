<template>
  <NewsForm mode="create" @submit="store" />
</template>

<script setup>
import axios from "@/api.js";
import { message } from "ant-design-vue";
import NewsForm from "@/components/admin/NewsForm.vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });

async function store(payload) {
  try {
    await axios.post("/admin/news", payload);
    message.success("Tạo tin thành công!");
  } catch (e) {
    message.error("Lỗi tạo tin");
  }
}
</script>

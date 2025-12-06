<template>
  <NewsForm mode="edit" :news="news" @submit="update" />
</template>

<script setup>
import axios from "@/api.js";
import { usePage } from "@inertiajs/vue3";
import { message } from "ant-design-vue";
import NewsForm from "@/components/admin/NewsForm.vue";
import admin from "../../../layouts/admin.vue";
defineOptions({ layout: admin });
const news = usePage().props.news;
async function update(payload) {
  try {
    await axios.post(`/admin/news/${news.id}`, payload);
    message.success("Cập nhật thành công!");
  } catch (e) {
    message.error("Lỗi cập nhật tin");
  }
}
</script>

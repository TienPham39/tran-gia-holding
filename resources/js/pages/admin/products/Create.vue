<template>
  <h2 class="text-xl font-bold border-b py-2 px-5 mb-4 uppercase font-banque text-[#8F0000]">
    tạo sản phẩm mới
  </h2>

  <ProductForm mode="create" :product-types="productTypes" @submit="store" ref="productForm" @done="stopLoading" />
</template>

<script setup>
import api from "@/api.js";
import { ref } from "vue";
import { message } from "ant-design-vue";
import { usePage } from "@inertiajs/vue3";
import ProductForm from "@/components/admin/ProductForm.vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });

const page = usePage();
const productTypes = ref(page.props.productTypes || []);
const productForm = ref(null);

async function store(payload) {
  console.log("=== FRONTEND: STORE FUNCTION CALLED ===");
  console.log("Payload received:", payload);
  console.log("Payload keys:", Object.keys(payload));
  console.log("Has thumbnail:", !!payload.thumbnail);
  console.log("Gallery count:", payload.gallery?.length || 0);
  console.log("Floor plan count:", payload.floor_plan?.length || 0);
  console.log("Highlights count:", payload.highlights?.length || 0);

  try {
    // Đảm bảo có CSRF cookie trước khi gửi
    console.log("Ensuring CSRF cookie...");
    await api.ensureCsrfCookie();
    console.log("CSRF cookie ensured");

    // Tạo FormData để gửi file
    const formData = new FormData();
    formData.append("name", payload.name);
    formData.append("product_type_id", payload.product_type_id);
    formData.append("status", payload.status || "Đang bán");
    formData.append("short_description", payload.short_description || "");
    formData.append("solugon", payload.solugon || "");

    // Total area - convert to number to ensure proper decimal format
    if (payload.total_area !== null && payload.total_area !== undefined && payload.total_area !== '') {
      const totalArea = parseFloat(payload.total_area);
      if (!isNaN(totalArea)) {
        formData.append("total_area", totalArea);
      }
    }

    console.log("FormData basic fields added");

    // Highlights
    if (payload.highlights && payload.highlights.length > 0) {
      payload.highlights.forEach((highlight, index) => {
        if (highlight.content) {
          formData.append(`highlights[${index}][content]`, highlight.content);
        }
      });
      console.log("Highlights added to FormData");
    }

    // Thêm CSRF token vào FormData
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      ?.getAttribute("content");
    if (csrfToken) {
      formData.append("_token", csrfToken);
      console.log("CSRF token added to FormData");
    } else {
      console.warn("CSRF token not found!");
    }

    // Thumbnail file
    if (payload.thumbnail) {
      formData.append("thumbnail", payload.thumbnail);
      console.log("Thumbnail file added to FormData");
    }

    // Gallery files
    if (payload.gallery && payload.gallery.length > 0) {
      payload.gallery.forEach((file) => {
        formData.append("gallery[]", file);
      });
      console.log(`Gallery files (${payload.gallery.length}) added to FormData`);
    }

    // Floor plan files
    if (payload.floor_plan && payload.floor_plan.length > 0) {
      payload.floor_plan.forEach((file) => {
        formData.append("floor_plan[]", file);
      });
      console.log(`Floor plan files (${payload.floor_plan.length}) added to FormData`);
    }

    // Log FormData contents
    console.log("FormData entries:");
    for (let pair of formData.entries()) {
      if (pair[1] instanceof File) {
        console.log(`${pair[0]}: [File] ${pair[1].name} (${pair[1].size} bytes)`);
      } else {
        console.log(`${pair[0]}: ${pair[1]}`);
      }
    }

    console.log("Sending POST request to /admin/products...");
    const response = await api.post("/admin/products", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
      timeout: 60000, // 60 giây cho upload file
      onUploadProgress: (progressEvent) => {
        const percentCompleted = Math.round(
          (progressEvent.loaded * 100) / progressEvent.total
        );
        console.log(`Upload progress: ${percentCompleted}%`);
      },
    });

    console.log("Response received:", response);
    console.log("Response status:", response.status);
    console.log("Response data:", response.data);
    console.log("=== FRONTEND: STORE SUCCESS ===");

    message.success("Tạo sản phẩm thành công!");
    productForm.value.resetForm();
  } catch (e) {
    console.error("=== FRONTEND: STORE ERROR ===");
    console.error("Error object:", e);
    console.error("Error message:", e.message);
    console.error("Error response:", e.response);
    console.error("Error response data:", e.response?.data);
    console.error("Error response status:", e.response?.status);

    if (e.response?.data?.error) {
      message.error(e.response.data.error);
    } else if (e.response?.data?.message) {
      message.error(e.response.data.message);
    } else {
      message.error("Lỗi tạo sản phẩm: " + (e.message || "Unknown error"));
    }
  } finally {
    productForm.value?.$emit("done");
  }
}

function stopLoading() {
  productForm.value.stopLoading();
}
</script>

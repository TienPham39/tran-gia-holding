<template>
  <ProductForm
    mode="edit"
    :product="product"
    :product-types="productTypes"
    @submit="update"
    @done="stopLoading"
    ref="productForm"
  />
</template>

<script setup>
import api from "@/api.js";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { message } from "ant-design-vue";
import ProductForm from "@/components/admin/ProductForm.vue";
import admin from "../../../layouts/admin.vue";

defineOptions({ layout: admin });

const page = usePage();
const product = ref(page.props.product);
const productTypes = ref(page.props.productTypes || []);
const productForm = ref(null);

async function update(payload) {
  try {
    // Đảm bảo có CSRF cookie trước khi gửi
    await api.ensureCsrfCookie();

    // Tạo FormData để gửi file
    const formData = new FormData();
    formData.append("name", payload.name);
    formData.append("product_type_id", payload.product_type_id);
    formData.append("status", payload.status || "Đang bán");
    formData.append("short_description", payload.short_description || "");
    formData.append("solugon", payload.solugon || "");

    // Highlights
    if (payload.highlights && payload.highlights.length > 0) {
      payload.highlights.forEach((highlight, index) => {
        if (highlight.content) {
          formData.append(`highlights[${index}][content]`, highlight.content);
        }
      });
    }

    // Thêm CSRF token vào FormData
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      ?.getAttribute("content");
    if (csrfToken) {
      formData.append("_token", csrfToken);
    }

    // Thumbnail file (chỉ gửi nếu có file mới)
    if (payload.thumbnail) {
      formData.append("thumbnail", payload.thumbnail);
    }

    // Gallery files (chỉ gửi nếu có files mới)
    if (payload.gallery && payload.gallery.length > 0) {
      payload.gallery.forEach((file) => {
        formData.append("gallery[]", file);
      });
    }

    // Floor plan files (chỉ gửi nếu có files mới)
    if (payload.floor_plan && payload.floor_plan.length > 0) {
      payload.floor_plan.forEach((file) => {
        formData.append("floor_plan[]", file);
      });
    }

    await api.put(`/admin/products/${product.value.id}`, formData, {
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

    message.success("Cập nhật sản phẩm thành công!");
  } catch (e) {
    console.error("Lỗi cập nhật sản phẩm:", e);
    if (e.response?.data?.error) {
      message.error(e.response.data.error);
    } else {
      message.error("Lỗi cập nhật sản phẩm");
    }
  } finally {
    productForm.value?.$emit("done");
  }
}

function stopLoading() {
  productForm.value.stopLoading();
}
</script>


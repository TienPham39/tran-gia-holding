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

    // Validate required fields
    const name = payload.name || product.value.name;
    const productTypeId = payload.product_type_id || product.value.product_type_id;
    
    if (!name || name.trim() === "") {
      message.error("Tên sản phẩm là bắt buộc");
      return;
    }
    if (!productTypeId || productTypeId === "" || productTypeId === null || productTypeId === undefined) {
      message.error("Loại sản phẩm là bắt buộc");
      return;
    }

    // Tạo FormData để gửi file
    const formData = new FormData();
    // Đảm bảo name và product_type_id luôn có giá trị
    formData.append("name", name.trim());
    // Convert product_type_id to integer for Laravel validation
    formData.append("product_type_id", parseInt(productTypeId, 10));
    formData.append("status", payload.status || product.value.status || "Đang bán");
    formData.append("short_description", payload.short_description || product.value.short_description || "");
    formData.append("solugon", payload.solugon || product.value.solugon || "");
    
    // Total area - convert to number to ensure proper decimal format
    if (payload.total_area !== null && payload.total_area !== undefined && payload.total_area !== '') {
      const totalArea = parseFloat(payload.total_area);
      if (!isNaN(totalArea)) {
        formData.append("total_area", totalArea);
      }
    }
    
    // Add _method for PUT request (Laravel requires this for FormData)
    formData.append("_method", "PUT");

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

    // Deleted image IDs (gửi danh sách ID ảnh cần xóa)
    if (payload.deleted_image_ids && payload.deleted_image_ids.length > 0) {
      payload.deleted_image_ids.forEach((imageId) => {
        formData.append("deleted_image_ids[]", imageId);
      });
    }

    // Use POST with _method=PUT for FormData (Laravel requirement)
    await api.post(`/admin/products/${product.value.id}`, formData, {
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
    console.error("Response data:", e.response?.data);
    
    // Hiển thị lỗi validation từ server
    if (e.response?.data?.errors) {
      const errors = e.response.data.errors;
      const errorMessages = Object.values(errors).flat().join(", ");
      message.error(errorMessages || "Có lỗi xảy ra khi cập nhật sản phẩm");
    } else if (e.response?.data?.message) {
      message.error(e.response.data.message);
    } else if (e.response?.data?.error) {
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


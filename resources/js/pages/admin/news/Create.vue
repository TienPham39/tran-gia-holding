<template>
  <div class="max-w-6xl mx-auto py-10 px-4 space-y-10">
    <!-- Title -->
    <div>
      <label class="font-bold">Tiêu đề</label>
      <input type="text" v-model="form.title" class="input w-full mt-2" />
      <p v-if="errors.title" class="text-red-600 text-sm mt-1">
        {{ errors.title[0] }}
      </p>
    </div>

    <!-- Excerpt -->
    <div>
      <label class="font-bold">Mô tả ngắn</label>
      <input
        v-model="form.excerpt"
        class="input w-full mt-2"
        rows="3"
      ></input>
      <p v-if="errors.excerpt" class="text-red-600 text-sm mt-1">
        {{ errors.excerpt[0] }}
      </p>
    </div>

    <!-- Category -->
    <div>
      <label class="font-bold">Danh mục</label>
      <select v-model="form.category_id" class="input w-full mt-2">
        <option disabled value="">-- Chọn danh mục --</option>
        <option value="1">Tin thị trường</option>
        <option value="2">Quy hoạch</option>
      </select>
      <p v-if="errors.category_id" class="text-red-600 text-sm mt-1">
        {{ errors.category_id[0] }}
      </p>
    </div>

    <!-- Thumbnail Upload -->
    <div>
      <label class="font-bold block mb-2">Thumbnail</label>

      <div class="flex items-center gap-4">
        <!-- Thumbnail Preview -->
        <div
          class="w-32 h-32 border rounded-lg flex items-center justify-center bg-gray-100 overflow-hidden"
        >
          <img
            v-if="previewThumbnail"
            :src="previewThumbnail"
            class="object-cover w-full h-full"
          />
          <span v-else class="text-gray-500 text-sm">Không có ảnh</span>
        </div>

        <!-- Upload Button -->
        <div>
          <button
            type="button"
            class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
            @click="$refs.thumbnailInput.click()"
          >
            Chọn ảnh
          </button>

          <input
            type="file"
            accept="image/*"
            class="hidden"
            ref="thumbnailInput"
            @change="onThumbnailChange"
          />
        </div>
      </div>

      <p v-if="errors.thumbnail" class="text-red-600 text-sm mt-1">
        {{ errors.thumbnail[0] }}
      </p>
    </div>

    <!-- Gallery Upload -->
    <div class="mt-8">
      <div class="flex items-center">
        <label class="font-bold block mr-4">Gallery (tối đa 6 ảnh)</label>

        <button
          type="button"
          class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
          @click="$refs.galleryInput.click()"
        >
          Chọn ảnh
        </button>
      </div>

      <input
        type="file"
        accept="image/*"
        multiple
        class="hidden"
        ref="galleryInput"
        @change="onGalleryChange"
      />

      <!-- Preview Grid -->
      <div class="grid grid-cols-3 gap-3 mt-4">
        <div
          v-for="(img, idx) in previewGallery"
          :key="idx"
          class="w-full h-32 border rounded-lg overflow-hidden bg-gray-100"
        >
          <img :src="img" class="object-cover w-full h-full" />
        </div>
      </div>

      <p v-if="errors['gallery.*']" class="text-red-600 text-sm mt-1">
        {{ errors["gallery.*"][0] }}
      </p>
    </div>

    <!-- Content -->
    <div>
      <label class="font-bold">Nội dung</label>
      <Editor
        api-key="8gvjrls4fmc9w1awqs3krbtrwq5ja5k4njpue5kehd74m4hk"
        v-model="form.content"
        :init="editorConfig"
        class="mt-2"
      />

      <p v-if="errors.content" class="text-red-600 text-sm mt-1">
        {{ errors.content[0] }}
      </p>
    </div>

    <!-- Submit Button -->
    <button
      class="px-6 py-3 bg-red-700 text-white rounded hover:bg-red-800 disabled:opacity-50"
      :disabled="isSubmitting"
      @click="submit"
    >
      <span v-if="!isSubmitting">Lưu bài viết</span>
      <span v-else>Đang lưu...</span>
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "../../../api.js";
import admin from "../../../layouts/admin.vue";
import Editor from "@tinymce/tinymce-vue";
import { message } from "ant-design-vue";

defineOptions({ layout: admin });

const form = ref({
  title: "",
  excerpt: "",
  category_id: "",
  thumbnail: null,
  gallery: [],
  content: "",
});

const errors = ref({});
const isSubmitting = ref(false);
const previewThumbnail = ref(null);
const previewGallery = ref([]);

/* Thumbnail preview */
function onThumbnailChange(e) {
  const file = e.target.files[0];
  form.value.thumbnail = file;
  previewThumbnail.value = URL.createObjectURL(file);
}

/* Gallery preview */
function onGalleryChange(e) {
  const files = Array.from(e.target.files);
  form.value.gallery = files;
  previewGallery.value = files.map((f) => URL.createObjectURL(f));
}

/* TinyMCE config */
const editorConfig = {
  height: 600,
  plugins: "lists link image code table media",
  toolbar:
    "undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image media link | code",
};

/* Submit */
async function submit() {
  errors.value = {};

  // Client-side validation
  if (!form.value.title) errors.value.title = ["Vui lòng nhập tiêu đề"];
  if (!form.value.category_id)
    errors.value.category_id = ["Vui lòng chọn danh mục"];
  if (!form.value.content)
    errors.value.content = ["Nội dung không được để trống"];

  if (Object.keys(errors.value).length > 0) return;

  if (isSubmitting.value) return;
  isSubmitting.value = true;

  const formData = new FormData();
  Object.entries(form.value).forEach(([key, val]) => {
    if (key === "gallery") {
      val.forEach((img) => formData.append("gallery[]", img));
    } else {
      formData.append(key, val);
    }
  });

  try {
    await axios.post("/admin/news", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    message.success("Tạo tin tức thành công!");

    form.value = {
      title: "",
      excerpt: "",
      category_id: "",
      thumbnail: null,
      gallery: [],
      content: "",
    };

    previewThumbnail.value = null;
    previewGallery.value = [];
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      message.error("Tạo tin tức thất bại. Vui lòng thử lại.");
    }
  } finally {
    isSubmitting.value = false;
  }
}
</script>

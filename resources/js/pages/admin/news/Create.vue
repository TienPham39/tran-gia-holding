<template>
  <div class="max-w-6xl mx-auto py-8 px-4 space-y-10 font-mont">
    <!-- Title -->
    <div>
      <label class="font-bold">Tiêu đề</label>
      <input type="text" v-model="form.title" class="input w-full mt-2" />
      <p v-if="errors.title" class="text-red-600 text-sm mt-1">
        {{ errors.title[0] }}
      </p>
    </div>

    <!-- Category -->
    <div>
      <label class="font-bold">Danh mục</label>
      <select v-model="form.category_id" class="input w-full mt-2">
        <option disabled value="">-- Chọn danh mục --</option>
        <option value="2">Tin thị trường</option>
        <option value="3">Quy hoạch vùng</option>
        <option value="4">Trần Gia Holding</option>
      </select>
      <p v-if="errors.category_id" class="text-red-600 text-sm mt-1">
        {{ errors.category_id[0] }}
      </p>
    </div>

    <!-- Excerpt -->
    <div>
      <label class="font-bold">Mô tả ngắn</label>
      <Editor v-model="form.excerpt" api-key="8gvjrls4fmc9w1awqs3krbtrwq5ja5k4njpue5kehd74m4hk"
        :init="excerptEditorInit" />

      <p v-if="errors.excerpt" class="text-red-600 text-sm mt-1">
        {{ errors.excerpt[0] }}
      </p>
    </div>

    <!-- Thumbnail Upload -->
    <div class="mt-10">
      <label class="font-bold block mb-3">Thumbnail</label>

      <!-- Dropzone -->
      <div
        class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition cursor-pointer flex flex-col items-center justify-center text-center"
        @click="$refs.thumbnailInput.click()">
        <img src="/images/upload-img.png" class="w-10 opacity-60 mb-2" />

        <p class="text-gray-600 text-sm">
          Kéo thả ảnh vào đây hoặc
          <span class="font-semibold text-blue-600 underline">chọn ảnh</span>
        </p>

        <p class="text-gray-400 text-xs">(1 ảnh – jpg, png, webp)</p>
      </div>

      <!-- Hidden Input -->
      <input type="file" accept="image/*" class="hidden" ref="thumbnailInput" @change="onThumbnailChange" />

      <!-- Counter -->
      <p class="mt-3 text-sm text-gray-600">
        Đã chọn: <span class="font-semibold">{{ previewThumbnail ? 1 : 0 }}/1</span>
      </p>

      <!-- Preview Area -->
      <div class="mt-4 w-40">
        <div v-if="previewThumbnail" class="relative group w-full h-32 rounded-lg overflow-hidden border shadow">
          <img :src="previewThumbnail" class="object-cover w-full h-full" />

          <!-- Remove Button -->
          <button @click.stop="removeThumbnail"
            class="absolute top-2 right-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
            ✕
          </button>
        </div>
      </div>

      <!-- Error -->
      <p v-if="errors.thumbnail" class="text-red-600 text-sm mt-2">
        {{ errors.thumbnail[0] }}
      </p>
    </div>


    <!-- Content -->
    <div>
      <label class="font-bold">Nội dung</label>
      <Editor v-model="form.content" api-key="8gvjrls4fmc9w1awqs3krbtrwq5ja5k4njpue5kehd74m4hk" :init="editorInit" />

      <p v-if="errors.content" class="text-red-600 text-sm mt-1">
        {{ errors.content[0] }}
      </p>
    </div>

    <!-- GALLERY UPLOAD -->
    <div class="mt-10">
      <label class="font-bold block mb-3">Gallery (tối đa 6 ảnh)</label>

      <!-- Dropzone -->
      <div
        class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition cursor-pointer flex flex-col items-center justify-center text-center"
        @click="$refs.galleryInput.click()">
        <img src="/images/upload-img.png" class="w-10 opacity-60 mb-2" />
        <p class="text-gray-600 text-sm">
          Kéo thả ảnh vào đây hoặc <span class="font-semibold text-blue-600 underline">chọn ảnh</span>
        </p>
        <p class="text-gray-400 text-xs">(Tối đa 6 ảnh – jpg, png, webp)</p>
      </div>

      <!-- Hidden Input -->
      <input type="file" accept="image/*" multiple class="hidden" ref="galleryInput" @change="onGalleryChange" />

      <!-- Counter -->
      <p class="mt-3 text-sm text-gray-600">
        Đã chọn: <span class="font-semibold">{{ previewGallery.length }}/6</span>
      </p>

      <!-- Preview Grid -->
      <div class="grid grid-cols-3 gap-4 mt-4">
        <div v-for="(img, idx) in previewGallery" :key="idx"
          class="relative group w-full h-32 rounded-lg overflow-hidden shadow">
          <!-- Image -->
          <img :src="img" class="object-cover w-full h-full" />

          <!-- Remove button -->
          <button @click.stop="removeGalleryImage(idx)"
            class="absolute top-2 right-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
            ✕
          </button>
        </div>
      </div>

      <!-- Errors -->
      <p v-if="errors.gallery" class="text-red-600 text-sm mt-2">
        {{ errors.gallery[0] }}
      </p>
    </div>

    <!-- Submit Button -->
    <button class="cursor-pointer px-6 py-3 bg-red-700 text-white rounded hover:bg-red-800 disabled:opacity-50"
      :disabled="isSubmitting" @click="submit">
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

function removeThumbnail() {
  form.value.thumbnail = null;
  previewThumbnail.value = null;
  if ($refs.thumbnailInput) {
    $refs.thumbnailInput.value = null;
  }
}

/* Gallery preview */
function onGalleryChange(e) {
  const files = Array.from(e.target.files);

  files.forEach((file) => {
    if (previewGallery.value.length < 6) {
      form.value.gallery.push(file);
      previewGallery.value.push(URL.createObjectURL(file));
    }
  });

  e.target.value = null;
}

function removeGalleryImage(index) {
  previewGallery.value.splice(index, 1);
  form.value.gallery.splice(index, 1);
}

const excerptEditorInit = {
  height: 200,
  menubar: false,
  plugins: [
    "link", "lists", "autolink", "emoticons"
  ],
  toolbar:
    "bold italic underline | bullist numlist | link | removeformat",
};

const editorInit = {
  height: 800,
  toolbar_mode: "sliding",
  plugins: [
    "anchor", "autolink", "charmap", "codesample", "emoticons", "link", "lists",
    "media", "searchreplace", "table", "visualblocks", "wordcount",
    "checklist", "mediaembed", "casechange", "formatpainter", "pageembed",
    "a11ychecker", "tinymcespellchecker", "permanentpen", "powerpaste",
    "advtable", "advcode", "advtemplate", "uploadcare", "mentions",
    "tinycomments", "tableofcontents", "footnotes", "mergetags",
    "autocorrect", "typography", "inlinecss", "markdown",
    "importword", "exportword", "exportpdf"
  ],

  toolbar:
    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | " +
    "link media table mergetags | addcomment showcomments | " +
    "spellcheckdialog a11ycheck typography uploadcare | " +
    "align lineheight | checklist numlist bullist indent outdent | " +
    "emoticons charmap | removeformat",

  tinycomments_mode: "embedded",
  tinycomments_author: "Author name",

  mergetags_list: [
    { value: "First.Name", title: "First Name" },
    { value: "Email", title: "Email" }
  ],

  uploadcare_public_key: "3e240c2b7c78a536e2df",

  automatic_uploads: false,
  file_picker_types: "image",
  file_picker_callback: (cb, value, meta) => {
    if (meta.filetype === "image") {
      const input = document.createElement("input");
      input.type = "file";
      input.accept = "image/*";

      input.onchange = async () => {
        const file = input.files[0];
        const formData = new FormData();
        formData.append("file", file);

        const token = document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content");

        const res = await fetch("/admin/news/upload-image", {
          method: "POST",
          headers: { "X-CSRF-TOKEN": token },
          body: formData,
        });

        const data = await res.json();
        cb(data.url, { title: file.name });
      };

      input.click();
    }
  }
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

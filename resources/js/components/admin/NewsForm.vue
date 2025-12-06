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
      <Editor v-model="form.excerpt" :api-key="TINYMCE_KEY" :init="excerptEditorInit" />

      <p v-if="errors.excerpt" class="text-red-600 text-sm mt-1">
        {{ errors.excerpt[0] }}
      </p>
    </div>

    <!-- Thumbnail Upload -->
    <div class="mt-10">
      <label class="font-bold block mb-3">Thumbnail</label>
      <div
        class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition cursor-pointer flex flex-col items-center justify-center text-center"
        @click="$refs.thumbnailInput.click()"
      >
        <img src="/images/upload-img.png" class="w-10 opacity-60 mb-2" />

        <p class="text-gray-600 text-sm">
          Kéo thả ảnh vào đây hoặc
          <span class="font-semibold text-blue-600 underline">chọn ảnh</span>
        </p>

        <p class="text-gray-400 text-xs">(1 ảnh – jpg, png, webp)</p>
      </div>

      <input
        type="file"
        accept="image/*"
        class="hidden"
        ref="thumbnailInput"
        @change="onThumbnailChange"
      />

      <p class="mt-3 text-sm text-gray-600">
        Đã chọn:
        <span class="font-semibold">{{ previewThumbnail ? 1 : 0 }}/1</span>
      </p>

      <div class="mt-4 w-40">
        <div
          v-if="previewThumbnail"
          class="relative group w-full h-32 rounded-lg overflow-hidden border shadow"
        >
          <img :src="previewThumbnail" class="object-cover w-full h-full" />

          <button
            @click.stop="removeThumbnail"
            class="absolute top-2 right-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
        </div>
      </div>

      <p v-if="errors.thumbnail" class="text-red-600 text-sm mt-2">
        {{ errors.thumbnail[0] }}
      </p>
    </div>

    <!-- Content -->
    <div>
      <label class="font-bold">Nội dung</label>
      <Editor v-model="form.content" :init="editorInit" />
      <p v-if="errors.content" class="text-red-600 text-sm mt-1">
        {{ errors.content[0] }}
      </p>
    </div>

    <!-- GALLERY -->
    <div class="mt-10">
      <label class="font-bold block mb-3">Gallery (tối đa 6 ảnh)</label>

      <div
        class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition cursor-pointer flex flex-col items-center justify-center text-center"
        @click="$refs.galleryInput.click()"
      >
        <img src="/images/upload-img.png" class="w-10 opacity-60 mb-2" />
        <p class="text-gray-600 text-sm">
          Kéo thả ảnh vào đây hoặc
          <span class="font-semibold text-blue-600 underline">chọn ảnh</span>
        </p>
      </div>

      <input
        type="file"
        accept="image/*"
        multiple
        class="hidden"
        ref="galleryInput"
        @change="onGalleryChange"
      />

      <p class="mt-3 text-sm text-gray-600">
        Đã chọn:
        <span class="font-semibold">{{ previewGallery.length }}/6</span>
      </p>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <div
          v-for="(img, idx) in previewGallery"
          :key="idx"
          class="relative group w-full h-32 rounded-lg overflow-hidden shadow"
        >
          <img :src="img" class="object-cover w-full h-full" />

          <button
            @click.stop="removeGalleryImage(idx)"
            class="absolute top-2 right-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <button
      class="cursor-pointer px-6 py-3 bg-red-700 text-white rounded hover:bg-red-800 disabled:opacity-50"
      :disabled="isSubmitting"
      @click="handleSubmit"
    >
      <span v-if="!isSubmitting">{{
        mode === "create" ? "Lưu bài viết" : "Cập nhật bài viết"
      }}</span>
      <span v-else>Đang xử lý...</span>
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Editor from "@tinymce/tinymce-vue";
import { usePage } from "@inertiajs/vue3";


const page = usePage();
const TINYMCE_KEY = page.props.tinymce_api_key;
// Props
const props = defineProps({
  mode: { type: String, default: "create" }, // "create" | "edit"
  news: { type: Object, default: null },
});

const emit = defineEmits(["submit"]);

// Form state
const form = ref({
  title: props.news?.title ?? "",
  excerpt: props.news?.excerpt ?? "",
  category_id: props.news?.category_id ?? "",
  content: props.news?.content ?? "",
  thumbnail_base64: props.news?.thumbnail_base64 ?? "",
  gallery_base64: props.news?.gallery_base64 ?? [],
});
console.log(props.news)
const errors = ref({});
const isSubmitting = ref(false);

const previewThumbnail = ref(null);
const previewGallery = ref([]);

// Load thumbnail từ bản ghi cũ
if (props.news?.thumbnail_base64) {
  previewThumbnail.value = props.news.thumbnail_base64.startsWith("data:image")
    ? props.news.thumbnail_base64
    : `/storage/${props.news.thumbnail_base64}`;
}

// Load gallery cũ
if (props.news?.gallery_base64?.length) {
  previewGallery.value = props.news.gallery_base64.map((img) =>
    img.startsWith("data:image") ? img : `/storage/${img}`
  );
}

// Convert file to base64
function fileToBase64(file) {
  return new Promise((resolve) => {
    const r = new FileReader();
    r.onload = () => resolve(r.result);
    r.readAsDataURL(file);
  });
}

// Thumbnail
async function onThumbnailChange(e) {
  const file = e.target.files[0];
  previewThumbnail.value = URL.createObjectURL(file);
  form.value.thumbnail_base64 = await fileToBase64(file);
}

function removeThumbnail() {
  previewThumbnail.value = null;
  form.value.thumbnail_base64 = "";
  form.value.thumbnail = null;
}

// Gallery
async function onGalleryChange(e) {
  const files = Array.from(e.target.files);

  for (const f of files) {
    if (previewGallery.value.length >= 6) break;
    previewGallery.value.push(URL.createObjectURL(f));
    form.value.gallery_base64.push(await fileToBase64(f));
  }
}

// Remove gallery item
function removeGalleryImage(i) {
  previewGallery.value.splice(i, 1);
  form.value.gallery_base64.splice(i, 1);
}

// Submit wrapper (gửi toàn bộ dữ liệu sang trang cha Create.vue hoặc Edit.vue)
async function handleSubmit() {
  emit("submit", form.value);
}
</script>

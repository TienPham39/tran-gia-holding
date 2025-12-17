<template>
  <div class="max-w-6xl mx-auto py-8 px-4 space-y-10 font-mont">
    <!-- Basic Info Section -->
    <div class="space-y-4">
      <h2 class="text-xl font-bold border-b pb-2">Thông tin cơ bản</h2>
      
      <!-- Name -->
      <div>
        <label class="font-bold">Tên sản phẩm <span class="text-red-500">*</span></label>
        <input type="text" v-model="form.name" class="input w-full mt-2" />
        <p v-if="errors.name" class="text-red-600 text-sm mt-1">
          {{ errors.name[0] }}
        </p>
      </div>

      <!-- Product Type -->
      <div>
        <label class="font-bold">Loại sản phẩm <span class="text-red-500">*</span></label>
        <select v-model="form.product_type_id" class="input w-full mt-2">
          <option disabled value="">-- Chọn loại sản phẩm --</option>
          <option v-for="type in productTypes" :key="type.id" :value="type.id">
            {{ type.name }}
          </option>
        </select>
        <p v-if="errors.product_type_id" class="text-red-600 text-sm mt-1">
          {{ errors.product_type_id[0] }}
        </p>
      </div>

      <!-- Status -->
      <div>
        <label class="font-bold">Trạng thái</label>
        <select v-model="form.status" class="input w-full mt-2">
          <option value="Đang bán">Đang bán</option>
          <option value="Đã bán">Đã bán</option>
          <option value="Hot">Hot</option>
          <option value="Sắp mở bán">Sắp mở bán</option>
        </select>
        <p v-if="errors.status" class="text-red-600 text-sm mt-1">
          {{ errors.status[0] }}
        </p>
      </div>
    </div>

    <!-- Highlights Section -->
    <div class="space-y-4">
      <div class="flex items-center justify-between border-b pb-2">
        <h2 class="text-xl font-bold">Đặc điểm nổi bật</h2>
        <button
          type="button"
          @click="addHighlight"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          + Thêm đặc điểm
        </button>
      </div>

      <div v-for="(highlight, index) in form.highlights" :key="index" class="flex gap-2 items-start">
        <textarea
          v-model="highlight.content"
          class="input flex-1"
          rows="3"
          :placeholder="`Đặc điểm nổi bật ${index + 1}`"
        ></textarea>
        <button
          type="button"
          @click="removeHighlight(index)"
          class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
        >
          Xóa
        </button>
      </div>

      <p v-if="errors.highlights" class="text-red-600 text-sm">
        {{ errors.highlights[0] }}
      </p>
    </div>

    <!-- Solugon Section -->
    <div>
      <h2 class="text-xl font-bold border-b pb-2 mb-4">Solugon</h2>
      <textarea
        v-model="form.solugon"
        class="input w-full"
        rows="4"
        placeholder="Nhập câu solugon cho dự án"
      ></textarea>
      <p v-if="errors.solugon" class="text-red-600 text-sm mt-1">
        {{ errors.solugon[0] }}
      </p>
    </div>

    <!-- Short Description Section -->
    <div>
      <h2 class="text-xl font-bold border-b pb-2 mb-4">Mô tả ngắn</h2>
      <textarea
        v-model="form.short_description"
        class="input w-full"
        rows="4"
        placeholder="Nhập mô tả ngắn về sản phẩm"
      ></textarea>
      <p v-if="errors.short_description" class="text-red-600 text-sm mt-1">
        {{ errors.short_description[0] }}
      </p>
    </div>

    <!-- Thumbnail Section -->
    <div class="mt-10">
      <h2 class="text-xl font-bold border-b pb-2 mb-4">Thumbnail</h2>
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
        <span class="font-semibold">{{ previewThumbnail && !previewThumbnail.deleted ? 1 : 0 }}/1</span>
      </p>

      <div class="mt-4 w-40">
        <div
          v-if="previewThumbnail && !previewThumbnail.deleted"
          class="relative group w-full h-32 rounded-lg overflow-hidden border shadow"
        >
          <img :src="previewThumbnail.image_url" class="object-cover w-full h-full" />
          <button
            v-if="previewThumbnail.isExisting"
            @click.stop="deleteThumbnail"
            class="absolute top-2 left-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
          <button
            v-else
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

    <!-- Gallery Section -->
    <div class="mt-10">
      <h2 class="text-xl font-bold border-b pb-2 mb-4">
        Gallery (phải là bội số của 6: 6, 12, 18, ...)
      </h2>

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
        <span class="font-semibold">{{ previewGallery.filter(img => !img.deleted).length }}</span>
        <span v-if="galleryError" class="text-red-600 ml-2">{{ galleryError }}</span>
        <span v-else-if="previewGallery.filter(img => !img.deleted).length > 0 && previewGallery.filter(img => !img.deleted).length % 6 === 0" class="text-green-600 ml-2">
          ✓ Hợp lệ
        </span>
      </p>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <div
          v-for="(img, idx) in previewGallery.filter(img => !img.deleted)"
          :key="img.id || `new-${idx}`"
          class="relative group w-full h-32 rounded-lg overflow-hidden shadow"
        >
          <img :src="img.image_url" class="object-cover w-full h-full" />
          <button
            v-if="img.isExisting"
            @click.stop="deleteGalleryImage(img.id)"
            class="absolute top-2 left-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
          <button
            v-else
            @click.stop="removeGalleryImageByObject(img)"
            class="absolute top-2 right-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
        </div>
      </div>

      <p v-if="errors.gallery" class="text-red-600 text-sm mt-2">
        {{ errors.gallery[0] }}
      </p>
    </div>

    <!-- Floor Plan Section -->
    <div class="mt-10">
      <h2 class="text-xl font-bold border-b pb-2 mb-4">Sơ đồ phân lô</h2>

      <div
        class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition cursor-pointer flex flex-col items-center justify-center text-center"
        @click="$refs.floorPlanInput.click()"
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
        ref="floorPlanInput"
        @change="onFloorPlanChange"
      />

      <p class="mt-3 text-sm text-gray-600">
        Đã chọn:
        <span class="font-semibold">{{ previewFloorPlan.filter(img => !img.deleted).length }}</span>
      </p>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <div
          v-for="(img, idx) in previewFloorPlan.filter(img => !img.deleted)"
          :key="img.id || `new-${idx}`"
          class="relative group w-full h-32 rounded-lg overflow-hidden shadow"
        >
          <img :src="img.image_url" class="object-cover w-full h-full" />
          <button
            v-if="img.isExisting"
            @click.stop="deleteFloorPlanImage(img.id)"
            class="absolute top-2 left-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
          <button
            v-else
            @click.stop="removeFloorPlanImageByObject(img)"
            class="absolute top-2 right-2 bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
          >
            ✕
          </button>
        </div>
      </div>

      <p v-if="errors.floor_plan" class="text-red-600 text-sm mt-2">
        {{ errors.floor_plan[0] }}
      </p>
    </div>

    <!-- Submit Button -->
    <button
      class="cursor-pointer px-6 py-3 bg-red-700 text-white rounded hover:bg-red-800 disabled:opacity-50"
      :disabled="isSubmitting"
      @click="handleSubmit"
    >
      <span v-if="!isSubmitting">
        {{ mode === "create" ? "Lưu sản phẩm" : "Cập nhật sản phẩm" }}
      </span>
      <span v-else>Đang xử lý...</span>
    </button>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { message } from "ant-design-vue";

const page = usePage();

// Props
const props = defineProps({
  mode: { type: String, default: "create" }, // "create" | "edit"
  product: { type: Object, default: null },
  productTypes: { type: Array, default: () => [] },
});

const emit = defineEmits(["submit", "done"]);

defineExpose({
  resetForm,
  stopLoading,
});

// Form state
const form = ref({
  name: props.product?.name ?? "",
  product_type_id: props.product?.product_type_id ?? "",
  status: props.product?.status ?? "Đang bán",
  highlights: props.product?.highlights?.map((h) => ({ content: h.content })) ?? [],
  solugon: props.product?.solugon ?? "",
  short_description: props.product?.short_description ?? "",
  is_hot: props.product?.is_hot ?? 0,
  thumbnail: null, // File object
  gallery: [], // Array of file objects
  floor_plan: [], // Array of file objects
});

const errors = ref({});
const isSubmitting = ref(false);

const previewThumbnail = ref(null);
const previewGallery = ref([]);
const previewFloorPlan = ref([]);
const galleryError = ref("");
const deletedImageIds = ref([]); // Danh sách ID ảnh cần xóa

// Load existing data
if (props.product) {
  // Thumbnail: lưu cả ID và URL
  if (props.product.thumbnail) {
    const thumbUrl = typeof props.product.thumbnail === 'string' 
      ? (props.product.thumbnail.startsWith("/storage/") ? props.product.thumbnail : `/storage/${props.product.thumbnail}`)
      : (props.product.thumbnail.image_url?.startsWith("/storage/") ? props.product.thumbnail.image_url : `/storage/${props.product.thumbnail.image_url}`);
    
    previewThumbnail.value = {
      id: props.product.thumbnail.id || null,
      image_url: thumbUrl,
      isExisting: !!props.product.thumbnail.id,
    };
  }

  // Gallery: lưu cả ID và URL cho mỗi ảnh
  if (props.product.gallery?.length) {
    previewGallery.value = props.product.gallery.map((img) => {
      const imgUrl = typeof img === 'string'
        ? (img.startsWith("/storage/") ? img : `/storage/${img}`)
        : (img.image_url?.startsWith("/storage/") ? img.image_url : `/storage/${img.image_url}`);
      
      return {
        id: img.id || null,
        image_url: imgUrl,
        isExisting: !!img.id,
      };
    });
  }

  // Floor plan: lưu cả ID và URL cho mỗi ảnh
  if (props.product.floor_plan?.length) {
    previewFloorPlan.value = props.product.floor_plan.map((img) => {
      const imgUrl = typeof img === 'string'
        ? (img.startsWith("/storage/") ? img : `/storage/${img}`)
        : (img.image_url?.startsWith("/storage/") ? img.image_url : `/storage/${img.image_url}`);
      
      return {
        id: img.id || null,
        image_url: imgUrl,
        isExisting: !!img.id,
      };
    });
  }
}

// Watch gallery count for validation (chỉ đếm ảnh không bị xóa)
watch(
  () => previewGallery.value.filter(img => !img.deleted).length,
  (count) => {
    if (count > 0 && count % 6 !== 0) {
      galleryError.value = `Số lượng ảnh phải là bội số của 6 (hiện tại: ${count})`;
    } else {
      galleryError.value = "";
    }
  }
);

function resetForm() {
  form.value = {
    name: "",
    product_type_id: "",
    status: "Đang bán",
    highlights: [],
    solugon: "",
    short_description: "",
    is_hot: 0,
    thumbnail: null,
    gallery: [],
    floor_plan: [],
  };

  previewThumbnail.value = null;
  previewGallery.value = [];
  previewFloorPlan.value = [];
  deletedImageIds.value = [];
  galleryError.value = "";
}

function stopLoading() {
  isSubmitting.value = false;
}

// Highlights
function addHighlight() {
  form.value.highlights.push({ content: "" });
}

function removeHighlight(index) {
  form.value.highlights.splice(index, 1);
}

// Thumbnail
function onThumbnailChange(e) {
  const file = e.target.files[0];
  if (!file) return;

  previewThumbnail.value = {
    id: null,
    image_url: URL.createObjectURL(file),
    isExisting: false,
    file: file,
  };
  form.value.thumbnail = file;
  e.target.value = null;
}

function removeThumbnail() {
  if (previewThumbnail.value && previewThumbnail.value.image_url && previewThumbnail.value.image_url.startsWith("blob:")) {
    URL.revokeObjectURL(previewThumbnail.value.image_url);
  }
  previewThumbnail.value = null;
  form.value.thumbnail = null;
}

function deleteThumbnail() {
  if (previewThumbnail.value && previewThumbnail.value.isExisting && previewThumbnail.value.id) {
    deletedImageIds.value.push(previewThumbnail.value.id);
    previewThumbnail.value.deleted = true;
    previewThumbnail.value = null;
    form.value.thumbnail = null;
  }
}

// Gallery
function onGalleryChange(e) {
  const files = Array.from(e.target.files);
  for (const f of files) {
    previewGallery.value.push({
      id: null,
      image_url: URL.createObjectURL(f),
      isExisting: false,
      file: f,
    });
    form.value.gallery.push(f);
  }
  e.target.value = null;
}

function removeGalleryImageByObject(img) {
  if (!img || img.isExisting) return;
  
  if (img.image_url && img.image_url.startsWith("blob:")) {
    URL.revokeObjectURL(img.image_url);
  }
  
  // Tìm index trong previewGallery
  const index = previewGallery.value.findIndex(item => item === img);
  if (index === -1) return;
  
  // Xóa khỏi previewGallery
  previewGallery.value.splice(index, 1);
  
  // Xóa file khỏi form.gallery (đếm số ảnh mới trước index này)
  let newImageCount = 0;
  for (let i = 0; i < index; i++) {
    if (!previewGallery.value[i]?.isExisting) {
      newImageCount++;
    }
  }
  if (newImageCount < form.value.gallery.length) {
    form.value.gallery.splice(newImageCount, 1);
  }
}

function deleteGalleryImage(imageId) {
  if (imageId) {
    deletedImageIds.value.push(imageId);
    const index = previewGallery.value.findIndex(img => img.id === imageId);
    if (index !== -1) {
      previewGallery.value[index].deleted = true;
    }
  }
}

// Floor Plan
function onFloorPlanChange(e) {
  const files = Array.from(e.target.files);
  for (const f of files) {
    previewFloorPlan.value.push({
      id: null,
      image_url: URL.createObjectURL(f),
      isExisting: false,
      file: f,
    });
    form.value.floor_plan.push(f);
  }
  e.target.value = null;
}

function removeFloorPlanImageByObject(img) {
  if (!img || img.isExisting) return;
  
  if (img.image_url && img.image_url.startsWith("blob:")) {
    URL.revokeObjectURL(img.image_url);
  }
  
  // Tìm index trong previewFloorPlan
  const index = previewFloorPlan.value.findIndex(item => item === img);
  if (index === -1) return;
  
  // Xóa khỏi previewFloorPlan
  previewFloorPlan.value.splice(index, 1);
  
  // Xóa file khỏi form.floor_plan (đếm số ảnh mới trước index này)
  let newImageCount = 0;
  for (let i = 0; i < index; i++) {
    if (!previewFloorPlan.value[i]?.isExisting) {
      newImageCount++;
    }
  }
  if (newImageCount < form.value.floor_plan.length) {
    form.value.floor_plan.splice(newImageCount, 1);
  }
}

function deleteFloorPlanImage(imageId) {
  if (imageId) {
    deletedImageIds.value.push(imageId);
    const index = previewFloorPlan.value.findIndex(img => img.id === imageId);
    if (index !== -1) {
      previewFloorPlan.value[index].deleted = true;
    }
  }
}

// Submit
async function handleSubmit() {
  // Validate gallery count (chỉ đếm ảnh không bị xóa)
  const visibleGalleryCount = previewGallery.value.filter(img => !img.deleted).length;
  if (visibleGalleryCount > 0 && visibleGalleryCount % 6 !== 0) {
    message.error("Số lượng ảnh gallery phải là bội số của 6 (6, 12, 18, ...)");
    return;
  }

  isSubmitting.value = true;
  
  // Emit form data kèm deleted_image_ids
  emit("submit", {
    ...form.value,
    deleted_image_ids: deletedImageIds.value,
  });
}
</script>



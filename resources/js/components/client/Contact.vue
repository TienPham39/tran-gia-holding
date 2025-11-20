<template>
  <section id="contact" class="relative py-20 pb-46 overflow-hidden">
    <!-- BACKGROUND DECOR -->
    <div
      class="absolute bottom-10 left-90 w-[90%] flex justify-center overflow-hidden opacity-90"
    >
      <img src="/images/homepage/bg-contact.png" alt="" class="w-1/3" />
      <img src="/images/homepage/bg-contact.png" alt="" class="w-1/3" />
    </div>

    <div
      class="relative container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-10"
    >
      <!-- LEFT SIDE -->
      <div class="flex flex-col items-start gap-6 w-full lg:w-1/2">
        <h2 class="text-4xl font-bold text-[#838383] uppercase">Lorem Ipsum</h2>
        <div class="space-y-2">
          <div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
            venenatis placerat ipsum...
          </div>
        </div>

        <div
          class="relative pl-24 flex items-center gap-3 bg-[#A22222] text-white rounded-full px-6 py-3 cursor-pointer shadow-lg hover:bg-[#7d1a1a] transition mt-4"
        >
          <img
            src="/images/homepage/contact.png"
            alt="phone"
            class="absolute left-0 w-22"
          />
          <span class="text-2xl text-[#EAEAEA] font-bold tracking-wide"
            >098 8386 886</span
          >
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div
        class="bg-[#D5D5D5] rounded-sm p-8 py-20 w-full lg:w-1/2 shadow-md relative z-10"
      >
        <h2 class="text-[#9B1C1C] text-4xl font-bold uppercase mb-6">
          Liên hệ
        </h2>

        <form @submit.prevent="submitForm" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input
              v-model="form.name"
              type="text"
              placeholder="HỌ VÀ TÊN"
              class="border-2 border-[#9B1C1C] bg-white px-4 py-4 rounded-xs w-full focus:outline-none placeholder-gray-400 text-sm"
            />
            <input
              v-model="form.phone"
              type="text"
              placeholder="SỐ ĐIỆN THOẠI"
              class="border-2 border-[#9B1C1C] bg-white px-4 py-4 rounded-xs w-full focus:outline-none placeholder-gray-400 text-sm"
            />
          </div>

          <input
            v-model="form.email"
            type="email"
            placeholder="EMAIL"
            class="border-2 border-[#9B1C1C] bg-white px-4 py-4 rounded-xs w-full focus:outline-none placeholder-gray-400 text-sm" 
          />

          <textarea
            v-model="form.message"
            rows="4"
            placeholder="LỜI NHẮN..."
            class="border-2 border-[#9B1C1C] bg-white px-4 py-4 rounded-xs w-full focus:outline-none placeholder-gray-400 text-sm"
          ></textarea>

          <button
            type="submit"
            :class="isSubmitting ? 'pointer-events-none' : ''"
            class="bg-[#9B1C1C] text-white font-semibold px-6 py-3 rounded-md hover:bg-[#7d1a1a] transition uppercase tracking-wide"
          >
            Gửi ngay <span class="align-middle relative -top-[3px]">>></span>
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { message } from "ant-design-vue";
const form = ref({
  name: "",
  phone: "",
  email: "",
  message: "",
});

const isSubmitting = ref(false);
const submitForm = async () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;

  try {
    const response = await axios.post("/contacts", form.value);

    // Nếu dùng ant-design-vue:
    message.success("Gửi liên hệ thành công!");

    // Reset form
    form.value.name = "";
    form.value.phone = "";
    form.value.email = "";
    form.value.message = "";

    console.log("Response:", response.data);
  } catch (error) {
    console.error("Lỗi gửi liên hệ:", error);
    message.error("Đã xảy ra lỗi, vui lòng thử lại!");
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>

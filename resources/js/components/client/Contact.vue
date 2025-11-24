<template>
  <section id="contact" class="py-20">
    <div
      class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-10"
    >
      <!-- LEFT SIDE -->
      <div class="flex flex-col items-start gap-6 w-full lg:w-1/2">
        <h2 class="text-4xl font-bold text-[#838383] uppercase">Lorem Ipsum</h2>

        <!-- Placeholder text -->
        <div class="space-y-2">
          <div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
            venenatis placerat ipsum, id facilisis ante lobortis quis. Sed
            egestas odio quis condimentum consequat. Nam pharetra, diam et
            eleifend placerat, nisl lectus tincidunt lectus, non mollis justo mi
            mattis augue. Sed cursus commodo eleifend. Vestibulum eget mi sed
            elit sagittis accumsan. Nulla facilisi. Duis sollicitudin rutrum
            faucibus. Vestibulum consectetur ut neque quis tincidunt.
          </div>
        </div>

        <!-- Hotline Button -->
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

      <!-- RIGHT SIDE: CONTACT FORM -->
      <div class="font-banque bg-[#D5D5D5] rounded-[4px] p-8 w-full lg:w-1/2 shadow-md">
        <h2 class="text-[#9B1C1C] text-4xl font-bold uppercase mb-6">
          Liên hệ
        </h2>

        <form @submit.prevent="submitForm" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input
              v-model="form.name"
              type="text"
              placeholder="HỌ VÀ TÊN"
              class="border border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full focus:outline-none"
            />
            <input
              v-model="form.phone"
              type="text"
              placeholder="SỐ ĐIỆN THOẠI"
              class="border border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full focus:outline-none"
            />
          </div>

          <input
            v-model="form.email"
            type="email"
            placeholder="EMAIL"
            class="border border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full focus:outline-none"
          />

          <textarea
            v-model="form.message"
            rows="4"
            placeholder="LỜI NHẮN..."
            class="border border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full focus:outline-none"
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

<template>
  <section id="contact" class="py-30 relative">
    <!-- Decorative BG under everything -->
    <img
      src="/images/homepage/bg-contact.png"
      class="hidden md:block absolute bottom-0 right-[26%] w-[460px] opacity-60 pointer-events-none z-0"
      alt=""
    />

    <img
      src="/images/homepage/bg-contact.png"
      class="hidden md:block absolute bottom-0 right-0 w-[460px] opacity-60 pointer-events-none z-0"
      alt=""
    />

    <!-- Content wrapper (higher z-index) -->
    <div
      class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-14 relative z-10"
    >
      <!-- LEFT SIDE -->
      <div class="font-mont flex flex-col items-start gap-6 lg:w-1/2">
        <h2 class="text-5xl font-bold text-[#838383] uppercase mb-4">
          tư vấn ngay
        </h2>

        <div
          class="text-[#595959] font-bold space-y-2 text-3xl mb-12 w-[500px]"
        >
          <p>Để lại thông tin để nhận bảng giá và quy hoạch mới nhất.</p>
        </div>

        <!-- Hotline Button -->
        <div
          class="relative pl-24 flex items-center gap-3 bg-[#A22222] text-white rounded-full px-6 py-4 cursor-pointer shadow-lg hover:bg-[#7d1a1a] transition mt-4"
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

      <!-- RIGHT SIDE: FORM (also z-10) -->
      <div
        class="font-banque bg-[#D5D5D5] rounded-[4px] py-12 px-10 w-full lg:w-1/2 shadow-md relative z-10"
      >
        <h2 class="text-[#9B1C1C] text-4xl font-bold uppercase mb-6">
          Liên hệ
        </h2>

        <form @submit.prevent="submitForm" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 font-mont">
            <input
              v-model="form.name"
              type="text"
              placeholder="HỌ VÀ TÊN"
              class="border-2 border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full"
            />
            <input
              v-model="form.phone"
              type="text"
              placeholder="SỐ ĐIỆN THOẠI"
              class="border-2 border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full"
            />
          </div>

          <input
            v-model="form.email"
            type="email"
            placeholder="EMAIL"
            class="border-2 border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full font-mont"
          />

          <textarea
            v-model="form.message"
            rows="4"
            placeholder="LỜI NHẮN..."
            class="border-2 border-[#9B1C1C] bg-white px-4 py-2 rounded-xs w-full font-mont"
          ></textarea>

          <button
            type="submit"
            class="bg-[#9B1C1C] md:text-xl text-white font-semibold px-6 py-3 rounded-md hover:bg-[#7d1a1a] transition uppercase tracking-wide"
          >
            Gửi ngay >>
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

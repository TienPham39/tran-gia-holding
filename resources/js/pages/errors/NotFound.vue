<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 text-center">
    <h1 class="text-7xl font-extrabold text-blue-600">404</h1>
    <h2 class="mt-4 text-2xl font-semibold text-gray-800">Trang không tồn tại</h2>
    <p class="mt-2 text-gray-500">
      Có vẻ như bạn đã nhập sai đường dẫn hoặc trang này đã bị xóa.
    </p>

    <div class="mt-6 flex gap-3">
      <a
        href="/"
        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition"
      >
        Về trang chủ
      </a>
      <a
        href="javascript:history.back()"
        class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition"
      >
        Quay lại
      </a>
    </div>

    <img
      src="/images/404-illustration.svg"
      alt="Not found"
      class="mt-10 w-96 max-w-full"
    />
  </div>
</template>

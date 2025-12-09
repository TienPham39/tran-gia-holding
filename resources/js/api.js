import axios from "axios";
import { message } from "ant-design-vue";
import router from "./router";

const baseURL = import.meta.env.VITE_API_BASE_URL;
const api = axios.create({
  baseURL: baseURL,
  withCredentials: true,
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// ✅ Đảm bảo có CSRF cookie (nếu cần với Sanctum)
api.ensureCsrfCookie = async function () {
  try {
    await api.get("/sanctum/csrf-cookie");
  } catch (err) {
    console.warn("⚠️ Không thể lấy CSRF cookie:", err.message);
  }
};

// ✅ Tự động gắn Authorization header
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// ✅ Bắt lỗi 401 toàn cục
api.interceptors.response.use(
  (response) => response,
  async (error) => {
    const { response } = error;

    if (response?.status === 401) {
      // Xóa token + redirect
      localStorage.removeItem("auth_token");
      delete api.defaults.headers.common["Authorization"];

      if (router.currentRoute.value.name !== "Auth") {
        message.warning("Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.");
        window.location.href = "/auth";
      }
    }

    return Promise.reject(error);
  }
);

export default api;

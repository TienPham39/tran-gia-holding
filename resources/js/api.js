import axios from "axios";
import { message } from "ant-design-vue";
import router from "./router";

const baseURL = import.meta.env.VITE_API_BASE_URL;
const api = axios.create({
  baseURL: baseURL,
  withCredentials: true,
  timeout: 30000, // Tăng timeout mặc định lên 30 giây
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

// ✅ Tự động gắn Authorization header và CSRF token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    
    // Thêm CSRF token vào header hoặc FormData
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
      // Nếu là FormData, thêm vào FormData
      if (config.data instanceof FormData) {
        config.data.append('_token', csrfToken);
        // Tăng timeout cho FormData (upload file)
        if (!config.timeout || config.timeout < 60000) {
          config.timeout = 60000; // 60 giây
        }
      } else {
        // Nếu không phải FormData, thêm vào header
        config.headers['X-CSRF-TOKEN'] = csrfToken;
      }
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

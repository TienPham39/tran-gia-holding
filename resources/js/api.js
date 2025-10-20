import axios from "axios";
import router from "./router";
import { message } from "ant-design-vue";

const api = axios.create({
  baseURL: "http://localhost:8000/",
  timeout: 10000,
  withCredentials: true,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

async function ensureCsrfCookie() {
  try {
    await api.get("/sanctum/csrf-cookie");
  } catch (err) {
    console.warn("Không thể lấy CSRF cookie:", err);
  }
}

api.ensureCsrfCookie = ensureCsrfCookie;

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

api.interceptors.response.use(
  (response) => response,
  async (error) => {
    const { response } = error;

    if (response?.status === 401) {
      if (router.currentRoute.value.name !== "Auth") {
        localStorage.removeItem("auth_token");
        delete api.defaults.headers.common["Authorization"];
        message.warning("Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.");
        await router.push({ name: "Auth" });
      }
    }

    return Promise.reject(error);
  }
);

export default api;

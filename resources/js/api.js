import axios from "axios";
import { message } from "ant-design-vue";

const api = axios.create({
  baseURL: "http://localhost:8000/api",
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    // Nếu lỗi khi gửi request
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem("auth_token");
      delete api.defaults.headers.common["Authorization"];
      // message.warning("Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại");
      // window.location.href = "/auth";
    }
    return Promise.reject(error);
  }
);

export default api;

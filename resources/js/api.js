import axios from "axios";
import { message } from "ant-design-vue";
import router from "./router";

// ✅ Với Laravel + Inertia, frontend và backend cùng origin
// Nếu không có VITE_API_BASE_URL, dùng empty string để dùng relative path
// Relative path sẽ tự động dùng origin hiện tại (Laravel server)
const baseURL = import.meta.env.VITE_API_BASE_URL || '';
const api = axios.create({
  baseURL: baseURL,
  withCredentials: true, // ✅ Bắt buộc để gửi cookie (laravel_session, XSRF-TOKEN)
  withXSRFToken: true, // ✅ QUAN TRỌNG: Tự động gửi XSRF-TOKEN từ cookie
  timeout: 30000, // Tăng timeout mặc định lên 30 giây
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// ✅ Đảm bảo có CSRF cookie (nếu cần với Sanctum)
// Route này sẽ set cookie: laravel_session và XSRF-TOKEN
api.ensureCsrfCookie = async function () {
  try {
    const response = await api.get("/sanctum/csrf-cookie", {
      withCredentials: true,
    });
    console.log("✅ CSRF cookie endpoint called successfully");
    
    // ✅ Sau khi gọi /sanctum/csrf-cookie, session có thể được regenerate
    // Cần refresh CSRF token từ cookie mới (nếu có)
    // Token từ meta tag có thể đã cũ
    const newToken = getCsrfToken();
    if (newToken) {
      console.log("✅ Got new CSRF token after cookie call:", newToken.substring(0, 20) + '...');
    }
    
    return response;
  } catch (err) {
    console.warn("⚠️ Không thể lấy CSRF cookie:", err.message);
    // Nếu route không tồn tại, không sao - sẽ dùng meta tag token
    throw err;
  }
};

// ✅ Hàm lấy CSRF token - ưu tiên cookie XSRF-TOKEN, sau đó mới dùng meta tag
function getCsrfToken() {
  // ✅ Ưu tiên 1: Lấy từ cookie XSRF-TOKEN (Laravel Sanctum)
  const xsrfCookie = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='));
  if (xsrfCookie) {
    // Decode URL encoded cookie value
    const token = decodeURIComponent(xsrfCookie.split('=')[1]);
    console.log('✅ Found CSRF token from cookie:', token.substring(0, 20) + '...');
    return token;
  }
  
  // ✅ Ưu tiên 2: Lấy từ meta tag (Laravel Inertia)
  const metaTag = document.querySelector('meta[name="csrf-token"]');
  if (metaTag) {
    const metaToken = metaTag.getAttribute('content');
    if (metaToken) {
      console.log('✅ Found CSRF token from meta tag:', metaToken.substring(0, 20) + '...');
      return metaToken;
    }
  }
  
  console.error('❌ No CSRF token found! Check meta tag or cookies.');
  return null;
}

// ✅ Tự động gắn Authorization header và CSRF token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    
    // ✅ Thêm CSRF token vào header hoặc FormData
    // Với withXSRFToken: true, axios sẽ tự động gửi X-XSRF-TOKEN từ cookie
    // Nhưng Laravel expect X-CSRF-TOKEN, nên phải thêm thủ công
    const csrfToken = getCsrfToken();
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
        // Laravel check theo thứ tự: X-CSRF-TOKEN, X-XSRF-TOKEN, _token, XSRF-TOKEN cookie
        config.headers['X-CSRF-TOKEN'] = csrfToken;
        console.log('✅ Added X-CSRF-TOKEN header to request:', config.url);
      }
    } else {
      console.error('❌ CSRF token is null! Request will fail:', config.url);
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

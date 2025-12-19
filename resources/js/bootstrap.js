import axios from "axios";

// axios.defaults.withCredentials = true;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const token = document
  .querySelector('meta[name="csrf-token"]')
  ?.getAttribute("content");
if (token) {
  axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
} else {
  console.error("⚠️ Không tìm thấy CSRF token trong meta tag");
}

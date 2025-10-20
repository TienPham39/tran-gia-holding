import { createRouter, createWebHistory } from "vue-router";
import { message } from "ant-design-vue";
const routes = [];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Middleware kiểm tra đăng nhập
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("auth_token");

  // Nếu route yêu cầu login mà chưa có token
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!token) {
      message.warning("Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.");
      return next({ name: "Auth" });
    }
  }

  // Nếu đã login mà vào lại /auth thì chuyển sang dashboard
  if (to.matched.some((record) => record.meta.guestOnly) && token) {
    return next({ name: "admin-analytics" });
  }

  next();
});

export default router;

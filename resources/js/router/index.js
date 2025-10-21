import { createRouter, createWebHistory } from "vue-router";
import { message } from "ant-design-vue";
import api from "../api";

const routes = [
  {
    path: "/auth",
    name: "Auth",
    component: () => import("../pages/auth/Register.vue"),
    meta: { guestOnly: true },
  },
  {
    path: "/admin/analytics",
    name: "admin-analytics",
    component: () => import("../pages/admin/analytics/index.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/admin/users",
    name: "admin-users",
    component: () => import("../pages/admin/users/index.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/404",
    name: "NotFound",
    component: () => import("../pages/errors/NotFound.vue"),
    meta: { public: true },
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/404",
    meta: { public: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: "smooth",
      };
    }
    if (savedPosition) return savedPosition;
    return { top: 0 };
  },
});

// ⚙️ Hàm xác thực token (gọi API user)
async function verifyToken() {
  const token = localStorage.getItem("auth_token");
  if (!token) return false;

  try {
    const response = await api.get("/api/user", {
      headers: { Authorization: `Bearer ${token}` },
    });
    return !!response?.data;
  } catch (error) {
    return false;
  }
}

// ✅ Middleware trước mỗi route
router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem("auth_token");

  // Route public → cho qua
  if (to.matched.some((r) => r.meta.public)) return next();

  // Nếu đã login mà vào /auth → redirect về dashboard
  if (to.matched.some((r) => r.meta.guestOnly) && token) {
    return next({ name: "admin-analytics" });
  }

  // Nếu route yêu cầu đăng nhập
  if (to.matched.some((r) => r.meta.requiresAuth)) {
    const valid = await verifyToken();

    if (!valid) {
      localStorage.removeItem("auth_token");
      message.warning("Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.");
      return next({ name: "Auth" });
    }

    return next(); // Token hợp lệ
  }

  next();
});

export default router;

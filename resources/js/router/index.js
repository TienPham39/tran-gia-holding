import { createRouter, createWebHistory } from "vue-router";
import admin from "./admin.js";
import Register from "../pages/auth/Register.vue";

const routes = [
  ...admin,
  {
    path: "/auth",
    name: "Auth",
    component: Register,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Check login trước khi vào route
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("auth_token");

  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!token) {
      // Chưa login → về trang /auth (tab login)
      return next({ name: "Auth" });
    }
  }

  // Nếu đang login rồi mà lại vào /auth → redirect sang admin
  if (to.name === "Auth" && token) {
    return next({ name: "admin-analytics" });
  }

  next();
});

export default router;

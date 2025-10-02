import { createRouter, createWebHistory } from "vue-router";
import admin from "./admin.js";
import Register from "../pages/auth/Register.vue";

const routes = [
  ...admin,
  {
    path: "/register",
    name: "Register",
    component: Register,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

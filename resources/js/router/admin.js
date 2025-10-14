const admin = [
  {
    path: "/admin",
    component: () => import("../layouts/admin.vue"),
    meta: { requiresAuth: true },
    children: [
      // Dashboard / Analytics
      {
        path: "analytics",
        name: "admin-analytics",
        component: () => import("../pages/admin/analytics/index.vue"),
      },
      
      //Quản lý Users
      {
        path: "users",
        name: "admin-users",
        component: () => import("../pages/admin/users/index.vue"),
      },
      {
        path: "users/create",
        name: "admin-users-create",
        component: () => import("../pages/admin/users/create.vue"),
      },
      {
        path: "users/:id/edit",
        name: "admin-users-edit",
        component: () => import("../pages/admin/users/edit.vue"),
      },
      {
        path: "profile",
        name: "admin-profile",
        component: () => import("../pages/admin/profile/index.vue"),
        meta: { title: "Hồ sơ cá nhân" },
      },
    ],
  },
];

export default admin;

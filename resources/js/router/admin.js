const admin = [
  {
    path: "/admin",
    component: () => import("../layouts/admin.vue"),
    meta: { requiresAuth: true },
    children: [
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
    ],
  },
];

export default admin;

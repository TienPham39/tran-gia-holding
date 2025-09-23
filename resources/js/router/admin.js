const admin = [
  {
    path: "/admin",
    component: () => import('../layouts/admin.vue'),
    children: [
      {
        path: "analytics",
        name: "admin-analytics",
        component: () => import("../pages/admin/analytics/index.vue")
      },
      {
        path:'users',
        name:'admin-users',
        component: () => import("../pages/admin/users/index.vue")
      }
    ]
  }
];

export default admin;
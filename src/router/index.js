//import vue router
import { createRouter, createWebHistory } from "vue-router";
//define a routes
const routes = [
  {
    path: "/",
    name: "Main",
    component: () => import(/* webpackChunkName: "home" */ "../views/Main.vue"),
  },
  {
    path: "/ourtour",
    name: "OurTours",
    component: () => import(/* webpackChunkName: "home" */ "../views/OurTours.vue"),
  },
  {
    path: "/tours",
    name: "tours.index",
    component: () =>
      import(/* webpackChunkName: "index" */ "../views/tours/index.vue"),
  },
  {
    path: "/create",
    name: "tours.create",
    component: () =>
      import(/* webpackChunkName: "create" */ "../views/tours/create.vue"),
  },
  {
    path: "/edit/:id",
    name: "tours.edit",
    component: () =>
      import(/* webpackChunkName: "edit" */ "../views/tours/edit.vue"),
  },

  {
    path: "/bookings",
    name: "bookings.index",
    component: () =>
      import(/* webpackChunkName: "index" */ "../views/bookings/index.vue"),
  },
  {
    path: "/create",
    name: "bookings.create",
    component: () =>
      import(/* webpackChunkName: "create" */ "../views/bookings/create.vue"),
  },
  {
    path: "/edit/:id",
    name: "bookings.edit",
    component: () =>
      import(/* webpackChunkName: "edit" */ "../views/bookings/edit.vue"),
  },
];

//create router
const router = createRouter({
  history: createWebHistory(),
  routes, // <-- routes,
});
export default router;

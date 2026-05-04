import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Product from '../views/Product.vue';
import Library from '../views/Library.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
// Admin and Checkout views will be added later

const routes = [
  { path: '/', component: Home },
  { path: '/product/:id', component: Product, props: true },
  { path: '/library', component: Library },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  // { path: '/admin', component: () => import('../views/Admin.vue') },
  // { path: '/checkout/:id', component: () => import('../views/Checkout.vue'), props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
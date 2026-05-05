import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Product from '../views/Product.vue';
import Library from '../views/Library.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Checkout from '../views/Checkout.vue';
import Admin from '../views/Admin.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/product/:id', component: Product, props: true },
  { path: '/library', component: Library },
  { path: '/profile', component: Library },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/checkout/:id', component: Checkout, props: true },
  { path: '/admin', component: Admin },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import store from '../store/index.js';
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/users',
    name: 'user.list',
    component: () => import('../views/Users.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/roles',
    name: 'role.list',
    component: () => import('../views/Roles.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/permissions',
    name: 'permission.list',
    component: () => import('../views/Permissions.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/offices',
    name: 'office.list',
    component: () => import('../views/Offices.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/items',
    name: 'item.list',
    component: () => import('../views/Items.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/item_categories',
    name: 'item_category.list',
    component: () => import('../views/ItemCategories.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/Login.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from) => {
  if (to.meta.requiresAuth && store.getters['getUser'] === null) {
    return '/login';
  } else if (to.meta.requiresAuth && store.getters['getUser']) {
    axios.get(`${import.meta.env.VITE_API_URL}/api/auth/${store.getters['getUser']['id']}`)
    .then(response => {
      store.commit('setUser', response.data);
    })
    .catch(error => {
      store.commit('setUser', null);
      window.location = 'http://localhost:3002/login';
    });
  }
});

export default router;
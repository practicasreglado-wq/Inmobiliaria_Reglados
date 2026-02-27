import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../views/Dashboard.vue';
import UserProfile from '../views/UserProfile.vue';
import AboutUs from '../views/AboutUs.vue';  // Importa la nueva vista

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/dashboard', component: Dashboard },
  { path: '/profile', component: UserProfile },
  { path: '/about-us', component: AboutUs },  // Nueva ruta
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
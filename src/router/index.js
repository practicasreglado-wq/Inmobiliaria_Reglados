import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../views/Dashboard.vue';
import UserProfile from '../views/Profile.vue';
import AboutUs from '../views/AboutUs.vue';
import Contacto from "../views/Contacto.vue";
import Questions from "../views/Questions.vue";
import Metodologia from "../views/Metodologia.vue";

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/dashboard', component: Dashboard },
  { path: '/profile', component: UserProfile },
  { path: '/about-us', component: AboutUs },
  { path: "/contacto", component: Contacto },
  { path: "/questions", component: Questions },
  { path: "/metodologia", component: Metodologia }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
// router.js
import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../views/Dashboard.vue';
import UserProfile from '../views/Profile.vue';  // Ruta principal del perfil
import FavoriteProperties from '../views/FavoriteProperties.vue';
import Messages from '../views/Messages.vue';
import PropertiesForSale from '../views/PropertiesForSale.vue';
import Settings from '../views/Settings.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/dashboard', component: Dashboard },
  
  // Ruta principal para el perfil del usuario
  { 
    path: '/profile', 
    component: UserProfile, 
    children: [
      { path: '', redirect: '/profile/properties-for-sale' }, // Redirigir a las propiedades en venta por defecto
      { path: 'favorite-properties', component: FavoriteProperties },
      { path: 'messages', component: Messages },
      { path: 'properties-for-sale', component: PropertiesForSale },
      { path: 'settings', component: Settings },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
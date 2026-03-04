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
import Questions from '../views/Questions.vue';
import AboutUs from '../views/AboutUs.vue';  
import Contacto from '../views/Contacto.vue';
// Agregar las vistas para las nuevas rutas
import Team from '../views/Team.vue';  // Vista para el equipo
import Metodologia from '../views/Metodologia.vue';  // Vista para la metodología

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
  { path: '/questions', component: Questions },
  { path: '/about-us', component: AboutUs },
  { path: '/contacto', component: Contacto },
  // Nuevas rutas
  { path: '/team', component: Team },  // Ruta para el equipo
  { path: '/metodologia', component: Metodologia },  // Ruta para la metodología
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
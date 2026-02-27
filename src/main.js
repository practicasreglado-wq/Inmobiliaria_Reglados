import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importa el router
import store from './store';   // Si usas Vuex (deberías actualizar la configuración para Vue 3 también)

// Crear y montar la aplicación Vue 3
createApp(App)
  .use(router)  // Usa Vue Router
  .use(store)   // Usa Vuex (si lo tienes)
  .mount('#app'); // Monta la aplicación en el div con id="app"
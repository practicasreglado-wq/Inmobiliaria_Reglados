<template>
  <section class="profile">
    <!-- Menú lateral -->
    <div class="sidebar">
      <h3>Menú de perfil</h3>
      <ul>
        <li><router-link to="/profile/favorite-properties">Mis propiedades favoritas</router-link></li>
        <li><router-link to="/profile/messages">Mensajes</router-link></li>
        <li><router-link to="/profile/properties-for-sale">Mis propiedades en venta</router-link></li>
        <li><router-link to="/profile/settings">Ajustes</router-link></li>
      </ul>
    </div>

    <!-- Contenido principal -->
    <div class="profile-content">
      <!-- Datos del usuario -->
      <div v-if="user">
        <h2>Bienvenido/a {{ user.nombre_usuario }}</h2>
        <p><strong>Categoría seleccionada:</strong> {{ category }}</p>

        <!-- Preferencias del usuario -->
        <div v-if="preferences && hasPreferences">
          <h3>Preferencias:</h3>
          <template v-for="(group, key) in preferences" :key="key">
            <div v-if="Array.isArray(group) && group.length" class="pref-group">
              <h4>{{ formatLabel(key) }}</h4>
              <ul>
                <li v-for="(item, index) in group" :key="index">
                  {{ item }}
                </li>
              </ul>
            </div>
          </template>
        </div>

        <div v-else>
          <p>No tienes preferencias guardadas.</p>
        </div>
      </div>

      <!-- El contenido de las vistas cambia aquí -->
      <router-view></router-view>
    </div>
  </section>
</template>

<script>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { computed } from "vue";

export default {
  name: "Profile",

  setup() {
    const userStore = useUserStore();
    const { user, selectedCategory: category, preferences } = storeToRefs(userStore);

    const hasPreferences = computed(() => {
      if (!preferences.value) return false;
      return Object.values(preferences.value).some(
        arr => Array.isArray(arr) && arr.length > 0
      );
    });

    const formatLabel = (key) => {
      const labels = {
        estrellas: "Estrellas",
        servicios: "Servicios",
        ubicacion: "Ubicación",
        tipo: "Tipo",
        caracteristicas: "Características",
        zona: "Zona",
        uso: "Uso"
      };
      return labels[key] || key;
    };

    return {
      user,
      category,
      preferences,
      hasPreferences,
      formatLabel
    };
  }
};
</script>

<style scoped>
/* Estilo para el perfil con el menú lateral fijo y contenido dinámico */
.profile {
  display: flex;
  min-height: 100vh;
  background-color: #f4f4f4;
  box-sizing: border-box;
}

.sidebar {
  width: 250px; /* Ancho fijo del menú lateral */
  background-color: #fff;
  padding: 20px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar h3 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 20px;
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar ul li {
  margin: 10px 0;
}

.sidebar ul li a {
  text-decoration: none;
  color: #333;
  font-size: 1.1rem;
}

.profile-content {
  flex-grow: 1;
  padding: 70px;
  background-color: white;
  border-radius: 8px;
  margin-left: 1px; /* Ajuste para que el contenido se acomode al lado del menú lateral */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
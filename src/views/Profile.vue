<template>
  <section class="profile">
    <div class="profile-container">

      <div v-if="!user">
        <h2>Cargando perfil...</h2>
      </div>

      <div v-else>
        <h2>Perfil de {{ user.nombre }}</h2>

        <h3>Categoría seleccionada:</h3>
        <p class="category">{{ category }}</p>

        <div v-if="preferences && hasPreferences">
          <h3>Preferencias:</h3>

          <template v-for="(group, key) in preferences" :key="key">
            <div
              v-if="Array.isArray(group) && group.length"
              class="pref-group"
            >
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

    </div>
  </section>
</template>

<script>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { computed, onMounted } from "vue";

export default {
  name: "Profile",

  setup() {
    const userStore = useUserStore();
    const router = useRouter();

    const { user, selectedCategory: category, preferences } = storeToRefs(userStore);

    // Recuperar categoría y preferencias desde localStorage
    onMounted(() => {
      const savedCategory = localStorage.getItem('selectedCategory');
      if (savedCategory && !userStore.selectedCategory) {
        userStore.setCategory(savedCategory);  // Cargar la categoría desde localStorage
      }

      const savedPreferences = localStorage.getItem('preferences');
      if (savedPreferences) {
        userStore.setPreferences(JSON.parse(savedPreferences));  // Cargar las preferencias
      }
    });

    const changeCategory = () => {
      userStore.setCategory(null);
      localStorage.removeItem('selectedCategory'); // Eliminar categoría de localStorage si se cambia
      router.push("/dashboard");
    };

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
      changeCategory,
      formatLabel,
      hasPreferences
    };
  }
};
</script>
<style scoped>
  .profile {
  min-height: 100vh; /* Asegura que ocupe toda la altura de la pantalla */
  display: flex; /* Flexbox para centrar contenido */
  justify-content: center; /* Centra horizontalmente */
  align-items: center; /* Centra verticalmente */
  background-color: var(--gris-claro); /* Color de fondo */
}

.profile-container {
  text-align: center; /* Alinea el texto al centro */
  padding: 20px; /* Añadir algo de relleno */
  background-color: white; /* Fondo blanco para el contenedor */
  border-radius: 8px; /* Bordes redondeados */
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
  width: 100%; /* Para que el contenedor ocupe todo el espacio disponible */
  max-width: 600px; /* Limitar el ancho máximo */
}

.category {
  font-weight: bold;
  font-size: 1.3rem;
}

.pref-group {
  margin-bottom: 20px;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  background-color: #f3f3f3;
  margin: 5px 0;
  padding: 6px 10px;
  border-radius: 6px;
}

button {
  margin-top: 25px;
  padding: 12px;
  border-radius: 6px;
  border: none;
  background-color: var(--azul-principal);
  color: white;
  cursor: pointer;
}
</style>

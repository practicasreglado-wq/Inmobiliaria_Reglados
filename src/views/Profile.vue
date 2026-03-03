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
import { computed } from "vue";

export default {
  name: "Profile",

  setup() {
    const userStore = useUserStore();
    const router = useRouter();

    const { user, selectedCategory: category, preferences } = storeToRefs(userStore);
    const changeCategory = () => {
      userStore.setCategory(null);
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

<template>
  <section class="profile">
    <div class="profile-container">

      <h2>Perfil de {{ user?.nombre }}</h2>

      <h3>Categoría seleccionada:</h3>
      <p>{{ category }}</p>

      <h3>Preferencias:</h3>
      <pre>{{ preferences }}</pre>

      <button @click="changeCategory">
        Cambiar categoría
      </button>

    </div>
  </section>
</template>

<script>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";

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

    return {
      user,
      category,
      preferences,
      changeCategory
    };
  }
};
</script>

<style scoped>
.profile {
  min-height: 100vh;
  padding-top: 120px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.profile-container {
  text-align: center;
}
</style>
<template>
  <section class="dashboard">
    <div class="dashboard-container">

      <!-- Solo mostramos carrusel si no hay categoría -->
      <Carousel v-if="!category" />

    </div>
  </section>
</template>

<script>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { onMounted } from "vue";
import Carousel from "../components/Carousel.vue";

export default {
  name: "Dashboard",
  components: { Carousel },

  setup() {
    const userStore = useUserStore();
    const router = useRouter();

    const { selectedCategory: category } = storeToRefs(userStore);

    onMounted(() => {
      // 🔥 Si ya tiene categoría → ir directamente al perfil
      if (category.value) {
        router.push("/profile");
      }
    });

    return {
      category
    };
  }
};
</script>

<style scoped>
.dashboard {
  min-height: 100vh;
  padding-top: 120px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: var(--gris-claro);
}

.dashboard-container {
  text-align: center;
}
</style>
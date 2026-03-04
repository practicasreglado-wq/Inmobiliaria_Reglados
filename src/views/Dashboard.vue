<template>
  <section class="dashboard">
    <div class="dashboard-container">
      <!-- Siempre mostramos el carrusel, sin importar si hay categoría seleccionada o no -->
      <Carousel />
    </div>
  </section>
</template>

<script>
import Carousel from "../components/Carousel.vue";

export default {
  name: "Dashboard",
  components: { Carousel },

  setup() {
    return {};
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
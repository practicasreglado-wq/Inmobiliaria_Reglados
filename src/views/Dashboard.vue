<template>
  <section class="dashboard">
    <div class="dashboard-container">
      <Carousel />
    </div>
  </section>
</template>

<script>
import Carousel from '../components/Carousel.vue';

export default {
  name: "Dashboard",
  components: {
    Carousel
  }
};
</script>
<style scoped>
.dashboard {
  min-height: 100vh;
  padding-top: 120px; /* compensa header fixed */

  display: flex;
  justify-content: center;  /* horizontal */
  align-items: center;      /* vertical */

  background-color: var(--gris-claro);
}

.dashboard-content {
  text-align: center;
}

.dashboard h2 {
  font-size: 2.5rem;
  margin-bottom: 30px;
  color: var(--negro);
}
</style>
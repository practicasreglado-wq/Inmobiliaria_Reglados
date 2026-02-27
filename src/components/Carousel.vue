<template>
  <div class="carousel">
    <button @click="selectCategory('hotels')">Comprar Hoteles</button>
    <button @click="selectCategory('parking')">Comprar Parking</button>
    <button @click="selectCategory('houses')">Comprar Casas</button>
  </div>
</template>

<script>
export default {
  name: "Carousel",
  methods: {
    selectCategory(category) {
      this.$router.push({ name: category });
    }
  }
};
</script>

<style scoped>
.carousel button {
  background-color: #457b9d;
  color: white;
  padding: 10px;
  font-size: 16px;
  cursor: pointer;
}

.carousel button:hover {
  background-color: #1d3557;
}
</style>
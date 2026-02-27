<template>
  <div>
    <h2>Datos de la Empresa</h2>
    <p>Información sobre la empresa inmobiliaria.</p>
    <Carousel />
  </div>
</template>

<script>
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
import Carousel from '../components/Carousel.vue';

export default {
  name: "Home",
  components: {
    Header,
    Footer,
    Carousel
  }
};
</script>
<template>
  <div>
    <Header />
    <h2>Bienvenido al Dashboard</h2>
    <Carousel />
    <Footer />
  </div>
</template>

<script>
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
import Carousel from '../components/Carousel.vue';

export default {
  name: "Dashboard",
  components: {
    Header,
    Footer,
    Carousel
  }
};
</script>
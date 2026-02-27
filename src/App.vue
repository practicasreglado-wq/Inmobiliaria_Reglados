<template>
  <div id="app">
    <Header />
    <div>
      <router-view />
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

export default {
  components: {
    Header,
    Footer
  }
}
</script>

<style scoped>
/* Establecer que el cuerpo y la raíz ocupen todo el alto de la ventana */
html, body {
  height: 100%;
  margin: 0;
}

/* Hacer que el contenedor principal sea un contenedor flex */
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Asegura que la altura mínima de la página sea 100% */
}

/* Hacer que el contenido principal ocupe todo el espacio disponible */
.main-content {
  flex: 1; /* Esto hace que el contenido ocupe el espacio restante entre el header y el footer */
  padding: 20px; /* Puedes ajustar el padding a tus necesidades */
}

/* Estilos generales de Header y Footer */
header, footer {
  width: 100%;
}

footer {
  background-color: #1d3557; /* Cambia según tus preferencias */
  color: white;
  text-align: center;
  padding: 20px;
}
</style>
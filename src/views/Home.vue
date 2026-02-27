<template>
  <section class="home">
    <div class="content">
      <h2>Encuentra el inmueble que se adapta a tus necesidades</h2>
      <p>Registra tu búsqueda, explora nuestras opciones y recibe alertas cuando lleguen nuevas oportunidades</p>
      <button>Ver Más</button>
    </div>
  </section>
</template>

<script>
export default {
  name: "Home",
};
</script>

<style scoped>
/* Estilos para la página Home */
.home {
  background-image: url('/src/assets/FondoPrueba.png'); /* Asegúrate de usar la ruta correcta de la imagen */
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: white;
}

.content {
  max-width: 800px;
  padding: 20px;
  background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semitransparente para el texto */
  border-radius: 10px;
}

h2 {
  font-size: 3rem;
  font-weight: bold;
  margin-bottom: 20px;
  color: #d4af37; /* Dorado para el título */
}

p {
  font-size: 1.2rem;
  margin-bottom: 30px;
}

button {
  background-color: #d4af37; /* Botón dorado */
  color: white;
  padding: 15px 30px;
  font-size: 1.2rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

button:hover {
  background-color: #000000; /* Fondo negro al pasar el mouse */
  color: #d4af37; /* Texto dorado al pasar el mouse */
}
</style>
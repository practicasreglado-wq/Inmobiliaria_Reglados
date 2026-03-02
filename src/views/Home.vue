<template>
  <section class="hero">
    <div class="overlay"></div>

    <div class="hero-content">
      <h1>
        <span class="highlight">Reglado</span> State
      </h1>

      <p class="description">
        Encuentra el inmueble que se adapta a tus necesidades.
        Registra tu búsqueda, explora nuestras opciones y recibe alertas
        cuando lleguen nuevas oportunidades.
      </p>

      <p class="subtext">
        La forma más fácil de comprar o vender
      </p>
    </div>
  </section>
</template>

<script>
export default {
  name: "Home",
};
</script>

<style scoped>
.hero {
  position: relative;
  height: 100vh;
  background-image: url('/src/assets/img_Home.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center; /* 👈 centramos horizontalmente */
  padding-left: 20px; /* 👈 espacio a la izquierda */;
  padding-right: 33%; /* 👈 espacio a la derecha */
}

/* Overlay oscuro para que el texto se lea bien */
.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.018);
}

/* Contenido encima del overlay */
.hero-content {
  position: relative;
  z-index: 2;
  width: 90%;           /* 👈 ahora ocupa todo el ancho */
  max-width: 100%;       /* 👈 eliminamos la limitación */
  text-align: start;    /* 👈 opcional pero recomendable */
  color: white;
}
.hero h1 {
  font-size: 7rem;
  margin-bottom: 20px;
}

.highlight {
  color: rgb(220, 185, 97);
}

.description {
  font-size: 2.75rem;
  line-height: 1.6;
  margin-bottom: 20px;
}

.subtext {
  font-size: 1.5rem;
  opacity: 0.85;
}
</style>
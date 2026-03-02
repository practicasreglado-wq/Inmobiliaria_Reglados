<template>
  <section class="about">

    <!-- Lado izquierdo (placeholders imágenes) -->
    <div class="about-images">
      <div class="img-small"></div>
      <div class="img-large"></div>
    </div>

    <!-- Lado derecho (texto) -->
    <div class="about-content">
      <h2>Quiénes somos</h2>

      <p>
        En RS Inmobiliaria ayudamos a nuestros clientes a encontrar el hogar
        ideal y las mejores oportunidades de inversión. Nuestro equipo combina
        experiencia, cercanía y profesionalidad para ofrecer un servicio
        inmobiliario transparente y personalizado.
      </p>

      <p>
        Creemos en la confianza, la calidad y el compromiso como pilares
        fundamentales de nuestro trabajo.
      </p>
    </div>

  </section>
</template>

<script>
export default {
  name: "AboutUs"
};
</script>

<style scoped>
.about {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 80px;
  padding: 0 80px 0 100px;
  background-color: var(--gris-claro);
}

/* ----- IMÁGENES (simuladas) ----- */

.about-images {
  display: flex;
  gap: 30px;
}

.img-small {
  width: 200px;
  height: 280px;
  background-color: #d9d9d9;
}

.img-large {
  width: 200px;
  height: 350px;
  background-color: #cfcfcf;
}

/* ----- CONTENIDO ----- */

.about-content {
  max-width: 700px;
}

.about-content h2 {
  font-size: 3.5rem;
  margin-bottom: 25px;
  color: var(--negro);
}

.about-content p {
  font-size: 1.3rem;
  line-height: 1.7;
  margin-bottom: 20px;
  color: #333;
}
</style>
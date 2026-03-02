<template>
  <div class="contacto">
    <div class="overlay"></div>
    <!-- Lado izquierdo -->
    <div class="contacto-texto">
      <h1>
        <span class="highlight">Crea tu cuenta</span>
      </h1>

      <p>
        Obtén acceso a listados premium y recomendaciones personalizadas.
      </p>

      <div class="login-link">
        ¿Ya tienes una cuenta?
        <span @click="$router.push('/login')">Login</span>
      </div>
    </div>

    <!-- Tarjeta derecha -->
    <div class="contacto-card">
      <h2>Contáctanos</h2>

      <form class="formulario">
        <div class="row">
          <input type="text" placeholder="Nombre" required />
          <input type="text" placeholder="Apellido" required />
        </div>

        <textarea placeholder="Mensaje" rows="4" required></textarea>

        <button type="submit" class="enviar-btn">Enviar</button>
      </form>

      <div class="info">
        <div class="item">
          <span class="dot"></span> Teléfono
        </div>
        <div class="item">
          <span class="dot"></span> Correo
        </div>
        <div class="item">
          <span class="dot"></span> Ubicación
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "Contacto"
};
</script>

<style scoped>
.contacto {
  position: relative;
  min-height: 100vh;
  background-color: var(--gris-claro);
  /* background-image: url('@/assets/img_Home.png'); */
  background-size: cover;
  background-position: center;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 100px;
  gap: 60px;
}

/* Overlay oscuro */
.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.142);
  z-index: 0;
}

/* Texto y card por encima del overlay */
.contacto-texto,
.contacto-card {
  position: relative;
  z-index: 1;
}
/* ----------- TEXTO IZQUIERDA ----------- */

.contacto-texto {
  color: white;
  max-width: 500px;
}

.contacto-texto h1 {
  font-size: 3rem;
  margin-bottom: 20px;
}

.highlight {
  color: #d4af37;
}

.contacto-texto p {
  font-size: 1.2rem;
  margin-bottom: 30px;
}

.login-link {
  font-size: 1rem;
}

.login-link span {
  color: #d4af37;
  cursor: pointer;
  font-weight: bold;
  margin-left: 5px;
}

.login-link span:hover {
  text-decoration: underline;
}

/* ----------- TARJETA DERECHA ----------- */

.contacto-card {
  width: 420px;
  background: rgba(255, 255, 255, 0.95);
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

h2 {
  margin-bottom: 25px;
  font-size: 1.8rem;
  color: #111;
}

/* Inputs en fila */
.row {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
}

input, textarea {
  width: 100%;
  padding: 10px;
  border: 2px solid var(--azul-principal);
  border-radius: 6px;
  font-size: 0.95rem;
  outline: none;
}

textarea {
  resize: none;
  margin-bottom: 20px;
}

/* Botón */
.enviar-btn {
  background-color: var(--azul-principal);
  color: white;
  padding: 8px 25px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s ease;
}

.enviar-btn:hover {
  background-color: var(--azul-secundario);
}

/* Info debajo */
.info {
  margin-top: 25px;
}

.item {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
  font-size: 0.95rem;
}

.dot {
  width: 12px;
  height: 12px;
  background-color: var(--azul-principal);
  border-radius: 50%;
}
</style>
<template>
  <div class="contacto">
    <div class="contacto-container">
      <h2>Contacto</h2>

      <p class="descripcion">
        Puedes ponerte en contacto con nosotros a través de los siguientes medios:
      </p>

      <div class="info">
        <p><strong>Teléfono:</strong> +34 600 000 000</p>
        <p><strong>Email:</strong> info@rsinmobiliaria.com</p>
        <p><strong>Dirección:</strong> Calle Principal 123, Madrid</p>
      </div>

      <form class="formulario">
        <input type="text" placeholder="Tu nombre" required />
        <input type="email" placeholder="Tu email" required />
        <textarea placeholder="Escribe tu mensaje..." rows="5" required></textarea>
        <button type="submit">Enviar mensaje</button>
      </form>
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
  min-height: 100vh;
  padding-top: 120px; /* para compensar el header fixed */
  display: flex;
  justify-content: center;
  align-items: flex-start;
  background-color: #f5f5f5;
}

.contacto-container {
  width: 90%;
  max-width: 800px;
  background: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #d4af37;
  font-size: 2.5rem;
}

.descripcion {
  text-align: center;
  margin-bottom: 30px;
}

.info {
  margin-bottom: 30px;
  line-height: 1.8;
}

.formulario {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

input, textarea {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
}

button {
  background-color: #d4af37;
  color: black;
  padding: 12px;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

button:hover {
  background-color: black;
  color: #d4af37;
}
</style>
<template>
  <header>
    <div class="logo">
      <h1>RS Inmobiliaria</h1>
    </div>
    <nav>
      <ul>
        <li><router-link to="/">Inicio</router-link></li>
        <li><router-link to="/contacto">Contacto</router-link></li>
        <li><router-link to="/login">Login</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: "Header",
};
</script>

<style scoped>
/* Estilos para el Header */
header {
  background-color: #00000037; /* Fondo negro */
  color: #ffffff; /* Texto blanco */
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 40px;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
}

header .logo h1 {
  font-size: 2.5rem;
  color: #d4af37; /* Dorado para el logo */
  margin: 0;
}

nav ul {
  list-style-type: none;
  display: flex;
  gap: 20px;
}

nav a {
  text-decoration: none;
  color: #ffffff;
  font-size: 1.2rem;
  padding: 8px 15px;
  border-radius: 5px;

}

nav a:hover {
  background-color: #d4af37; /* Fondo dorado al pasar el mouse */
  color: #000000; /* Cambiar color del texto a negro al pasar el mouse */
}
</style>
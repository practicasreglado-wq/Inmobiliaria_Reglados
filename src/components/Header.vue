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
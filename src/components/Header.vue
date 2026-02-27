<template>
  <header>
    <h1>Bienvenido a nuestra Inmobiliaria</h1>
    <nav>
      <ul>
        <li><router-link to="/">Inicio</router-link></li>
        <li><router-link to="/login">Login</router-link></li>
        <li><router-link to="/register">Registro</router-link></li>
        <li><router-link to="/dashboard">Dashboard</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: "Header"
};
</script>

<style scoped>
nav ul {
  list-style-type: none;
  display: flex;
  justify-content: center;
  gap: 20px;
}

nav a {
  text-decoration: none;
  color: white;
  font-size: 18px;
}

nav a:hover {
  text-decoration: underline;
}
</style>
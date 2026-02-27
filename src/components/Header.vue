<template>
  <header>
    <h1>Bienvenido a nuestra Inmobiliaria</h1>
    <nav>
      <ul>
        <li><router-link to="/">Inicio</router-link></li>
        <!-- Agregar "Sobre Nosotros" -->
        <li><router-link to="/about-us">Sobre Nosotros</router-link></li>
        
        <!-- Enlace de "Contacto" que redirige a la sección de contacto del footer -->
        <li><a href="#contacto">Contacto</a></li>
        
        <!-- Mostrar el enlace de Login solo si no está logueado, de lo contrario, mostrar Dashboard -->
        <li v-if="!isLoggedIn"><router-link to="/login">Login</router-link></li>
        <li v-if="!isLoggedIn"><router-link to="/register">Registro</router-link></li>
        
        <!-- Mostrar el enlace de Dashboard solo si está logueado -->
        <li v-if="isLoggedIn"><router-link to="/dashboard">Dashboard</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {
      isLoggedIn: false,  // Aquí manejarás el estado de autenticación (por ahora en falso)
    };
  },
  mounted() {
    // Aquí puedes verificar si el usuario está logueado y actualizar el estado de isLoggedIn
    // Ejemplo de un mock de autenticación:
    const user = localStorage.getItem('user'); // Si el usuario está logueado, lo buscarías en el localStorage
    if (user) {
      this.isLoggedIn = true;
    }
  }
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
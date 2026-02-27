<template>
  <div>
    <Header />
    <h2>Mi Perfil</h2>
    <p>Nombre de usuario: {{ username }}</p>
    <p>Correo electrónico: {{ email }}</p>
    <Footer />
  </div>
</template>

<script>
export default {
  name: "UserProfile",
  data() {
    return {
      username: 'Usuario de Ejemplo',
      email: 'user@example.com'
    };
  }
};
</script>
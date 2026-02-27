<template>
  <div>
    <Header />
    <form @submit.prevent="register">
      <input type="text" v-model="username" placeholder="Nombre de usuario" required />
      <input type="email" v-model="email" placeholder="Correo electrónico" required />
      <input type="password" v-model="password" placeholder="Contraseña" required />
      <button type="submit">Registrarse</button>
    </form>
    <Footer />
  </div>
</template>

<script>
export default {
  name: "Register",
  data() {
    return {
      username: '',
      email: '',
      password: ''
    };
  },
  methods: {
    register() {
      // Lógica de registro
      console.log(this.username, this.email, this.password);
    }
  }
};
</script>
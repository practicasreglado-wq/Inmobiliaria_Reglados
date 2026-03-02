<template>
  <div class="login">
    <h2>Iniciar Sesión</h2>

    <form @submit.prevent="login">
      <input type="email" v-model="email" placeholder="Email" required />
      <input type="password" v-model="password" placeholder="Contraseña" required />
      <button type="submit">Entrar</button>
    </form>

    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
export default {
  name: "Login",

  data() {
    return {
      email: "",
      password: "",
      error: ""
    };
  },

  methods: {
    async login() {
      this.error = "";

      try {
        const response = await fetch("http://localhost/inmobiliaria/backend/login.php", {
        method: "POST",
        credentials: "include",   // 🔥 IMPORTANTE
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          email: this.email,
          password: this.password
        })
      });

        if (!response.ok) {
          throw new Error("Error servidor");
        }

        const data = await response.json();

        if (data.success) {
          localStorage.setItem("user", JSON.stringify(data.user));
          this.$router.push("/dashboard");
        } else {
          this.error = data.message;
        }

      } catch (err) {
        console.error(err);
        this.error = "No se pudo conectar con el servidor";
      }
    }
  }
};
</script>
<style scoped>
.login {
  margin-top: 220px;
}
</style>
<template>
  <div class="register">
    <div class="vent-register">
      <h2>Bienvenido</h2>

      <form @submit.prevent="register">
        <div class="grid">
          <input type="text" v-model="nombre" placeholder="Nombre" required />
          <input type="text" v-model="apellido" placeholder="Apellido" required />
          <input type="email" v-model="email" placeholder="Correo electrónico" required />
          <input type="text" v-model="telefono" placeholder="Teléfono" required />
          <input type="text" v-model="username" placeholder="Nombre de usuario" required />
          <input type="password" v-model="password" placeholder="Contraseña" required />
        </div>

        <button type="submit" class="register-btn">
          Registrarse
        </button>
      </form>

      <p v-if="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script>
import { useUserStore } from "../stores/user";

export default {
  name: "Register",

  data() {
    return {
      nombre: "",
      apellido: "",
      email: "",
      telefono: "",
      username: "",
      password: "",
      error: ""
    };
  },

  methods: {
    async register() {
      this.error = "";

      const userStore = useUserStore(); // ✅ esto sí funciona aquí

      try {
        const response = await fetch(
          "http://localhost/inmobiliaria/backend/register.php",
          {
            method: "POST",
            credentials: "include",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              nombre: this.nombre,
              apellido: this.apellido,
              email: this.email,
              telefono: this.telefono,
              username: this.username,
              password: this.password
            })
          }
        );

        const text = await response.text();
        console.log("RESPUESTA CRUDA:", text);

        const data = JSON.parse(text);

        if (data.success) {

          // 🔥 Guardar usuario en Pinia
          userStore.setUser(data.user);

          // 🔥 Redirigir correctamente
          this.$router.push("/dashboard");

        } else {
          this.error = data.message;
        }

      } catch (err) {
        console.error("Error real:", err);
        this.error = "Error de conexión con el servidor";
      }
    }
  }
};
</script>
<style scoped>
.register {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: var(--gris-claro);
}

.register h2 {
  font-size: 3.5rem;
  text-align: center;
}

.vent-register {
  background-color: white;
  padding: 0 40px 25px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Tarjeta */
form {
  border-radius: 14px;
  width: 700px;
}

/* Grid 2 columnas */
.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 25px;
}

input {
  padding: 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

input:focus {
  outline: none;
  border-color: var(--azul-principal);
}

/* Botón abajo */
.register-btn {
  display: block;          /* necesario para centrar */
  width: 250px;
  margin: 0 auto;
  padding: 12px;
  border-radius: 8px;
  border: none;
  background-color: var(--azul-principal);
  color: white;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  transition: 0.3s ease;
}

.register-btn:hover {
  background-color: var(--azul-secundario);
}

</style>
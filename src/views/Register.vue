<template>
  <div class="register">
    <div class="overlay"></div>

    <div class="vent-register">
      <h2>Bienvenido</h2>

      <form @submit.prevent="register">
        <div class="grid">
          
          <input type="text" v-model="nombre" placeholder="Nombre" required />
          <input type="text" v-model="apellido" placeholder="Apellido" required />

          <input type="email" v-model="email" placeholder="Correo electrónico" required />
          <input type="text" v-model="telefono" placeholder="Teléfono" required />

          <input type="text" v-model="username" placeholder="Nombre de usuario" required />

<div class="fecha-nacimiento">
  <label>Fecha de nacimiento (debes ser mayor de 18 años)</label>
  <input
    type="date"
    v-model="fechaNacimiento"
    :max="maxDate"
    required
    >
</div>

<input
  type="password"
  v-model="password"
  placeholder="Contraseña"
  required
  pattern="^(?=.*[A-Z])(?=.*[0-9]).{8,}$"
/>

<input
  type="password"
  v-model="confirmPassword"
  placeholder="Confirmar contraseña"
  required
/>

        </div>

        <p v-if="passwordError" class="rules">
          La contraseña debe tener mínimo 8 caracteres, una mayúscula y un número
        </p>

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

  data() {
    return {
      nombre: "",
      apellido: "",
      email: "",
      telefono: "",
      username: "",
      password: "",
      confirmPassword: "",
      fechaNacimiento: "",
      error: ""
    };
  },

  computed: {

    maxDate(){
    const today = new Date()
    today.setFullYear(today.getFullYear()-18)
    return today.toISOString().split("T")[0]
    },

    passwordError() {
      const regex = /^(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
      return this.password && !regex.test(this.password);
    }

  },

  methods: {

    calcularEdad(fecha) {
      const hoy = new Date();
      const nacimiento = new Date(fecha);

      let edad = hoy.getFullYear() - nacimiento.getFullYear();
      const mes = hoy.getMonth() - nacimiento.getMonth();

      if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
      }

      return edad;
    },

    async register() {

      this.error = "";

      if (this.password !== this.confirmPassword) {
        this.error = "Las contraseñas no coinciden";
        return;
      }

      if (this.passwordError) {
        this.error = "La contraseña no cumple los requisitos";
        return;
      }

      if (this.calcularEdad(this.fechaNacimiento) < 18) {
        this.error = "Debes ser mayor de 18 años";
        return;
      }

      const userStore = useUserStore();

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
              password: this.password,
              confirmPassword: this.confirmPassword,
              fechaNacimiento: this.fechaNacimiento
            })
          }
        );

        const data = await response.json();

        if (data.success) {

          alert("Revisa tu correo para activar la cuenta");

          this.$router.push("/login");

        } else {

          this.error = data.message;

        }

      } catch (error) {

        this.error = "Error de conexión con el servidor";

      }

    }

  }

};
</script>

<style scoped>
.fecha-nacimiento{
  display:flex;
  flex-direction:column;
}

.fecha-nacimiento label{
  font-size:13px;
  color:#555;
  margin-bottom:4px;
}
.register {
  position: relative;
  min-height: 100vh;
  background-image: url('@/assets/fondito.png');
  background-size: cover;
  background-position: center;
  display: flex;
  justify-content: center;
  align-items: center;
}

.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.4);
}

.vent-register {
  background: white;
  padding: 30px 40px;
  border-radius: 10px;
  z-index: 1;
}

h2 {
  text-align: center;
  font-size: 2.5rem;
}

form {
  width: 700px;
}

.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

input {
  padding: 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.rules {
  color: red;
  margin-top: 10px;
}

.error {
  color: red;
  margin-top: 15px;
}

.register-btn {
  margin-top: 20px;
  width: 250px;
  padding: 12px;
  display: block;
  margin-left: auto;
  margin-right: auto;
  background: #2c6bed;
  border: none;
  border-radius: 8px;
  color: white;
  font-weight: bold;
  cursor: pointer;
}

</style>
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
    </div>
    
  </div>
</template>

<script>
export default {
  name: "Register",

  data() {
    return {
      nombre: "",
      apellido: "",
      email: "",
      telefono: "",
      username: "",
      password: ""
    };
  },

  methods: {
    register() {
      console.log(
        this.nombre,
        this.apellido,
        this.email,
        this.telefono,
        this.username,
        this.password
      );
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
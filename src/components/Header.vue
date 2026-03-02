<template>
  <header>
    <div class="logo">
      <h1>RS</h1>
    </div>

    <nav>
<<<<<<< Updated upstream
      <ul>
        <li>
          <router-link to="/">Inicio</router-link>
        </li>

        <li>
          <router-link to="/contacto">Contacto</router-link>
        </li>

        <!-- Si NO está logueado -->
        <li v-if="!user">
          <router-link to="/login">Login</router-link>
        </li>

        <!-- Si está logueado -->
        <li v-if="user">
          <router-link to="/dashboard">Dashboard</router-link>
        </li>

        <li v-if="user" class="bienvenido">
          Bienvenido {{ user.nombre }}
        </li>

        <li v-if="user">
          <button class="logout-btn" @click="logout">
            Cerrar sesión
          </button>
        </li>
      </ul>
=======
      <router-link to="/">Inicio</router-link>
      <router-link to="/about-us">Sobre Nosotros</router-link>
      <router-link to="/properties">Contacto</router-link>
      <!-- Botón Login -->
      <router-link to="/login" class="login-btn">
        Login
      </router-link>
>>>>>>> Stashed changes
    </nav>
  </header>
</template>

<script>
export default {
  name: "Header",

  data() {
    return {
      user: null
    };
  },

  mounted() {
    const userData = localStorage.getItem("user");

    if (userData) {
      this.user = JSON.parse(userData);
    }
  },

  methods: {
    logout() {
      localStorage.removeItem("user");
      this.user = null;
      this.$router.push("/");
    }
  }
};
</script>

<style scoped>
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;

  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 60px;

  /* ✨ Cristal real */
  background: rgba(255, 255, 255, 0);   /* más visible */
  backdrop-filter: blur(18px);             /* más desenfoque */
  -webkit-backdrop-filter: blur(18px);
  box-sizing: border-box;
}

header .logo h1 {
  font-size: 2.8rem;
  font-weight: 700;
  margin: 0;
  color: var(--negro);
  letter-spacing: 2px;
}

/* Nav horizontal */
nav {
  display: flex;
  align-items: center;
  gap: 40px;
}

/* Links normales */
nav a {
  text-decoration: none;
  color: var(--negro);
  font-size: 1.5rem;
  font-weight: bold;
  transition: 0.3s ease;
}

nav a:hover {
  color: var(--azul-secundario);
}

/* 👇 Login como botón */
nav a:last-child {
  background-color: rgb(39, 56, 103);
  color: var(--blanco);
  padding: 10px 22px;
  border-radius: 8px;
  font-weight: 600;
}

nav a:last-child:hover {
  background-color: rgb(69, 129, 198);
  color: var(--blanco);
}

.bienvenido {
  color: #d4af37;
  font-weight: bold;
  display: flex;
  align-items: center;
}

.logout-btn {
  background-color: #d4af37;
  color: black;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.3s;
}

.logout-btn:hover {
  background-color: white;
  color: black;
}
</style>
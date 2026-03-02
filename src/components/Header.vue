<template>
  <header>
    <div class="logo">
      <h1>RS</h1>
    </div>

    <nav>
      <ul>
        <li>
          <router-link to="/">Inicio</router-link>
        </li>
        <li>
          <router-link to="/about-us">Sobre Nosotros</router-link>
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
    async logout() {
      await fetch("http://localhost/inmobiliaria/backend/logout.php", {
        credentials: "include"
      });

      localStorage.removeItem("user");
      this.$router.push("/");
      window.location.reload();
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
  background: rgba(255, 255, 255, 0.331);
  backdrop-filter: blur(18px);
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

/* 🔥 UL horizontal sin puntos */
nav ul {
  list-style: none;
  margin: 0;
  padding: 0;

  display: flex;
  align-items: center;
  gap: 35px;
}

/* Links normales */
nav a {
  text-decoration: none;
  color: var(--negro);
  font-size: 1.1rem;
  font-weight: 600;
  transition: 0.3s ease;
}

nav a:hover {
  color: var(--azul-secundario);
}

/* 🔵 Login como botón */
nav a[href="/login"] {
  background-color: rgb(39, 56, 103);
  color: var(--blanco);
  padding: 10px 22px;
  border-radius: 8px;
}

nav a[href="/login"]:hover {
  background-color: rgb(69, 129, 198);
  color: var(--blanco);
}

/* Bienvenido */
.bienvenido {
  color: #d4af37;
  font-weight: bold;
}

/* Botón logout */
.logout-btn {
  background-color: #d4af37;
  color: black;
  border: none;
  padding: 8px 15px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.3s;
}

.logout-btn:hover {
  background-color: white;
}
</style>
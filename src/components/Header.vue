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
          <router-link to="/login" class="btn-login">Login</router-link>
        </li>

        <!-- Si está logueado -->
        <li v-if="user">
          <button class="catalog-btn" @click="goToCatalog">
            Búsqueda por catálogo
          </button>
        </li>

        <!-- Bienvenida con foto o iniciales -->
        <li v-if="user">
          <router-link to="/profile" class="bienvenido">
            <div class="user-avatar">
              <!-- Mostrar la foto si está disponible -->
              <img v-if="user?.photo" :src="user.photo" alt="Avatar" class="avatar-img" />
              <!-- Si no hay foto, mostrar las iniciales -->
              <span v-else>{{ getInitials(user.nombre, user.apellidos) }}</span>
            </div>
          </router-link>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";

export default {
  name: "Header",

  setup() {
    const userStore = useUserStore();
    const router = useRouter();
    const { user } = storeToRefs(userStore);

    const logout = async () => {
      await fetch("http://localhost/inmobiliaria/backend/logout.php", {
        credentials: "include"
      });

      userStore.logout();
      router.push("/");
    };

    const goToCatalog = () => {
      router.push("/dashboard");
    };

    // Función para obtener las iniciales del nombre y apellido
    const getInitials = (firstName, lastName) => {
      const firstInitial = firstName ? firstName.charAt(0).toUpperCase() : '';
      const lastInitial = lastName ? lastName.charAt(0).toUpperCase() : '';
      return firstInitial + lastInitial;
    };

    return {
       user,
      logout,
      goToCatalog,
      getInitials
    };
  }
};
</script>

<style scoped>
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 90px;
  z-index: 1000;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 60px;
  background: rgba(255, 255, 255, 0.447);
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

nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  align-items: center;
  gap: 35px;
}

nav a, .catalog-btn {
  text-decoration: none;
  color: var(--negro);
  font-size: 1.1rem;
  font-weight: 600;
  transition: 0.3s ease;
}

nav a:hover, .catalog-btn:hover {
  color: var(--azul-secundario);
}

.catalog-btn {
  background: rgba(255, 255, 255, 0);
  font-size: 1rem;
  border: none;
  cursor: pointer;
  text-decoration: none;
  padding: 10px 22px;
  color: var(--negro);
}

.btn-login{
  font-size: 1em;
  background-color: var(--azul-principal);
  color: white;
  padding: 8px 25px;
  border: none;
  border-radius: 6px;
  transition: 0.3s ease;
}

.btn-login:hover{
  background-color: var(--azul-secundario);
  color: white;
}

.bienvenido {
  color: #d4af37;
  font-weight: bold;
  font-size: 1.1rem;
  text-decoration: none;
  cursor: pointer;
  transition: 0.3s;
}

.bienvenido:hover {
  color: var(--azul-secundario);
}

.user-avatar {
  display: inline-block;
  width: 50px; /* Tamaño más grande */
  height: 50px;
  border-radius: 50%;
  background-color: var(--azul-principal);
  text-align: center;
  color: white;
  line-height: 50px;
  font-weight: bold;
  margin-right: 10px;
  font-size: 1.3rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra ligera */
}

.avatar-img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.logout-btn {
  font-size: 1rem;
  background-color: rgb(39, 56, 103);
  color: white;
  border: none;
  padding: 8px 15px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.3s;
}

.logout-btn:hover {
  background-color: var(--azul-secundario);
}

nav a.router-link-exact-active:not(.btn-login) {
  color: var(--azul-secundario);
}
</style>
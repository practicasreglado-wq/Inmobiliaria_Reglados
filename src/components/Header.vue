<template>
  <header>
    <div class="logo">
      <router-link to="/" class="logo-text">
        <h1>RS</h1>
      </router-link>
    </div>

    <nav>
      <ul>
        <!-- Si NO está logueado -->
        <li v-if="!user">
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
            <!-- Mostrar foto -->
            <img
              v-if="user?.profile_picture"
              :src="'http://localhost/inmobiliaria/backend/' + user.profile_picture"
              alt="Avatar"
              class="avatar-img"
            />

            <!-- Si no hay foto -->
            <span v-else>{{ getInitials() }}</span>
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

    console.log(user.value)

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

    // Función para obtener las iniciales del nombre
    const getInitials = () => {
      if (!user.value) return "U";

      const first = user.value.nombre?.charAt(0).toUpperCase() || "";

      return first || "U";
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
  background: rgba(255, 255, 255, 0.639);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  box-sizing: border-box;
}

/* LOGO */

header .logo h1 {
  font-size: 2.8rem;
  font-weight: 700;
  margin: 0;
  letter-spacing: 2px;
  background: linear-gradient(
    135deg,
    #5f4b08 0%,
    #bd9b2c 20%,
    #c9a227 45%,
    #f2d46b 55%,
    #c6a233 75%,
    #6e560c 100%
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-shadow: 0 2px 3px rgba(186, 129, 15, 0.532);
}

.logo-text {
  text-decoration: none;
}

.logo-text:hover {
  text-decoration: none;
}

/* NAV */

nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  align-items: center;
  gap: 35px;
}

nav a,
.catalog-btn {
  text-decoration: none;
  color: var(--negro);
  font-size: 1.1rem;
  font-weight: 600;
  transition: 0.3s ease;
}

nav a:hover,
.catalog-btn:hover {
  color: var(--azul-secundario);
}

/* BOTÓN CATÁLOGO */

.catalog-btn {
  background: rgba(255, 255, 255, 0);
  font-size: 1rem;
  border: none;
  cursor: pointer;
  padding: 10px 22px;
  color: var(--negro);
}

/* BIENVENIDA */

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

/* AVATAR */

.user-avatar {
  display: inline-block;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: var(--azul-principal);
  text-align: center;
  color: white;
  line-height: 50px;
  font-weight: bold;
  margin-right: 10px;
  font-size: 1.3rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.avatar-img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}

/* LOGOUT */

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

nav a.router-link-exact-active{
  color: var(--azul-secundario);
}


/* =========================
TABLET
========================= */

@media (max-width: 768px) {

header {
  height: 70px;
  padding: 0 30px;
}

header .logo h1 {
  font-size: 2rem;
}

nav ul {
  gap: 20px;
}

.catalog-btn {
  padding: 8px 16px;
  font-size: 0.9rem;
}

.bienvenido {
  font-size: 1rem;
}

.user-avatar {
  width: 42px;
  height: 42px;
  line-height: 42px;
  font-size: 1.1rem;
}

}


/* =========================
MÓVIL
========================= */

@media (max-width: 480px) {

header {
  height: 65px;
  padding: 0 18px;
}

header .logo h1 {
  font-size: 1.6rem;
  letter-spacing: 1px;
}

nav ul {
  gap: 12px;
}

/* ocultamos texto largo */

.catalog-btn {
  padding: 6px 10px;
  font-size: 0.8rem;
}

.bienvenido {
  font-size: 0.9rem;
}

.user-avatar {
  width: 34px;
  height: 34px;
  line-height: 34px;
  font-size: 0.95rem;
  margin-right: 0;
}

}

</style>
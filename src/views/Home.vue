<template>
  <section class="hero">
    <div class="overlay"></div>

    <div class="hero-content">
      <router-link 
        v-if="!userStore.isLoggedIn"
        to="/login" 
        class="btn-login">
        Login
      </router-link>
      <h1>
        <span class="highlight">Reglado</span> Real State
      </h1>
      <p class="description">
        Encuentra el inmueble que se adapta a tus necesidades.
        Registra tu búsqueda, explora nuestras opciones y recibe alertas
        cuando lleguen nuevas oportunidades.
      </p>

      <p class="subtext">
        La forma más fácil de comprar o vender
      </p>
      
    </div>
  </section>
    <div id="about-us" class="somos">
      <AboutUs/>
    </div>
</template>

<script>
import AboutUs from "../views/AboutUs.vue";
import { useUserStore } from "../stores/user";
export default {
  name: "Home",
  components: {
    AboutUs
  },
  setup() {
    const userStore = useUserStore();
    return { userStore };
  }
};
</script>

<style scoped>
.hero {
  position: relative;
  min-height:100vh;
  background-image: url('/src/assets/img_Home.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center; /* 👈 centramos horizontalmente */
  padding-left: 20px; /* 👈 espacio a la izquierda */;
  padding-right: 33%; /* 👈 espacio a la derecha */
}
.somos{
  min-height:100vh;
  background-image: url('/src/assets/img_Home2.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  align-items: center;
  justify-content: center;
  gap: 80px;
}

/* Overlay oscuro para que el texto se lea bien */
.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.075);
}

/* Contenido encima del overlay */
.hero-content {
  position: relative;
  z-index: 2;
  width: 90%;
  max-width: 100%;
  text-align: start;
  color: white;

  display: flex;
  flex-direction: column;
  align-items: end; /* 👈 centra el botón */
}

.hero-content h1,
.hero-content p {
  align-self: flex-start;
}

.hero h1 {
  font-size: 7rem;
  text-shadow: 0 2px 3px rgba(0, 0, 0, 0.605);
  margin-bottom: 20px;
}

.highlight {
  color: #eabe2f;
}

.description {
  font-size: 2.75rem;
  text-shadow: 0 2px 3px rgba(0, 0, 0, 0.605);
  line-height: 1.6;
  margin-bottom: 20px;
}

.subtext {
  font-size: 1.5rem;
  text-shadow: 0 2px 3px rgba(0, 0, 0, 0.605);
  opacity: 0.85;
}

.btn-login{
  margin-top: 90px;
  margin-right: 14%;
  font-size: 2.3rem;
  background-color: var(--azul-principal);
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.443);
  text-shadow: 0 2px 3px rgba(0, 200, 255, 0.274);
  color: white;
  padding: 13px 35px;
  border: none;
  border-radius: 6px;
  transition: 0.3s ease;
  text-decoration: none;
}

.btn-login:hover{
  background-color: var(--azul-secundario);
  color: white;
}
</style>
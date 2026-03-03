<template>
  <div id="app">
    <Header />
    <main class="main-content">
      <router-view />
    </main>
    <Footer />
  </div>
</template>

<script>
import { onMounted } from "vue";
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import { useUserStore } from "./stores/user";

export default {
  components: {
    Header,
    Footer
  },

  setup() {
    const userStore = useUserStore();

    onMounted(async () => {
      try {
        const res = await fetch(
          "http://localhost/inmobiliaria/backend/check_session.php",
          { credentials: "include" }
        );

        const data = await res.json();

        console.log("SESSION DATA:", data);

        if (data.loggedIn && data.user) {
          userStore.setUser(data.user);
        } else {
          userStore.logout();
        }

      } catch (err) {
        console.error("Error cargando sesión:", err);
      }
    });
  }
};
</script>

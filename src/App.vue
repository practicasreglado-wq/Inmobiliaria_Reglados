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
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

export default {
  components: {
    Header,
    Footer
  },


  mounted() {
    fetch("http://localhost/inmobiliaria/backend/check_session.php", {
      credentials: "include"
    })
    .then(res => res.json())
    .then(data => {
      if (data.loggedIn) {
        localStorage.setItem("user", JSON.stringify(data.user));
      } else {
        localStorage.removeItem("user");
      }
    });
  }
}
</script>
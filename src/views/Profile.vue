<template>
  <section class="profile">
    <!-- Menú lateral -->
    <div class="sidebar">
      <h3>Menú de perfil</h3>
      <ul>
        <li><router-link to="/profile/properties-for-sale">Inicio</router-link></li>
        <li><router-link to="/profile/favorite-properties">Mis propiedades favoritas</router-link></li>
        <li><router-link to="/profile/messages">Mensajes</router-link></li>
        <li><router-link to="/profile/my-properties-for-sale">Mis propiedades en venta</router-link></li>
        <li><router-link to="/profile/settings">Ajustes</router-link></li>
        <li v-if="user" class="logout-item">
          <button class="logout-btn" @click="logout">
            Cerrar sesión
          </button>
        </li>
      </ul>
    </div>

  <!-- CONTENIDO -->
  <div class="profile-content">

    <div v-if="user">

      <h2>Bienvenido/a: {{ user.nombre_usuario }}</h2>

      <p>
        <strong>Categoría seleccionada:</strong> {{ category }}
      </p>


      <!-- PREFERENCIAS -->
      <div v-if="preferences && hasPreferences">

        <h3>Preferencias</h3>

        <template v-for="(group, key) in preferences" :key="key">

          <div
            v-if="Array.isArray(group) && group.length"
            class="pref-group"
          >

            <h4>{{ formatLabel(key) }}</h4>

            <ul>
              <li
                v-for="(item, index) in group"
                :key="index"
              >
                {{ item }}
              </li>
            </ul>

          </div>

        </template>

      </div>

      <div v-else>
        <p>No tienes preferencias guardadas.</p>
      </div>

    </div>


    <!-- VISTAS HIJAS -->
    <router-view></router-view>

  </div>

</section>
</template>
<script>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { computed, onMounted } from "vue";
import { useRouter } from "vue-router";

export default {

  setup() {
    const userStore = useUserStore();
    const router = useRouter();
    const { user, selectedCategory: category, preferences } = storeToRefs(userStore);

    // Sincronizar selectedCategory con localStorage al montar el componente
    onMounted(() => {
      const savedCategory = localStorage.getItem('selectedCategory');
      console.log('Saved Category from LocalStorage:', savedCategory); // Verifica si se recupera correctamente

      if (savedCategory && userStore.selectedCategory !== savedCategory) {
        // Si no está sincronizado, actualizar el store con la categoría de localStorage
        userStore.setCategory(savedCategory);
      }
    });

    // Verificar si hay preferencias
    const logout = async () => {
      await fetch("http://localhost/inmobiliaria/backend/logout.php", {
        credentials: "include"
      });

      userStore.logout();
      router.push("/");
    };

    const hasPreferences = computed(() => {
      if (!preferences.value) return false;
      return Object.values(preferences.value).some(
        arr => Array.isArray(arr) && arr.length
      )

    })


    const formatLabel = (key)=>{

      const labels={
        estrellas:"Estrellas",
        servicios:"Servicios",
        ubicacion:"Ubicación",
        tipo:"Tipo",
        caracteristicas:"Características",
        zona:"Zona",
        uso:"Uso"
      }

      return labels[key] || key
    }


    return{
      user,
      category,
      preferences,
      hasPreferences,
      formatLabel,
      logout
    };
  }

}

</script>
<style scoped>

.profile{
display:flex;
min-height:calc(100vh - 90px);
margin-top:90px;
}

.sidebar {
  width: 350px;
  background: linear-gradient(to bottom, #101d41, #2c4692);
  padding: 20px;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
}

.sidebar h3{
font-size:2.3rem;
color:goldenrod;
margin-bottom:20px;
}

.sidebar ul{
list-style:none;
padding:0;
}

.sidebar li{
margin:10px 0;
}

.sidebar a{
display:block;
padding:10px;
color:white;
text-decoration:none;
font-size:1.4rem;
border-radius:6px;
}

.sidebar a:hover{
background:#f0c14b;
}

/* Estilo para el enlace activo */
.sidebar ul li a.router-link-exact-active{
  background-color: #d6ab3e;
  font-weight: 700; 
}

/* Perfil: contenido principal */
.profile-content {
  flex-grow: 1;
  padding: 30px 90px;
  background-color: var(--gris-claro);
  border-radius: 8px;
  margin-left: 1px; /* Ajuste para que el contenido se acomode al lado del menú lateral */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-content h2 {
  font-size: 3.5rem;
}
.profile-content h3 {
  font-size: 2rem;
  background: linear-gradient(135deg, #101d41, #2c4692);
  color: white;
  padding: 8px 18px;
  border-radius: 12px;
  font-weight: 600;
  display: inline-block;
}

.profile-content p {
  background: linear-gradient(135deg, #846604, #e1bc35);
  color: white;
  padding: 8px 18px;
  border-radius: 12px;
  font-size: 2.75rem;
  display: inline-block;
  margin: 0;
}

.pref-group {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 15px;
}

/* título en cuadro */
.pref-group h4 {
  margin: 0;
  padding: 6px 14px;
  border: 1px solid #ddd;
  border-radius: 10px;
  color: white;
  background: linear-gradient(135deg, #172a5d, #3654ae);
  font-size: 1.3rem;
}

/* lista horizontal */
.pref-group ul {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  list-style: none;
  padding: 0;
  margin: 0;
}

/* cuadritos de cada preferencia */
.pref-group li {
  border: 1px solid #ddd;
  border-radius: 20px;
  padding: 6px 14px;
  background: linear-gradient(135deg, #d2b454d4, #e1bc35);
  font-size: 1.1rem;
  font-weight: 550;
}

/* ===== CERRAR SESIÓN ===== */
.logout-item {
  margin-top: 40px;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.15);
}

.logout-btn {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 10px;
  background: transparent;
  border: 1.5px solid rgba(255, 255, 255, 0.2);
  border-radius: 5px;
  color: #ffffff;
  font-size: 1.5rem;
  font-family: inherit;  /* ← añade esto */
  font-weight: normal;
  cursor: pointer;
  transition: all 0.3s ease;
}

.logout-btn:hover {
  background-color: rgba(239, 68, 68, 0.37);
  border-color: #ef4444;
  color: #f88080;
}
</style>
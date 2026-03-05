<template>
<section class="profile">

  <!-- SIDEBAR -->
  <div class="sidebar">

    <h3>Menú de perfil</h3>

    <ul>
      <li>
        <router-link to="/profile/properties-for-sale">Inicio</router-link>
      </li>

      <li>
        <router-link to="/profile/favorite-properties">
          Mis propiedades favoritas
        </router-link>
      </li>

      <li>
        <router-link to="/profile/messages">
          Mensajes
        </router-link>
      </li>

      <li>
        <router-link to="/profile/my-properties-for-sale">
          Mis propiedades en venta
        </router-link>
      </li>

      <li>
        <router-link to="/profile/settings">
          Ajustes
        </router-link>
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

import { useUserStore } from "../stores/user"
import { storeToRefs } from "pinia"
import { computed } from "vue"

export default {

  name:"Profile",

  setup(){

    const userStore = useUserStore()

    const {
      user,
      selectedCategory:category,
      preferences
    } = storeToRefs(userStore)


    const hasPreferences = computed(()=>{

      if(!preferences.value) return false

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
      formatLabel
    }

  }

}

</script>

<style scoped>

.profile{
display:flex;
min-height:calc(100vh - 90px);
margin-top:90px;
}

.sidebar{
width:350px;
background:#222f57;
padding:20px;
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

.router-link-exact-active{
background:#f0c14b;
}

.profile-content{
flex:1;
padding:70px;
background:var(--gris-claro);
}

</style>
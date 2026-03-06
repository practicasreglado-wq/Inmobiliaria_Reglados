<template>
  <div class="settings">
    <h2>Ajustes de Usuario</h2>

    <div class="profile-picture">
      <img v-if="user.profile_picture" :src="user.profile_picture" alt="Foto de perfil" />
      <div v-else class="profile-initial">
        {{ userInitials }}
      </div>
      <input type="file" @change="handleFileChange" />
    </div>
    
    <form @submit.prevent="updateProfile">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" v-model="user.nombre" id="nombre" required />
      </div>

      <div class="form-group">
        <label for="apellidos">Apellidos</label>
        <input type="text" v-model="user.apellidos" id="apellidos" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" v-model="user.email" id="email" required />
      </div>

      <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="text" v-model="user.telefono" id="telefono" required />
      </div>

      <div class="form-group">
        <label for="nombre_usuario">Nombre de Usuario</label>
        <input type="text" v-model="user.nombre_usuario" id="nombre_usuario" required />
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" v-model="user.password" id="password" required />
      </div>

      <button type="submit">Guardar cambios</button>
    </form>
  </div>
</template>

<script>
import { useUserStore } from "../stores/user";
import { onMounted, computed } from "vue";
import { storeToRefs } from "pinia";

export default {
  name: "Settings",
  setup() {
    const userStore = useUserStore();
    const { user } = storeToRefs(userStore);  // Sincronizamos los datos del store con las referencias
    const userInitials = computed(() => {
  if (!user.value) return "U";

  const nombre = user.value.nombre
    ? user.value.nombre.charAt(0).toUpperCase()
    : "";

  return nombre || "U";
});
    // Cargar datos del usuario cuando el componente se monta
    onMounted(async () => {
  await loadUserData();
});

    // Función para cargar los datos del usuario desde el backend
    const loadUserData = async () => {
      try {
        const response = await fetch("http://localhost/inmobiliaria/backend/get_user_data.php", {
          method: "GET",
          credentials: "include",
        });
        const data = await response.json();

        if (data.success) {
          // Aseguramos que se actualice el estado del usuario en el store
          userStore.setUser(data.user);
        } else {
          alert("No se pudo cargar los datos del usuario.");
        }
      } catch (err) {
        console.error("Error:", err);
        alert("Error de conexión.");
      }
    };

    // Función para actualizar el perfil
    let selectedFile = null;

const handleFileChange = (event) => {
  selectedFile = event.target.files[0];
};

const updateProfile = async () => {

  const formData = new FormData();

  formData.append("nombre", user.value.nombre);
  formData.append("apellidos", user.value.apellidos);
  formData.append("email", user.value.email);
  formData.append("telefono", user.value.telefono);
  formData.append("nombre_usuario", user.value.nombre_usuario);
  formData.append("password", user.value.password);

  if (selectedFile) {
    formData.append("profile_picture", selectedFile);
  }

  const response = await fetch(
    "http://localhost/inmobiliaria/backend/update_profile.php",
    {
      method: "POST",
      body: formData,
      credentials: "include",
    }
  );

  const data = await response.json();
  console.log(data);

  if (data.success) { 
    alert("Perfil actualizado correctamente."); } else { alert("Hubo un problema al actualizar el perfil."); }
  };
    return {
  user,
  handleFileChange,
  updateProfile,
  userInitials
  };
  },
};
</script>

<style scoped>
.settings {
  max-width: 600px;
  margin: 0 auto;
}

.profile-picture {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.profile-picture img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
}

.profile-initial {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #ccc;
  font-size: 2rem;
  color: white;
  margin-bottom: 10px;
}

.profile-picture input {
  margin-top: 10px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

button {
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #45a049;
}
</style>
<template>

<div class="settings">

<h2>Ajustes de Usuario</h2>

<div v-if="!user">
Cargando usuario...
</div>

<div v-else>

<div class="profile-picture">

<img
v-if="preview || user.profile_picture"
:src="preview ? preview : 'http://localhost/inmobiliaria/backend/' + user.profile_picture + '?t=' + Date.now()"
alt="Foto de perfil"
/>

<div v-else class="profile-initial">
{{ userInitials }}
</div>

<input type="file" accept="image/*" @change="handleFileChange">

<br>

<button type="button" @click="updateProfile">
Guardar foto
</button>

<br>

<button v-if="user.profile_picture" @click="deletePhoto">
Eliminar foto
</button>

</div>

<form @submit.prevent="updateProfile">

<div class="form-group">
<label>Nombre</label>
<input type="text" v-model="user.nombre" required>
</div>

<div class="form-group">
<label>Apellidos</label>
<input type="text" v-model="user.apellidos" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" v-model="user.email" required>
</div>

<div class="form-group">
<label>Teléfono</label>
<input type="text" v-model="user.telefono" required>
</div>

<div class="form-group">
<label>Nombre de Usuario</label>
<input type="text" v-model="user.nombre_usuario" required>
</div>

<div class="form-group">
<label>Fecha de nacimiento</label>
<input type="date" v-model="user.fecha_nacimiento" readonly>
</div>

<div class="form-group">
<label>Contraseña actual</label>
<input type="password" v-model="currentPassword">
</div>

<div class="form-group">
<label>Nueva contraseña</label>
<input type="password" v-model="newPassword">
</div>

<button type="submit">
Guardar cambios
</button>

</form>

</div>

</div>

</template>

<script>

import { useUserStore } from "../stores/user"
import { onMounted, computed, ref } from "vue"
import { storeToRefs } from "pinia"

export default {

setup(){

const preview = ref(null)
const selectedFile = ref(null)

const currentPassword = ref("")
const newPassword = ref("")

const userStore = useUserStore()
const { user } = storeToRefs(userStore)

const userInitials = computed(()=>{

if(!user.value) return "U"

return user.value.nombre
? user.value.nombre.charAt(0).toUpperCase()
: "U"

})

onMounted(()=>{

loadUserData()

})

const loadUserData = async ()=>{

try{

const response = await fetch(
"http://localhost/inmobiliaria/backend/get_user_data.php",
{
credentials:"include"
})

const data = await response.json()

if(data.success){

userStore.setUser(data.user)

}else{

alert("Error cargando usuario")

}

}catch(error){

console.error(error)

}

}

const handleFileChange = (event)=>{

const file = event.target.files[0]

if(!file) return

selectedFile.value = file
preview.value = URL.createObjectURL(file)

}

const updateProfile = async ()=>{

// ✅ VALIDACIÓN DE CONTRASEÑA
if ((currentPassword.value && !newPassword.value) || (!currentPassword.value && newPassword.value)) {
  alert("Para cambiar la contraseña debes introducir la contraseña actual y la nueva.")
  return
}

try{

const formData = new FormData()

formData.append("nombre",user.value.nombre)
formData.append("apellidos",user.value.apellidos)
formData.append("email",user.value.email)
formData.append("telefono",user.value.telefono)
formData.append("nombre_usuario",user.value.nombre_usuario)

if(currentPassword.value && newPassword.value){

formData.append("current_password",currentPassword.value)
formData.append("new_password",newPassword.value)

}

if(selectedFile.value){

formData.append("profile_picture",selectedFile.value)

}

const response = await fetch(
"http://localhost/inmobiliaria/backend/update_profile.php",
{
method:"POST",
body:formData,
credentials:"include"
})

const data = await response.json()

if(data.success){

alert("Perfil actualizado")

currentPassword.value=""
newPassword.value=""
preview.value=null
selectedFile.value=null

loadUserData()

}else{

alert(data.message)

}

}catch(error){

console.error(error)

}

}

const deletePhoto = async ()=>{

const response = await fetch(
"http://localhost/inmobiliaria/backend/delete_profile_picture.php",
{
method:"POST",
credentials:"include"
})

const data = await response.json()

if(data.success){

preview.value=null
loadUserData()

}

}

return{
user,
preview,
handleFileChange,
updateProfile,
deletePhoto,
userInitials,
currentPassword,
newPassword
}

}

}

</script>

<style scoped>

.settings{
max-width:600px;
margin:auto;
}

.profile-picture{
display:flex;
flex-direction:column;
align-items:center;
margin-bottom:20px;
}

.profile-picture img{
width:150px;
height:150px;
border-radius:50%;
object-fit:cover;
}

.profile-initial{
width:150px;
height:150px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
background:#ccc;
font-size:2rem;
color:white;
}

.form-group{
margin-bottom:15px;
}

.form-group label{
display:block;
font-weight:bold;
}

.form-group input{
width:100%;
padding:10px;
border-radius:5px;
border:1px solid #ccc;
}

button{
padding:10px 20px;
background:#4caf50;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

</style>
<template>
<div class="forgot">

<h2>Recuperar contraseña</h2>

<form @submit.prevent="send">

<input
type="email"
v-model="email"
placeholder="Correo electrónico"
required
/>

<input
type="text"
v-model="username"
placeholder="Nombre de usuario"
required
/>

<button type="submit">
Enviar correo de recuperación
</button>

</form>

<p v-if="message">{{message}}</p>

</div>
</template>

<script>
import {ref} from "vue"

export default{
name: "ForgotPassword",
setup(){

const email=ref("")
const username=ref("")
const message=ref("")

const send = async () => {

try{

const response = await fetch(
"http://localhost/inmobiliaria/backend/forgot_password.php",
{
method:"POST",
headers:{ "Content-Type":"application/json" },

body:JSON.stringify({
email:email.value,
username:username.value
})
}
)

const text = await response.text()

console.log("RESPUESTA BACKEND:", text)

const data = JSON.parse(text)

message.value = data.message

}catch(err){

console.error(err)
message.value="Error conectando con el servidor"

}

}

return{
email,
username,
message,
send
}

}

}
</script>
<style scoped>

.forgot{
  min-height: calc(100vh - 90px);
  margin-top: 90px;

  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

/* caja del formulario */

form{
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 320px;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

input{
  padding: 12px;
  border-radius: 6px;
  border:1px solid #ccc;
}

button{
  padding: 12px;
  border:none;
  border-radius:6px;
  background: var(--azul-principal);
  color:white;
  font-weight:bold;
  cursor:pointer;
}

button:hover{
  background: var(--azul-secundario);
}

h2{
  font-size:2.2rem;
  margin-bottom:20px;
}

</style>
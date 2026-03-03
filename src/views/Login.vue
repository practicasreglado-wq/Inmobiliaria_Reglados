<template>
  <div class="login">
    <div class="vent-login">
      <h2>Bienvenido</h2>

      <form @submit.prevent="login">
        <input
          type="text"
          v-model="identifier"
          placeholder="Email o usuario"
          required
        />

        <input
          type="password"
          v-model="password"
          placeholder="Contraseña"
          required
        />

        <button type="submit" class="login-btn">
          Iniciar Sesión
        </button>

        <button
          type="button"
          class="register-btn"
          @click="$router.push('/register')"
        >
          Registrarme
        </button>
      </form>

      <p v-if="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { useUserStore } from "../stores/user";
import { useRouter } from "vue-router";

export default {
  name: "Login",

  setup() {
    const identifier = ref("");
    const password = ref("");
    const error = ref("");

    const userStore = useUserStore();
    const router = useRouter();

    const login = async () => {
      error.value = "";

      try {
        const response = await fetch(
          "http://localhost/inmobiliaria/backend/login.php",
          {
            method: "POST",
            credentials: "include",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              identifier: identifier.value,
              password: password.value
            })
          }
        );

        if (!response.ok) {
          error.value = "Error servidor";
          return;
        }

        const data = await response.json();
        console.log("Respuesta backend:", data);

        if (data.success) {
          userStore.setUser(data.user);

          if (data.user.categoria) {
            userStore.setCategory(data.user.categoria);
          }

          if (data.user.preferencias) {
            userStore.setPreferences(data.user.preferencias);
          }

          router.push("/dashboard");
        } else {
          error.value = data.message;
        }

      } catch (err) {
        console.error("Error real:", err);
        error.value = "Error de conexión con el servidor";
      }
    };

    return {
      identifier,
      password,
      error,
      login
    };
  }
};
</script>
<style scoped>
.login {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: var(--gris-claro);
}

.login h2 {
  font-size: 3rem;
  text-align: center;
  margin-bottom: 0;
}

.vent-login {
  background-color: white;
  padding: 0 40px 25px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
/* Tarjeta opcional más elegante */
form {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 340px;
  padding: 30px;
}

input {
  padding: 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

input:focus {
  outline: none;
  border-color: var(--azul-principal);
}

/* Botón principal */
.login-btn {
  padding: 12px;
  border-radius: 6px;
  border: none;
  background-color: var(--azul-principal);
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s ease;
}

.login-btn:hover {
  background-color: var(--azul-secundario);
}

/* Botón secundario (Registrarme) */
.register-btn {
  padding: 12px;
  border-radius: 6px;
  border: none;
  background-color: var(--azul-principal);
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s ease;
}

.register-btn:hover {
  background-color: var(--azul-secundario);
}
</style>
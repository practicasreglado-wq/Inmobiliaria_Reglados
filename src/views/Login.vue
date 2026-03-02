<template>
  <div class="login">
    <div class="vent-login">
      <h2>Bienvenido</h2><form @submit.prevent="login">
      <input type="text" v-model="identifier" placeholder="Email o usuario" required />
      <input type="password" v-model="password" placeholder="Contraseña" required />
      <button type="submit" class="login-btn">
        Iniciar Sesión
      </button>
      <button class="register-btn" @click="$router.push('/register')">
        Registrarme
      </button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",

  data() {
    return {
      identifier: "",
      password: "",
      error: ""
    };
  },

  methods: {
    async login() {
      this.error = "";

      try {
        const response = await fetch("http://localhost/inmobiliaria/backend/login.php", {
        method: "POST",
        credentials: "include",   // 🔥 IMPORTANTE
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          identifier: this.identifier,
          password: this.password
        })
      });

        if (!response.ok) {
          throw new Error("Error servidor");
        }

        const data = await response.json();

        if (data.success) {
          localStorage.setItem("user", JSON.stringify(data.user));
          this.$router.push("/dashboard");
        } else {
          this.error = data.message;
        }

      } catch (err) {
        console.error(err);
        this.error = "No se pudo conectar con el servidor";
      }
    }
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
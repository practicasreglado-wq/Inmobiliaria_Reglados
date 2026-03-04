<template>
  <div class="questions-layout">

    <!-- IZQUIERDA (Visual) -->
    <div class="left-side">
      <div class="overlay"></div>

      <div class="left-content">
        <div class="logo">RS</div>
        <span class="label">Deja tu búsqueda a nosotros</span>
        <h1>Cuéntanos qué<br>es lo que buscas...</h1>
      </div>
    </div>

    <!-- DERECHA (Tu formulario real) -->
    <div class="right-side">
      <form @submit.prevent="submit">

        <h2 class="form-title">
          Tus Preferencias para {{ category }}
        </h2>

        <!-- 🔵 HOTELES -->
        <div v-if="category === 'Hoteles'" class="section">
          <h3>Estrellas</h3>
          <div class="options">
            <label v-for="star in ['3 estrellas','4 estrellas','5 estrellas']" :key="star">
              <input type="checkbox" :value="star" v-model="form.estrellas" />
              {{ star }}
            </label>
          </div>

          <h3>Servicios</h3>
          <div class="options">
            <label v-for="serv in ['Spa','Piscina','Gimnasio','Parking privado','Restaurante','Room Service','Vista al mar']" :key="serv">
              <input type="checkbox" :value="serv" v-model="form.servicios" />
              {{ serv }}
            </label>
          </div>

          <h3>Ubicación</h3>
          <div class="options">
            <label v-for="loc in ['Centro ciudad','Playa','Montaña','Zona rural']" :key="loc">
              <input type="checkbox" :value="loc" v-model="form.ubicacion" />
              {{ loc }}
            </label>
          </div>
        </div>

        <!-- 🔵 PARKING -->
        <div v-if="category === 'Parking'" class="section">
          <h3>Tipo</h3>
          <div class="options">
            <label v-for="tipo in ['Subterráneo','Exterior','Privado','Público']" :key="tipo">
              <input type="checkbox" :value="tipo" v-model="form.tipo" />
              {{ tipo }}
            </label>
          </div>

          <h3>Características</h3>
          <div class="options">
            <label v-for="car in ['Vigilancia 24h','Acceso automático','Cámaras de seguridad','Carga eléctrica']" :key="car">
              <input type="checkbox" :value="car" v-model="form.caracteristicas" />
              {{ car }}
            </label>
          </div>

          <h3>Ubicación</h3>
          <div class="options">
            <label v-for="zona in ['Centro','Residencial','Comercial']" :key="zona">
              <input type="checkbox" :value="zona" v-model="form.zona" />
              {{ zona }}
            </label>
          </div>
        </div>

        <!-- 🔵 EDIFICIOS -->
        <div v-if="category === 'Edificios'" class="section">
          <h3>Uso</h3>
          <div class="options">
            <label v-for="uso in ['Residencial','Oficinas','Comercial','Industrial']" :key="uso">
              <input type="checkbox" :value="uso" v-model="form.uso" />
              {{ uso }}
            </label>
          </div>

          <h3>Características</h3>
          <div class="options">
            <label v-for="car in ['Ascensor','Garaje','Terraza','Reformado','Nuevo']" :key="car">
              <input type="checkbox" :value="car" v-model="form.caracteristicas" />
              {{ car }}
            </label>
          </div>

          <h3>Zona</h3>
          <div class="options">
            <label v-for="zona in ['Centro','Periferia','Zona financiera']" :key="zona">
              <input type="checkbox" :value="zona" v-model="form.zona" />
              {{ zona }}
            </label>
          </div>
        </div>

        <button type="submit" class="submit-btn">
          Guardar preferencias
        </button>

      </form>
    </div>

  </div>
</template>
<script>
import { useUserStore } from "../stores/user";
import { useRouter } from "vue-router";
import { ref, onMounted } from "vue";

export default {
  name: "Questions",

  setup() {
    const userStore = useUserStore();
    const router = useRouter();

    // Cargar categoría desde localStorage o userStore
    const category = ref(userStore.selectedCategory || localStorage.getItem('selectedCategory') || 'Hoteles');  

    // Inicializamos el formulario vacío
    const form = ref({
      estrellas: [],
      servicios: [],
      ubicacion: [],
      tipo: [],
      caracteristicas: [],
      zona: [],
      uso: []
    });

    // Guardar categoría y preferencias en localStorage al montar
    onMounted(() => {
      localStorage.setItem('selectedCategory', category.value);
      localStorage.removeItem('preferences');  // Limpiar preferencias previas
    });

    const submit = async () => {
      try {
        const response = await fetch(
          "http://localhost/inmobiliaria/backend/save_preferences.php",
          {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              categoria: category.value,  // Usar category.value
              preferencias: form.value
            })
          }
        );

        const data = await response.json();

        if (data.success) {
          // Guardar las preferencias en localStorage (sin acumular preferencias previas)
          localStorage.setItem('preferences', JSON.stringify(form.value));

          // Actualizar el store
          userStore.setPreferences({ ...form.value });

          // Redirigir al perfil
          router.push("/profile");
        }
      } catch (err) {
        console.error("Error conexión:", err);
      }
    };

    return { category, form, submit };
  }
};
</script>
<style scoped>
.questions-layout {
  display: flex;
  min-height: calc(100vh - 90px);
  margin-top: 90px;
  background-image: url('@/assets/fondito.png');
  background-size: cover;
  background-position: center;
}

/* IZQUIERDA */
.left-side {
  flex: 1;
  position: relative;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  padding: 80px;
  color: white;
}

.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.498);
}

.left-content {
  position: relative;
  z-index: 1;
}

.logo {
  font-size: 3rem;
  font-weight: 600;
}

.label {
  color: #d4af37;
  font-size: 2.5rem;
}

.left-content h1 {
  font-size: 4rem;
  font-weight: 300;
  margin: 20px 0;
  line-height: 1.2;
}

.contact-info {
  margin-top: 40px;
  font-size: 1rem;
  opacity: 0.9;
}

/* DERECHA */
.right-side {
  width: 60%;
  background: #75727250;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 60px;
}

form {
   background: rgba(255, 255, 255, 0.95);
  padding: 50px;
  border-radius: 30px;
  width: 100%;
  max-width: 650px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.35);
  max-height: 85vh;
  overflow-y: auto;
}

.form-title {
  margin-bottom: 25px;
}

.section {
  margin-bottom: 25px;
}

.options {
  display: flex;
  flex-wrap: wrap;
  gap: 12px 25px;
}

label {
  display: flex;
  gap: 8px;
  align-items: center;
  font-size: 0.95rem;
}

.submit-btn {
  margin-top: 30px;
  width: 60%;
  align-self: center;
  padding: 15px;
  border-radius: 30px;
  border: none;
  background-color: #24386b;
  color: white;
  font-size: 1.1rem;
  cursor: pointer;
  transition: 0.3s;
}

.submit-btn:hover {
  background-color: var(--azul-secundario);
}
</style>
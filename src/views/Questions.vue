<template>
  <div class="questions">
    <h2>Preferencias para {{ category }}</h2>

    <form @submit.prevent="submit">

      <!-- 🔵 HOTELES -->
      <div v-if="category === 'Hoteles'">
        <h3>Estrellas</h3>
        <label v-for="star in ['3 estrellas', '4 estrellas', '5 estrellas']" :key="star">
          <input type="checkbox" :value="star" v-model="form.estrellas" />
          {{ star }}
        </label>

        <h3>Servicios</h3>
        <label v-for="serv in ['Spa', 'Piscina', 'Gimnasio', 'Parking privado', 'Restaurante', 'Room Service', 'Vista al mar']" :key="serv">
          <input type="checkbox" :value="serv" v-model="form.servicios" />
          {{ serv }}
        </label>

        <h3>Ubicación</h3>
        <label v-for="loc in ['Centro ciudad', 'Playa', 'Montaña', 'Zona rural']" :key="loc">
          <input type="checkbox" :value="loc" v-model="form.ubicacion" />
          {{ loc }}
        </label>
      </div>

      <!-- 🔵 PARKING -->
      <div v-if="category === 'Parking'">
        <h3>Tipo</h3>
        <label v-for="tipo in ['Subterráneo', 'Exterior', 'Privado', 'Público']" :key="tipo">
          <input type="checkbox" :value="tipo" v-model="form.tipo" />
          {{ tipo }}
        </label>

        <h3>Características</h3>
        <label v-for="car in ['Vigilancia 24h', 'Acceso automático', 'Cámaras de seguridad', 'Carga eléctrica']" :key="car">
          <input type="checkbox" :value="car" v-model="form.caracteristicas" />
          {{ car }}
        </label>

        <h3>Ubicación</h3>
        <label v-for="zona in ['Centro', 'Residencial', 'Comercial']" :key="zona">
          <input type="checkbox" :value="zona" v-model="form.zona" />
          {{ zona }}
        </label>
      </div>

      <!-- 🔵 EDIFICIOS -->
      <div v-if="category === 'Edificios'">
        <h3>Uso</h3>
        <label v-for="uso in ['Residencial', 'Oficinas', 'Comercial', 'Industrial']" :key="uso">
          <input type="checkbox" :value="uso" v-model="form.uso" />
          {{ uso }}
        </label>

        <h3>Características</h3>
        <label v-for="car in ['Ascensor', 'Garaje', 'Terraza', 'Reformado', 'Nuevo']" :key="car">
          <input type="checkbox" :value="car" v-model="form.caracteristicas" />
          {{ car }}
        </label>

        <h3>Zona</h3>
        <label v-for="zona in ['Centro', 'Periferia', 'Zona financiera']" :key="zona">
          <input type="checkbox" :value="zona" v-model="form.zona" />
          {{ zona }}
        </label>
      </div>

      <button type="submit">Guardar preferencias</button>

    </form>
  </div>
</template>

<script>
import { useUserStore } from "../stores/user";
import { useRouter } from "vue-router";
import { ref } from "vue";

export default {
  name: "Questions",

  setup() {
    const userStore = useUserStore();
    const router = useRouter();

    const category = userStore.selectedCategory;

    const form = ref({
      estrellas: [],
      servicios: [],
      ubicacion: [],
      tipo: [],
      caracteristicas: [],
      zona: [],
      uso: []
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
                categoria: category,
                preferencias: form.value
                })
            }
            );

            const data = await response.json();

            if (data.success) {

            // 🔥 IMPORTANTE: actualizar store DESPUÉS de guardar
            userStore.setPreferences({ ...form.value });

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
.questions {
  min-height: 100vh;
  padding-top: 120px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

form {
  display: flex;
  flex-direction: column;
  gap: 10px;
  width: 450px;
  margin-top: 30px;
}

h3 {
  margin-top: 20px;
}

label {
  display: flex;
  gap: 8px;
  align-items: center;
}

button {
  margin-top: 25px;
  padding: 12px;
  border-radius: 6px;
  border: none;
  background-color: var(--azul-principal);
  color: white;
  cursor: pointer;
}
</style>
<template>
  <div class="aportar-container">
    <div class="form-header">
      <h1>Publicar Nuevo Activo</h1>
      <p>Complete los datos técnicos para ejecutar el motor de matching con nuestra base de inversores.</p>
    </div>

    <form @submit.prevent="handleSubmit" class="activo-form">
      
      <div class="form-section">
        <h3><span class="step">1</span> Información General</h3>
        <div class="grid-row">
          <div class="form-group">
            <label>Categoría de Activo</label>
            <select v-model="form.tipo_activo" required>
              <option value="" disabled>Seleccione una categoría</option>
              <option value="Edificios">Edificio</option>
              <option value="Hoteles">Hotel</option>
              <option value="Parking">Parking</option>
              <option value="Activos Singulares">Activo Singular</option>
              <option value="Fincas">Finca</option>
            </select>
          </div>
          <div class="form-group">
            <label>Tipo de Operación</label>
            <select v-model="form.operacion" required>
              <option value="Venta">Venta</option>
              <option value="Inversión">Inversión / Rentabilidad</option>
              <option value="Concesión">Concesión</option>
              <option value="Alquiler">Alquiler</option>
            </select>
          </div>
        </div>

        <div class="grid-row">
          <div class="form-group">
            <label>Precio (€)</label>
            <input type="number" v-model="form.precio" placeholder="Ej: 2500000" required />
          </div>
          <div class="form-group">
            <label>Superficie Total (m²)</label>
            <input type="number" v-model="form.superficie" placeholder="Ej: 1200" required />
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3><span class="step">2</span> Ubicación y Privacidad</h3>
        <div class="form-group">
          <label>Ubicación / Zona</label>
          <input type="text" v-model="form.ubicacion" placeholder="Ej: Madrid, Barrio de Salamanca" required />
        </div>
        
        <div class="confidential-card">
          <div class="checkbox-wrapper">
            <input type="checkbox" id="confidential" v-model="form.es_confidencial" />
            <label for="confidential">
              <strong>Marcar como Activo OFF-MARKET (Confidencial)</strong>
              <span>La dirección exacta y fotos sensibles solo se mostrarán tras firma de NDA.</span>
            </label>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3><span class="step">3</span> Detalles Técnicos</h3>
        <div class="form-group">
          <label>Descripción corta para inversores</label>
          <textarea v-model="form.descripcion" rows="4" placeholder="Resumen de la oportunidad..."></textarea>
        </div>
        </div>

      <div class="form-actions">
        <button type="submit" :disabled="loading" class="submit-btn">
          {{ loading ? 'Procesando...' : 'Publicar Activo y Buscar Matches' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from "@/stores/user";
import { useRouter } from "vue-router";

const userStore = useUserStore();
const router = useRouter();
const loading = ref(false);

const form = ref({
  tipo_activo: "",
  operacion: "Venta",
  precio: null,
  superficie: null,
  ubicacion: "",
  es_confidencial: false,
  descripcion: "",
  id_aportador: userStore.user?.id // Asociamos el activo al usuario logueado
});

const handleSubmit = async () => {
  loading.value = true;
  try {
    const response = await fetch("http://localhost/inmobiliaria/backend/save_activo.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(form.value)
    });

    const data = await response.json();

    if (data.success) {
      alert("Activo publicado correctamente. Iniciando motor de matching...");
      router.push('/dashboard');
    } else {
      alert("Error: " + data.message);
    }
  } catch (error) {
    console.error("Error al guardar:", error);
    alert("Error de conexión con el servidor");
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.aportar-container {
  max-width: 800px;
  margin: 60px auto;
  padding: 20px;
  font-family: 'Inter', sans-serif;
}

.form-header {
  text-align: center;
  margin-bottom: 40px;
}

.form-header h1 {
  font-size: 2.5rem;
  font-weight: 300;
  color: #24386b;
}

.activo-form {
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 15px 50px rgba(0,0,0,0.1);
}

.form-section {
  margin-bottom: 40px;
}

.form-section h3 {
  display: flex;
  align-items: center;
  gap: 15px;
  font-size: 1.2rem;
  color: #333;
  margin-bottom: 25px;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}

.step {
  background: #d4af37;
  color: white;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 0.9rem;
}

.grid-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: 600;
  margin-bottom: 8px;
  font-size: 0.9rem;
}

input, select, textarea {
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 1rem;
}

.confidential-card {
  background: #fff9e6;
  padding: 20px;
  border-radius: 12px;
  border: 1px solid #ffe699;
}

.checkbox-wrapper {
  display: flex;
  gap: 15px;
  align-items: flex-start;
}

.checkbox-wrapper label {
  display: flex;
  flex-direction: column;
}

.checkbox-wrapper span {
  font-size: 0.85rem;
  color: #666;
}

.submit-btn {
  width: 100%;
  padding: 18px;
  background: #24386b;
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s;
}

.submit-btn:hover {
  background: #1a2a50;
}

.submit-btn:disabled {
  background: #ccc;
}
</style>
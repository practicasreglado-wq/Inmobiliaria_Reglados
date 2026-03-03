<template>
  <div class="carousel">

    <!-- Títulos dinámicos -->
    <div class="categories">
      <span
        v-for="(item, index) in items"
        :key="index"
        :class="{ active: index === 1 }"
      >
        {{ item.title }}
      </span>
    </div>

    <div class="carousel-wrapper">

      <button class="arrow" @click="prev">❮</button>

      <transition-group name="slide" tag="div" class="cards">
        <div
          v-for="(item, index) in items"
          :key="item.title"
          class="card"
          :class="{ center: index === 1 && !isAnimating }"
          :style="{ backgroundImage: `url(${item.image})` }"
          @click="selectCategory(index)"
        ></div>
</transition-group>

      <button class="arrow" @click="next">❯</button>

    </div>

  </div>
</template>

<script>
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/user";
import { onMounted } from "vue";

export default {
  name: "Carousel",

  setup() {
    const router = useRouter();
    const userStore = useUserStore();

    return { router, userStore };
  },

  data() {
    return {
      isAnimating: false,
      items: [
        { title: "Edificios", image: new URL('@/assets/img_Home.png', import.meta.url).href },
        { title: "Hoteles", image: new URL('@/assets/hotel.png', import.meta.url).href },
        { title: "Parking", image: new URL('@/assets/parking.png', import.meta.url).href }
      ]
    };
  },

  mounted() {
    // 🔥 Auto posicionar según categoría guardada
    const savedCategory = this.userStore.selectedCategory;

    if (!savedCategory) return;

    const index = this.items.findIndex(
      item => item.title === savedCategory
    );

    if (index === -1) return;

    // mover esa categoría al centro (posición 1)
    while (this.items[1].title !== savedCategory) {
      const first = this.items.shift();
      this.items.push(first);
    }
  },

  methods: {
    next() {
      if (this.isAnimating) return;
      this.isAnimating = true;

      setTimeout(() => {
        const first = this.items.shift();
        this.items.push(first);
      }, 200);

      setTimeout(() => {
        this.isAnimating = false;
      }, 400);
    },

    prev() {
      if (this.isAnimating) return;
      this.isAnimating = true;

      setTimeout(() => {
        const last = this.items.pop();
        this.items.unshift(last);
      }, 200);

      setTimeout(() => {
        this.isAnimating = false;
      }, 400);
    },

    async selectCategory(index) {
      if (index !== 1) return;

      const selected = this.items[1].title;

      // Guardar en Pinia
      this.userStore.setCategory(selected);

      // 🔥 Actualizar base de datos inmediatamente
      await fetch(
        "http://localhost/inmobiliaria/backend/save_preferences.php",
        {
          method: "POST",
          credentials: "include",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            categoria: selected,
            preferencias: this.userStore.preferences
          })
        }
      );

      this.router.push("/questions");
    }
  }
};
</script>
<style scoped>
.carousel {
  text-align: center;
  padding: 60px 0;
}

.categories {
  display: flex;
  justify-content: center;
  gap: 220px; /* más separación */
  margin-bottom: 60px;
  font-size: 2rem; /* más grande */
  font-weight: 500;
}

.categories span {
  cursor: pointer;
  transition: 0.3s ease;
  opacity: 0.75;
}

.categories .active {
  font-weight: 700;
  opacity: 1;
}

/* Wrapper */
.carousel-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 60px; /* más aire */
}

/* Flechas */
.arrow {
  background-color: var(--azul-principal);
  color: white;
  border: none;
  border-radius: 50%;
  width: 60px;   /* más grande */
  height: 60px;  /* más grande */
  font-size: 26px;
  cursor: pointer;
  transition: 0.3s ease;
}

.arrow:hover {
  background-color: var(--azul-secundario);
}

.cards {
  display: flex;
  gap: 60px; /* más separación */
  align-items: flex-end;
}

.card {
  width: 300px;   /* antes 220px */
  height: 400px;  /* antes 300px */
  background-size: cover;
  background-position: center;
  border-radius: 20px; /* más elegante */
  box-shadow: 0 15px 30px rgba(0,0,0,0.15);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  transform: scale(0.95);
  cursor: default;
}

.center {
  transform: scale(1.12) translateY(-20px);
  box-shadow: 0 25px 45px rgba(0,0,0,0.25);
  cursor: pointer;
}

/* Animación de movimiento */
.slide-move {
  transition: transform 0.6s ease, opacity 0.6s ease;
}

/* Cuando entra */
.slide-enter-active {
  transition: all 0.6s ease;
}

/* Cuando sale */
.slide-leave-active {
  transition: all 0.6s ease;
  position: absolute;
}

.slide-enter-from {
  opacity: 0;
  transform: scale(0.8);
}

.slide-leave-to {
  opacity: 0;
  transform: scale(0.8);
}
</style>
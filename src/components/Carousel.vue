<template>
  <div class="carousel">
    <!-- Títulos -->
    <div class="categories">
      <span
        v-for="(item, index) in visibleItems"
        :key="item.value"
        :class="{ active: index === 1 }"
      >
        {{ item.title }}
      </span>
    </div>

    <div class="carousel-wrapper">
      <button class="arrow" @click="prev">❮</button>

      <div class="cards">
        <div
          v-for="(item, index) in visibleItems"
          :key="item.value"
          class="card"
          :class="cardClass(index)"
          :style="{ backgroundImage: `url(${item.image})` }"
          @click="selectCategory(index)"
        ></div>
      </div>

      <button class="arrow" @click="next">❯</button>
    </div>
  </div>
</template>

<script>
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/user";

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
        { title: "Edificios", value: "Edificios", image: new URL('@/assets/edificios.png', import.meta.url).href },
        { title: "Hoteles", value: "Hoteles", image: new URL('@/assets/hotel.png', import.meta.url).href },
        { title: "Parking", value: "Parking", image: new URL('@/assets/parking.png', import.meta.url).href },
        { title: "Activos", value: "Activos", image: new URL('@/assets/activos.png', import.meta.url).href },
        { title: "Fincas", value: "Fincas", image: new URL('@/assets/finca.png', import.meta.url).href }
      ]
    };
  },

  computed: {
    visibleItems() {
      return this.items.slice(0, 3);
    }
  },

  mounted() {
    const savedCategory = this.userStore.selectedCategory;
    if (!savedCategory) return;

    while (this.items[1].value !== savedCategory) {
      const first = this.items.shift();
      this.items.push(first);
    }
  },

  methods: {
    cardClass(index) {
      if (index === 1) return "center";
      if (index === 0) return "left";
      if (index === 2) return "right";
    },

    next() {
      if (this.isAnimating) return;
      this.isAnimating = true;

      const first = this.items.shift();
      this.items.push(first);

      setTimeout(() => {
        this.isAnimating = false;
      }, 400);
    },

    prev() {
      if (this.isAnimating) return;
      this.isAnimating = true;

      const last = this.items.pop();
      this.items.unshift(last);

      setTimeout(() => {
        this.isAnimating = false;
      }, 400);
    },

    // Seleccionar categoría y enviar a questions
    selectCategory(index) {
      if (index !== 1) return;

      const selected = this.visibleItems[1].value;

      this.router.push({
        path: "/questions",
        query: { category: selected }
      });
    }
  }
};
</script>

<style scoped>
/* Estilos para el carrusel */
.carousel {
  text-align: center;
  padding: 80px 0;
}

.categories {
  display: flex;
  justify-content: center;
  gap: 220px;
  margin-bottom: 60px;
  font-size: 2rem;
  font-weight: 500;
}

.categories span {
  opacity: 0.75;
  transition: 0.3s;
}

.categories .active {
  opacity: 1;
  font-weight: 700;
}

.carousel-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 50px;
}

.arrow {
  background-color: var(--azul-principal);
  color: white;
  border: none;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  font-size: 26px;
  cursor: pointer;
}

.arrow:hover {
  background-color: var(--azul-secundario);
}

.cards {
  display: flex;
  align-items: center;
  gap: 40px;
}

.card {
  width: 280px;
  height: 380px;
  background-size: cover;
  background-position: center;
  border-radius: 20px;
  transition: 0.4s ease;
}

.left {
  transform: scale(0.95);
  opacity: 0.6;
}

.center {
  transform: scale(1.15);
  opacity: 1;
  box-shadow: 0 25px 45px rgba(0,0,0,0.25);
  cursor: pointer;
}

.right {
  transform: scale(0.95);
  opacity: 0.6;
}
</style>
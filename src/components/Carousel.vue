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

      <div class="cards">
        <div
          v-for="(item, index) in items"
          :key="index"
          class="card"
          :class="{ center: index === 1 && !isAnimating }"
          :style="{ backgroundImage: `url(${item.image})` }"
        ></div>
      </div>

      <button class="arrow" @click="next">❯</button>

    </div>

  </div>
</template>

<script>
export default {
  name: "Carousel",

  data() {
    return {
      isAnimating: false,
      items: [
        {
          title: "Edificios",
          image: new URL('@/assets/img_Home.png', import.meta.url).href
        },
        {
          title: "Hoteles",
          image: new URL('@/assets/img_Home.png', import.meta.url).href
        },
        {
          title: "Parking",
          image: new URL('@/assets/img_Home.png', import.meta.url).href
        }
      ]
    };
  },

  methods: {
    next() {
      if (this.isAnimating) return;

      this.isAnimating = true;

      // 1️⃣ quitar efecto centro
      setTimeout(() => {
        const first = this.items.shift();
        this.items.push(first);
      }, 200);

      // 2️⃣ permitir que el nuevo centro se agrande
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
    }
  }
};
</script>
<style scoped>
.carousel {
  text-align: center;
}

.categories {
  display: flex;
  justify-content: center;
  gap: 175px;
  margin-bottom: 40px;
  font-size: 1.6rem;
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
  gap: 40px;
}

/* Flechas */
.arrow {
  background-color: var(--azul-principal);
  color: white;
  border: none;
  border-radius: 50%;
  width: 45px;
  height: 45px;
  font-size: 20px;
  cursor: pointer;
  transition: 0.3s ease;
}

.arrow:hover {
  background-color: var(--azul-secundario);
}

.cards {
  display: flex;
  gap: 40px;
  align-items: flex-end;
}

.card {
  width: 220px;
  height: 300px;
  background-size: cover;
  background-position: center;
  border-radius: 15px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  transform: scale(0.95);
}

.center {
  transform: scale(1.08) translateY(-15px);
  box-shadow: 0 20px 35px rgba(0,0,0,0.25);
}
</style>
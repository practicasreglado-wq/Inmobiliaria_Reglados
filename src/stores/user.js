import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
    selectedCategory: null,
    preferences: null
  }),

  getters: {
    isLoggedIn: (state) => !!state.user
  },

  actions: {
    setUser(userData) {
      this.user = userData;

      // 🔥 MUY IMPORTANTE
      this.selectedCategory = userData.categoria || null;
      this.preferences = userData.preferencias || null;

      // Guardar en localStorage
      localStorage.setItem('user', JSON.stringify(userData));
      localStorage.setItem('selectedCategory', this.selectedCategory);
      localStorage.setItem('preferences', JSON.stringify(this.preferences));
    },
    
  },

    setCategory(category) {
      this.selectedCategory = category;
      localStorage.setItem('selectedCategory', category); // Guardar categoría en localStorage
    },

    setPreferences(preferences) {
      this.preferences = preferences;
      localStorage.setItem('preferences', JSON.stringify(preferences)); // Guardar preferencias en localStorage
    },

    logout() {
      this.user = null;
      this.selectedCategory = null;
      this.preferences = null;
      localStorage.removeItem('user');
      localStorage.removeItem('selectedCategory');
      localStorage.removeItem('preferences');
    }
  });

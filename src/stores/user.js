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
    },
    
  },

    setCategory(category) {
      this.selectedCategory = category;
    },

    setPreferences(preferences) {
      this.preferences = preferences;
    },

    logout() {
      this.user = null;
      this.selectedCategory = null;
      this.preferences = null;
    }
  });
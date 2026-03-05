import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
    selectedCategory: null,
    preferences: null
  }),

  actions: {
    setUser(userData) {
      this.user = userData;
      this.selectedCategory = userData.categoria || null;
      this.preferences = userData.preferencias || null;

      localStorage.setItem('user', JSON.stringify(userData));
      localStorage.setItem('selectedCategory', this.selectedCategory);
      localStorage.setItem('preferences', JSON.stringify(this.preferences));
    },

    setCategory(category) {
      this.selectedCategory = category;
      localStorage.setItem('selectedCategory', category);
    },

    setPreferences(preferences) {
      this.preferences = preferences;
      localStorage.setItem('preferences', JSON.stringify(preferences));
    },

    logout() {
      this.user = null;
      this.selectedCategory = null;
      this.preferences = null;
      localStorage.removeItem('user');
      localStorage.removeItem('selectedCategory');
      localStorage.removeItem('preferences');
    }
  },

  persist: true
});
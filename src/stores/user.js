import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
    selectedCategory: null,
    preferences: null
  }),

  actions: {
    setUser(user) {
      this.user = user;
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
  }
});
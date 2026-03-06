import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
  user: JSON.parse(localStorage.getItem("user")) || null,
  selectedCategory: localStorage.getItem("selectedCategory") || null,
  preferences: JSON.parse(localStorage.getItem("preferences")) || null
}),

  getters: {
    isLoggedIn: (state) => !!state.user,
  },

  actions: {
    setUser(userData) {

  this.user = {
    ...userData,
    apellidos: userData.apellidos || ""
  };

  localStorage.setItem("user", JSON.stringify(this.user));

  if (userData.categoria !== undefined) {
    this.selectedCategory = userData.categoria;
    localStorage.setItem("selectedCategory", this.selectedCategory);
  }

  if (userData.preferencias !== undefined) {
    this.preferences = userData.preferencias;
    localStorage.setItem("preferences", JSON.stringify(this.preferences));
  }

  localStorage.setItem("user", JSON.stringify(userData));
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
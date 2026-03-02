import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {

  state: () => ({
    user: null,
    carrito: [],
    mensajes: [],
    favoritos: []
  }),

  actions: {

    setUser(userData) {
      this.user = userData
    },

    logout() {
      this.user = null
      this.carrito = []
      this.mensajes = []
      this.favoritos = []
    },

    addToCarrito(item) {
      this.carrito.push(item)
    },

    addFavorito(propiedad) {
      this.favoritos.push(propiedad)
    }

  }

})
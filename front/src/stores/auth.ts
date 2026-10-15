import { defineStore } from 'pinia'
import api from '../services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as any,
    token: localStorage.getItem('token') as string | null,
    errors: {} as Record<string, string[]>,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,

    isAdmin: (state) => state.user?.profile_id === 1,
    isUser: (state) => state.user?.profile_id === 2,
  },

  actions: {
    async login(email: string, password: string) {
      this.errors = {}
      try {
        const { data } = await api.post('/login', { email, password })
        this.token = data.token
        this.user = data.user
        localStorage.setItem('token', data.token)
      } catch (error: any) {
        if (error.response?.status === 422) {
          this.errors = error.response.data.errors
        }
        throw error
      }
    },

    async fetchUser() {
      if (!this.token) return
      try {
        const { data } = await api.get('/me')
        this.user = data
      } catch {
        this.clear()
      }
    },

    async logout() {
      try {
        await api.post('/logout')
      } catch {
      } finally {
        this.clear()
      }
    },

    clear() {
      this.token = null
      this.user = null
      localStorage.removeItem('token')
    },
  },
})

import { defineStore } from 'pinia'
import api from '../services/api'

const toFormData = (data) => {
  const form = new FormData()
  Object.entries(data).forEach(([key, value]) => {
    if (value !== null && value !== undefined && value !== '') {
      form.append(key, value)
    }
  })
  return form
}

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    user: null,
    loading: false,
    errors: {},
  }),

  actions: {
    async fetchUsers() {
      this.loading = true
      try {
        const { data } = await api.get('/users')
        this.users = data
      } finally {
        this.loading = false
      }
    },

    async fetchUser(id) {
      this.loading = true
      try {
        const { data } = await api.get(`/users/${id}`)
        this.user = data
        return data
      } finally {
        this.loading = false
      }
    },

    async createUser(payload) {
      this.errors = {}
      try {
        const { data } = await api.post('/users', toFormData(payload))
        this.users.push(data)
        return data
      } catch (error) {
        this.handleError(error)
        throw error
      }
    },

    async updateUser(id, payload) {
      this.errors = {}
      try {
        const form = toFormData(payload)
        form.append('_method', 'PUT')
        const { data } = await api.post(`/users/${id}`, form)
        const index = this.users.findIndex((u) => u.id === id)
        if (index !== -1) this.users[index] = data
        this.user = data
        return data
      } catch (error) {
        this.handleError(error)
        throw error
      }
    },

    async deleteUser(id) {
      await api.delete(`/users/${id}`)
      this.users = this.users.filter((u) => u.id !== id)
    },

    handleError(error) {
      if (error.response?.status === 422) {
        this.errors = error.response.data.errors
      }
    },
  },
})

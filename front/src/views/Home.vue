<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const isActive = ref(false)
const auth = useAuthStore()
const router = useRouter()

const logout = async () => {
  await auth.logout()
  isActive.value = false
  router.push('/login')
}
</script>

<template>
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <RouterLink class="navbar-item has-text-weight-bold" to="/">Recomendaciones</RouterLink>

      <a
        role="button"
        class="navbar-burger"
        :class="{ 'is-active': isActive }"
        aria-label="menu"
        aria-expanded="false"
        @click="isActive = !isActive"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div class="navbar-menu" :class="{ 'is-active': isActive }">
      <div class="navbar-start">
        <RouterLink class="navbar-item" to="/">Inicio</RouterLink>
        <RouterLink class="navbar-item" to="/movies">Películas</RouterLink>
        <RouterLink class="navbar-item" to="/videogames">Videojuegos</RouterLink>
        <RouterLink v-if="auth.isAdmin" class="navbar-item" to="/users">Usuarios</RouterLink>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div v-if="!auth.isAuthenticated" class="buttons">
            <RouterLink class="button is-light" to="/login">Iniciar sesión</RouterLink>
            <RouterLink class="button is-link" to="/register">Registrarse</RouterLink>
          </div>

          <div v-else class="buttons">
            <span v-if="auth.user" class="mr-3">{{ auth.user.nickname }}</span>
            <button class="button is-light" @click="logout">Cerrar sesión</button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

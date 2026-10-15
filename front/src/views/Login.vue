<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')
const loading = ref(false)

const submit = async () => {
  loading.value = true
  try {
    await auth.login(email.value, password.value)
    router.push('/')
  } catch {
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="section">
    <div class="columns is-centered">
      <div class="column is-4">
        <h1 class="title has-text-centered">Iniciar sesión</h1>

        <form class="box" @submit.prevent="submit">
          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input
                v-model="email"
                class="input"
                :class="{ 'is-danger': auth.errors.email }"
                type="email"
                placeholder="correo@ejemplo.com"
                required
              />
            </div>
            <p v-if="auth.errors.email" class="help is-danger">
              {{ auth.errors.email[0] }}
            </p>
          </div>

          <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
              <input
                v-model="password"
                class="input"
                :class="{ 'is-danger': auth.errors.password }"
                type="password"
                required
              />
            </div>
            <p v-if="auth.errors.password" class="help is-danger">
              {{ auth.errors.password[0] }}
            </p>
          </div>

          <button
            type="submit"
            class="button is-primary is-fullwidth"
            :class="{ 'is-loading': loading }"
          >
            Entrar
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

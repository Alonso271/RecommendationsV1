<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '../stores/user'
import { useAuthStore } from '../stores/auth'

const userStore = useUserStore()
const auth = useAuthStore()
const router = useRouter()

const form = reactive({
  name: '',
  nickname: '',
  email: '',
  birthdate: '',
  password: '',
  password_confirmation: '',
  photo: null as File | null,
})

const loading = ref(false)

const onFile = (e: Event) => {
  const input = e.target as HTMLInputElement
  form.photo = input.files?.[0] ?? null
}

const submit = async () => {
  loading.value = true
  try {
    await userStore.createUser(form)
    await auth.login(form.email, form.password)
    router.push('/')
  } catch {
    // los errores de validación quedan en userStore.errors
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="section">
    <div class="columns is-centered">
      <div class="column is-5">
        <h1 class="title has-text-centered">Crear cuenta</h1>

        <form class="box" @submit.prevent="submit">
          <div class="field">
            <label class="label">Nombre</label>
            <div class="control">
              <input
                v-model="form.name"
                class="input"
                :class="{ 'is-danger': userStore.errors.name }"
                type="text"
                required
              />
            </div>
            <p v-if="userStore.errors.name" class="help is-danger">
              {{ userStore.errors.name[0] }}
            </p>
          </div>

          <div class="field">
            <label class="label">Nickname</label>
            <div class="control">
              <input
                v-model="form.nickname"
                class="input"
                :class="{ 'is-danger': userStore.errors.nickname }"
                type="text"
                required
              />
            </div>
            <p v-if="userStore.errors.nickname" class="help is-danger">
              {{ userStore.errors.nickname[0] }}
            </p>
          </div>

          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input
                v-model="form.email"
                class="input"
                :class="{ 'is-danger': userStore.errors.email }"
                type="email"
                required
              />
            </div>
            <p v-if="userStore.errors.email" class="help is-danger">
              {{ userStore.errors.email[0] }}
            </p>
          </div>

          <div class="field">
            <label class="label">Fecha de nacimiento</label>
            <div class="control">
              <input
                v-model="form.birthdate"
                class="input"
                :class="{ 'is-danger': userStore.errors.birthdate }"
                type="date"
              />
            </div>
            <p v-if="userStore.errors.birthdate" class="help is-danger">
              {{ userStore.errors.birthdate[0] }}
            </p>
          </div>

          <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
              <input
                v-model="form.password"
                class="input"
                :class="{ 'is-danger': userStore.errors.password }"
                type="password"
                required
              />
            </div>
            <p v-if="userStore.errors.password" class="help is-danger">
              {{ userStore.errors.password[0] }}
            </p>
          </div>

          <div class="field">
            <label class="label">Repetir contraseña</label>
            <div class="control">
              <input v-model="form.password_confirmation" class="input" type="password" required />
            </div>
          </div>

          <div class="field">
            <label class="label">Foto (opcional)</label>
            <div class="file has-name">
              <label class="file-label">
                <input class="file-input" type="file" accept="image/*" @change="onFile" />
                <span class="file-cta">
                  <span class="file-label">Elegir archivo…</span>
                </span>
                <span class="file-name">{{ form.photo?.name ?? 'Ninguno seleccionado' }}</span>
              </label>
            </div>
            <p v-if="userStore.errors.photo" class="help is-danger">
              {{ userStore.errors.photo[0] }}
            </p>
          </div>

          <button
            type="submit"
            class="button is-primary is-fullwidth"
            :class="{ 'is-loading': loading }"
          >
            Registrarme
          </button>
        </form>

        <p class="has-text-centered">
          ¿Ya tienes cuenta?
          <RouterLink to="/login">Inicia sesión</RouterLink>
        </p>
      </div>
    </div>
  </section>
</template>

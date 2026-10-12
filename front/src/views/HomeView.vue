<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';

const message = ref('Cargando...');

onMounted(async () => {
  const response = await axios('http://localhost:8000/api/ping')
  console.log(response)
  message.value = response.data.message;
})
</script>

<template>
  <h1>{{ message }}</h1>
</template>

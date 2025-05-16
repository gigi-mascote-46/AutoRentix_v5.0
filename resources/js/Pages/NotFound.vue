<template>
  <div class="mt-20 text-center">
    <h1 class="mb-4 text-5xl font-bold">404</h1>
    <p class="mb-6 text-xl">Página não encontrada.</p>
    <inertia-link href="/" class="text-blue-600 hover:underline">Voltar à página inicial</inertia-link>
  </div>
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });
</script>

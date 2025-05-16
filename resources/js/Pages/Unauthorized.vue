<template>
  <div class="mt-20 text-center">
    <h1 class="mb-4 text-4xl font-bold">Acesso Negado</h1>
    <p class="mb-6">Não tem permissões para aceder a esta página.</p>
    <inertia-link href="/" class="text-blue-600 hover:underline">Voltar à página inicial</inertia-link>
  </div>
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });
</script>

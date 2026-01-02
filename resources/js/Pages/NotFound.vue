<template>
  <div class="mt-20 text-center">
    <h1 class="mb-4 text-5xl font-bold">404</h1>
    <p class="mb-6 text-xl">Página não encontrada.</p>
    <Link href="/" class="text-blue-600 hover:underline">Voltar à página inicial</Link>
  </div>
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });
</script>

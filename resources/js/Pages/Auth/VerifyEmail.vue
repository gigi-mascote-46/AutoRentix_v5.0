<template>
  <div>
    <h1 class="mb-4 text-xl font-bold">Verifica o teu Email</h1>
    <p class="mb-4">Foi enviado um link de verificação para o teu email.</p>
    <p>Se não recebeste, clica abaixo para reenviar:</p>

    <form @submit.prevent="submit">
      <button class="px-4 py-2 mt-4 text-white bg-blue-600 rounded hover:bg-blue-700">
        Reenviar Email de Verificação
      </button>
    </form>
  </div>
</template>

<script setup>

import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })

import { useForm } from '@inertiajs/vue3';

const form = useForm();

function submit() {
  form.post(route('verification.send'));
}
</script>

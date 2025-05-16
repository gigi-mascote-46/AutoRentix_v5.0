<template>
  <div>
    <h1 class="mb-4 text-xl font-bold">Recuperar Palavra-passe</h1>
    <p class="mb-4">Insere o teu email para receberes o link de recuperação.</p>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="email" class="block font-semibold">Email</label>
        <input type="email" v-model="form.email" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</div>
      </div>

      <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Enviar link</button>
    </form>
  </div>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })


import { useForm } from '@inertiajs/vue3';

const form = useForm({ email: '' });

function submit() {
  form.post(route('password.email'));
}
</script>

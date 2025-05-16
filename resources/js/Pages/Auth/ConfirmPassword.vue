<template>
  <div>
    <h1 class="mb-4 text-xl font-bold">Confirmar Palavra-passe</h1>
    <p class="mb-4">Por favor confirma a tua palavra-passe antes de continuares.</p>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="password" class="block font-semibold">Palavra-passe</label>
        <input type="password" v-model="form.password" id="password" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}</div>
      </div>

      <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Confirmar</button>
    </form>
  </div>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'  // Import the AuthLayout component
defineOptions({ layout: AuthLayout })

import { useForm } from '@inertiajs/vue3';

const form = useForm({
  password: '',
});

function submit() {
  form.post(route('password.confirm'));
}
</script>

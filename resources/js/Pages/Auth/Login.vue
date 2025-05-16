<template>
  <div>
    <h1 class="mb-4 text-xl font-bold">Iniciar Sessão</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label>Email</label>
        <input type="email" v-model="form.email" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</div>
      </div>

      <div>
        <label>Palavra-passe</label>
        <input type="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}</div>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center space-x-2">
          <input type="checkbox" v-model="form.remember" />
          <span>Lembrar-me</span>
        </label>
        <inertia-link :href="route('password.request')" class="text-sm text-blue-600 hover:underline">Esqueceste a senha?</inertia-link>
      </div>

      <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Entrar</button>
    </form>
  </div>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })

import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function submit() {
  form.post(route('login'));
}
</script>


<template>
  <div>
    <h1 class="mb-4 text-xl font-bold">Criar Conta</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label>Nome</label>
        <input type="text" v-model="form.name" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
      </div>

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

      <div>
        <label>Confirmar Palavra-passe</label>
        <input type="password" v-model="form.password_confirmation" class="w-full px-3 py-2 border rounded" />
      </div>

      <button class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Criar Conta</button>
    </form>
  </div>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })

import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

function submit() {
  form.post('/register');
}
</script>

<template>
  <div>
    <h1 class="mb-4 text-xl font-bold">Redefinir Palavra-passe</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <input type="hidden" :value="token" v-model="form.token" />

      <div>
        <label>Email</label>
        <input type="email" v-model="form.email" class="w-full px-3 py-2 border rounded" />
      </div>

      <div>
        <label>Nova Palavra-passe</label>
        <input type="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
      </div>

      <div>
        <label>Confirmar Palavra-passe</label>
        <input type="password" v-model="form.password_confirmation" class="w-full px-3 py-2 border rounded" />
      </div>

      <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Redefinir</button>
    </form>
  </div>
</template>

<script setup>

import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })

import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({ token: String });
const form = useForm({
  token: props.token,
  email: '',
  password: '',
  password_confirmation: '',
});

function submit() {
  form.post(route('password.update'));
}
</script>

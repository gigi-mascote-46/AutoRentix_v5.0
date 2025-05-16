<!--  Gestão de perfil e password -->
<template>
  <div>
    <h1 class="mb-4 text-2xl font-bold">O Meu Perfil</h1>

    <form @submit.prevent="updateProfile" class="max-w-lg space-y-4">
      <div>
        <label for="name" class="block font-semibold">Nome</label>
        <input type="text" id="name" v-model="form.name" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
      </div>

      <div>
        <label for="email" class="block font-semibold">Email</label>
        <input type="email" id="email" v-model="form.email" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</div>
      </div>

      <div>
        <label for="password" class="block font-semibold">Nova Palavra-passe (opcional)</label>
        <input type="password" id="password" v-model="form.password" class="w-full px-3 py-2 border rounded" />
        <div v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}</div>
      </div>

      <div>
        <label for="password_confirmation" class="block font-semibold">Confirmar Palavra-passe</label>
        <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="w-full px-3 py-2 border rounded" />
      </div>

      <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
        Guardar Alterações
      </button>
    </form>
  </div>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  user: Object,
});

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
});

function updateProfile() {
  form.put(route('profile.update'));
}
</script>

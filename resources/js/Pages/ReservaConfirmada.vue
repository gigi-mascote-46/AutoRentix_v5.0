<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const form = ref({
  name: '',
  email: '',
  phone: '',
  vehicle: '',
  date: '',
});

const errorMessage = ref('');
const successMessage = ref('');

function validateForm() {
  if (!form.value.name || !form.value.email || !form.value.phone || !form.value.vehicle || !form.value.date) {
    errorMessage.value = 'Por favor, preencha todos os campos.';
    successMessage.value = '';
    return false;
  }
  // Simple email validation
  const emailPattern = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
  if (!emailPattern.test(form.value.email)) {
    errorMessage.value = 'Por favor, insira um email válido.';
    successMessage.value = '';
    return false;
  }
  return true;
}

function submitForm() {
  if (!validateForm()) {
    return;
  }
  // Simulate form submission success
  errorMessage.value = '';
  successMessage.value = 'Reserva confirmada com sucesso!';
  // Reset form
  form.value = {
    name: '',
    email: '',
    phone: '',
    vehicle: '',
    date: '',
  };
}

defineOptions({ layout: GuestLayout });
</script>

<template>
  <div class="max-w-md p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Formulário de Reserva de Viatura</h1>
    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label for="name" class="block font-medium">Nome Completo</label>
        <input id="name" v-model="form.name" type="text" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label for="email" class="block font-medium">Email</label>
        <input id="email" v-model="form.email" type="email" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label for="phone" class="block font-medium">Telefone</label>
        <input id="phone" v-model="form.phone" type="tel" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label for="vehicle" class="block font-medium">Viatura</label>
        <input id="vehicle" v-model="form.vehicle" type="text" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label for="date" class="block font-medium">Data da Reserva</label>
        <input id="date" v-model="form.date" type="date" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Reservar</button>
      </div>
    </form>
    <div v-if="errorMessage" class="mt-4 font-semibold text-red-600">{{ errorMessage }}</div>
    <div v-if="successMessage" class="mt-4 font-semibold text-green-600">{{ successMessage }}</div>
  </div>
</template>


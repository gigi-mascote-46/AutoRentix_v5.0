<!-- Lista de reservas feitas pelo utilizador -->
<template>
  <div>
    <h1>As Minhas Reservas</h1>
    <table class="min-w-full mt-4 border border-collapse border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border">ID</th>
          <th class="px-4 py-2 border">Viatura</th>
          <th class="px-4 py-2 border">Data Início</th>
          <th class="px-4 py-2 border">Data Fim</th>
          <th class="px-4 py-2 border">Status</th>
          <th class="px-4 py-2 border">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="reserva in reservations" :key="reserva.id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border">{{ reserva.id }}</td>
          <td class="px-4 py-2 border">{{ reserva.bemLocavel?.modelo || 'N/D' }}</td>
          <td class="px-4 py-2 border">{{ reserva.data_inicio }}</td>
          <td class="px-4 py-2 border">{{ reserva.data_fim }}</td>
          <td class="px-4 py-2 border">{{ reserva.status }}</td>
          <td class="px-4 py-2 border">
            <inertia-link
              :href="route('my_reservations.show', reserva.id)"
              class="text-blue-600 hover:underline"
            >
              Ver detalhes
            </inertia-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  reservations: Array,
});
</script>

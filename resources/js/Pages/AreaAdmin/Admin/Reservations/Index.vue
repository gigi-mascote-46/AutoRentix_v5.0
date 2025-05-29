<!-- Gestão de reservas -->
<template>
  <div>
    <h1>Lista de Reservas</h1>
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Utilizador</th>
          <th class="px-4 py-2 border border-gray-300">Viatura</th>
          <th class="px-4 py-2 border border-gray-300">Data Início</th>
          <th class="px-4 py-2 border border-gray-300">Data Fim</th>
          <th class="px-4 py-2 border border-gray-300">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="reservation in reservations" :key="reservation.id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border border-gray-300">{{ reservation.id }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ reservation.user?.name || 'N/D' }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ reservation.bemLocavel?.modelo || 'N/D' }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ reservation.data_inicio }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ reservation.data_fim }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ reservation.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
  reservations: Array,
});
</script>

<!-- Ver pagamentos -->
<template>
  <div>
    <h1>Admin - Lista de Pagamentos</h1>
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Reserva</th>
          <th class="px-4 py-2 border border-gray-300">Método</th>
          <th class="px-4 py-2 border border-gray-300">Montante (€)</th>
          <th class="px-4 py-2 border border-gray-300">Status</th>
          <th class="px-4 py-2 border border-gray-300">Data</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="payment in payments" :key="payment.id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border border-gray-300">{{ payment.id }}</td>
          <td class="px-4 py-2 border border-gray-300">
            Reserva #{{ payment.reservation_id }} - {{ payment.reservation?.bemLocavel?.modelo || 'N/D' }}
          </td>
          <td class="px-4 py-2 border border-gray-300">{{ payment.metodo }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ payment.montante.toFixed(2) }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ payment.status }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ new Date(payment.created_at).toLocaleDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
  payments: Array,
});
</script>

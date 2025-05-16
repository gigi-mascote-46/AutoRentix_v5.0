<!-- Histórico de pagamentos -->
<template>
  <div>
    <h1 class="mb-4 text-2xl font-bold">Os Meus Pagamentos</h1>

    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border">ID</th>
          <th class="px-4 py-2 border">Viatura</th>
          <th class="px-4 py-2 border">Montante (€)</th>
          <th class="px-4 py-2 border">Método</th>
          <th class="px-4 py-2 border">Status</th>
          <th class="px-4 py-2 border">Data</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="payment in payments" :key="payment.id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border">{{ payment.id }}</td>
          <td class="px-4 py-2 border">
            {{ payment.reservation?.bemLocavel?.modelo || 'N/D' }}
          </td>
          <td class="px-4 py-2 border">{{ payment.montante.toFixed(2) }}</td>
          <td class="px-4 py-2 border">{{ payment.metodo }}</td>
          <td class="px-4 py-2 border">{{ payment.status }}</td>
          <td class="px-4 py-2 border">{{ new Date(payment.created_at).toLocaleDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  payments: Array,
});
</script>

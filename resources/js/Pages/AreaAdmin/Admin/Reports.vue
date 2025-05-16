<!-- Relatórios e exportações (PDF/Excel) -->
<template>
  <div>
    <h1>Relatórios</h1>

    <div class="grid grid-cols-2 gap-6 mt-8">
      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="mb-2 text-lg font-semibold">Total de Receita (€)</h2>
        <p class="text-3xl">{{ reports.totalReceita.toFixed(2) }}</p>
      </div>

      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="mb-2 text-lg font-semibold">Total de Reservas</h2>
        <p class="text-3xl">{{ reports.totalReservas }}</p>
      </div>

      <div class="col-span-2 p-4 bg-gray-100 rounded shadow">
        <h2 class="mb-2 text-lg font-semibold">Reservas por Mês</h2>
        <ul class="list-disc list-inside">
          <li v-for="(count, mes) in reports.reservasPorMes" :key="mes">
            {{ mes }}: {{ count }} reservas
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
  reports: Object,
});
</script>

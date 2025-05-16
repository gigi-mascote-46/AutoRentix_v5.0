<!--  Painel do utilizador com resumo de reservas, saldo, etc. -->
<template>
  <div>
    <h1 class="mb-4 text-2xl font-bold">Bem-vindo, {{ user.name }} 👋</h1>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
      <div class="p-4 bg-blue-100 rounded shadow">
        <h2 class="text-lg font-semibold">Reservas ativas</h2>
        <p class="text-3xl">{{ stats.ativas }}</p>
      </div>

      <div class="p-4 bg-green-100 rounded shadow">
        <h2 class="text-lg font-semibold">Reservas concluídas</h2>
        <p class="text-3xl">{{ stats.concluidas }}</p>
      </div>

      <div class="p-4 bg-yellow-100 rounded shadow">
        <h2 class="text-lg font-semibold">Total gasto (€)</h2>
        <p class="text-3xl">{{ stats.totalGasto.toFixed(2) }}</p>
      </div>
    </div>

    <div class="mt-8">
      <h2 class="mb-2 text-xl font-semibold">Últimas Reservas</h2>
      <ul class="list-disc list-inside">
        <li v-for="reserva in reservasRecentes" :key="reserva.id">
          {{ reserva.bemLocavel?.modelo || 'Viatura desconhecida' }} —
          {{ reserva.data_inicio }} a {{ reserva.data_fim }} —
          <span class="italic">{{ reserva.status }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  user: Object,
  stats: Object,
  reservasRecentes: Array,
});
</script>

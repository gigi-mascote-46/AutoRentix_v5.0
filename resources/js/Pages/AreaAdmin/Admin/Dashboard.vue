Resumo com estatísticas, reservas ativas, etc.

<template>
  <div>
    <h1>Dashboard Administrativo</h1>
    <div class="grid grid-cols-3 gap-4 mt-6">
      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="text-lg font-semibold">Total de Viaturas</h2>
        <p class="text-3xl">{{ stats.vehicles }}</p>
      </div>
      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="text-lg font-semibold">Total de Utilizadores</h2>
        <p class="text-3xl">{{ stats.users }}</p>
      </div>
      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="text-lg font-semibold">Reservas Ativas</h2>
        <p class="text-3xl">{{ stats.activeReservations }}</p>
      </div>
    </div>

    <div class="mt-8">
      <h2 class="mb-4 text-xl font-semibold">Atalhos Rápidos</h2>
      <ul class="space-y-2 list-disc list-inside">
        <li><inertia-link :href="route('admin.vehicles.index')" class="text-blue-600 hover:underline">Gestão de Viaturas</inertia-link></li>
        <li><inertia-link :href="route('admin.users.index')" class="text-blue-600 hover:underline">Gestão de Utilizadores</inertia-link></li>
        <li><inertia-link :href="route('admin.reservations.index')" class="text-blue-600 hover:underline">Gestão de Reservas</inertia-link></li>
        <li><inertia-link :href="route('admin.payments.index')" class="text-blue-600 hover:underline">Gestão de Pagamentos</inertia-link></li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
  stats: Object,
});
</script>

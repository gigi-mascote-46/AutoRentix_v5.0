//Resumo com estatísticas, reservas ativas, etc.

<template>
  <AdminLayout>
    <template #header>
      Dashboard Administrativo
</template>

    <div class="space-y-6">
      <!-- Welcome Section -->
      <div class="p-6 text-white card-admin gradient-admin">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="mb-2 text-2xl font-bold">
              Painel de Administração
            </h1>
            <p class="text-blue-100">
              Gerencie viaturas, reservas, utilizadores e monitore o desempenho do sistema.
            </p>
          </div>
          <div class="hidden md:block">
            <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 card-admin">
          <div class="flex items-center">
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-admin-primary/10">
              <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Viaturas</p>
              <p class="text-2xl font-bold text-admin-text">{{ stats.totalVehicles || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="p-6 card-admin">
          <div class="flex items-center">
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-admin-primary/10">
              <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Utilizadores</p>
              <p class="text-2xl font-bold text-admin-text">{{ stats.totalUsers || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="p-6 card-admin">
          <div class="flex items-center">
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-admin-primary/10">
              <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Reservas Ativas</p>
              <p class="text-2xl font-bold text-admin-text">{{ stats.activeReservations || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="p-6 card-admin">
          <div class="flex items-center">
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-admin-primary/10">
              <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Próximas Reservas</p>
              <p class="text-2xl font-bold text-admin-text">{{ stats.upcomingReservations || 0 }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Atalhos Rápidos -->
      <div class="mt-8">
        <h2 class="mb-4 text-xl font-semibold">Atalhos Rápidos</h2>
        <ul class="space-y-2 list-disc list-inside">
          <li><Link :href="route('admin.vehicles.index')" class="text-blue-600 hover:underline">Gestão de Viaturas</Link></li>
          <li><Link :href="route('admin.users.index')" class="text-blue-600 hover:underline">Gestão de Utilizadores</Link></li>
          <li><Link :href="route('admin.reservations.index')" class="text-blue-600 hover:underline">Gestão de Reservas</Link></li>
          <li><Link :href="route('admin.payments.index')" class="text-blue-600 hover:underline">Gestão de Pagamentos</Link></li>
        </ul>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
  layout: AdminLayout,
  props: {
    stats: Object,
    upcomingReservations: Array,
  },
  setup() {
    // Remove any usage of definePageMeta or similar here
  }
};
</script>

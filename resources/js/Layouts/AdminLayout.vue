<template>
  <div>
    <nav class="p-4 text-white bg-gray-800">
      <h1 class="text-xl font-bold">PAINEL ADMINISTRATIVO</h1>
      <ul class="flex mt-2 space-x-4">
        <li><Link :href="route('admin.dashboard')" class="hover:underline">Dashboard</Link></li>
        <li><Link :href="route('admin.vehicles.index')" class="hover:underline">Viaturas</Link></li>
        <li><Link :href="route('admin.users.index')" class="hover:underline">Utilizadores</Link></li>
        <li><Link :href="route('admin.reservations.index')" class="hover:underline">Reservas</Link></li>
        <li><Link :href="route('admin.payments.index')" class="hover:underline">Pagamentos</Link></li>
      </ul>
    </nav>
    <main class="p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

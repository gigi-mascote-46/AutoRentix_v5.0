<template>
  <div>
    <h1>Admin - Lista de Viaturas</h1>
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Marca</th>
          <th class="px-4 py-2 border border-gray-300">Modelo</th>
          <th class="px-4 py-2 border border-gray-300">Cor</th>
          <th class="px-4 py-2 border border-gray-300">Preço Diário (€)</th>
          <th class="px-4 py-2 border border-gray-300">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="bem in bens" :key="bem.id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border border-gray-300">{{ bem.id }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ bem.marca.nome }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ bem.modelo }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ bem.cor }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ bem.preco_diario.toFixed(2) }}</td>
          <td class="px-4 py-2 border border-gray-300">
            <inertia-link :href="route('admin.vehicles.edit', bem.id)" class="mr-2 text-blue-600 hover:underline">
              Editar
            </inertia-link>
            <button @click="deleteVehicle(bem.id)" class="text-red-600 hover:underline">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  bens: Array,
});

function deleteVehicle(id) {
  if (confirm('Tem a certeza que deseja eliminar esta viatura?')) {
    Inertia.delete(route('admin.vehicles.destroy', id));
  }
}
</script>

<!--  Listagem pública de viaturas disponíveis -->
<template>
  <div>
    <h1 class="mb-6 text-2xl font-bold">Viaturas Disponíveis para Aluguer</h1>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="bem in bens"
        :key="bem.id"
        class="p-4 transition bg-white border rounded-lg shadow hover:shadow-md"
      >
        <h2 class="mb-1 text-lg font-semibold">{{ bem.modelo }}</h2>
        <p class="mb-2 text-sm text-gray-600">Marca: {{ bem.marca.nome }}</p>
        <p><strong>Cor:</strong> {{ bem.cor }}</p>
        <p><strong>Transmissão:</strong> {{ bem.transmissao }}</p>
        <p><strong>Combustível:</strong> {{ bem.combustivel }}</p>
        <p><strong>Preço diário:</strong> {{ bem.preco_diario.toFixed(2) }} €</p>

        <Link
          :href="route('vehicles.show', bem.id)"
          class="inline-block mt-4 text-sm text-blue-600 hover:underline"
        >
          Ver detalhes
        </Link>
      </div>
    </div>
     <div>
    <ul>
      <li v-for="bem in bens" :key="bem.id">
        Modelo: {{ bem.modelo }} -
        Preço Diário: {{ typeof bem.preco_diario === 'number' ? bem.preco_diario.toFixed(2) : 'N/D' }} €
      </li>
    </ul>
  </div>
  </div>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  bens: Array,
});
</script>

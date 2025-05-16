<!-- Página de detalhe de uma viatura -->
<template>
  <div>
    <h1>{{ bem.modelo }}</h1>
    <p><strong>Marca:</strong> {{ bem.marca.nome }}</p>
    <p><strong>Cor:</strong> {{ bem.cor }}</p>
    <p><strong>Preço Diário:</strong> {{ bem.preco_diario.toFixed(2) }} €</p>

    <h3>Características</h3>
    <ul>
      <li v-for="carac in bem.caracteristicas" :key="carac.id">
        {{ carac.nome }}
      </li>
    </ul>

    <h3>Localização</h3>
    <p>{{ bem.localizacao?.cidade || 'N/D' }} - {{ bem.localizacao?.filial || 'N/D' }}</p>
  </div>
   <div>
    <ul>
      <li v-for="bem in bens" :key="bem.id">
        Modelo: {{ bem.modelo }} -
        Preço Diário: {{ typeof bem.preco_diario === 'number' ? bem.preco_diario.toFixed(2) : 'N/D' }} €
      </li>
    </ul>
  </div>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  bem: Object,
});
</script>

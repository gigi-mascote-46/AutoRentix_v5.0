<!--  Detalhe de uma reserva -->
<template>
  <div>
    <h1>Detalhes da Reserva #{{ reservation.id }}</h1>

    <div class="mt-4">
      <h2 class="text-lg font-semibold">Viatura</h2>
      <p><strong>Modelo:</strong> {{ reservation.bemLocavel?.modelo || 'N/D' }}</p>
      <p><strong>Marca:</strong> {{ reservation.bemLocavel?.marca?.nome || 'N/D' }}</p>
      <p><strong>Cor:</strong> {{ reservation.bemLocavel?.cor || 'N/D' }}</p>
      <p><strong>Preço Diário:</strong> {{ reservation.bemLocavel?.preco_diario.toFixed(2) }} €</p>
    </div>

    <div class="mt-6">
      <h2 class="text-lg font-semibold">Dados da Reserva</h2>
      <p><strong>Data de Início:</strong> {{ reservation.data_inicio }}</p>
      <p><strong>Data de Fim:</strong> {{ reservation.data_fim }}</p>
      <p><strong>Status:</strong> {{ reservation.status }}</p>
      <p><strong>Criada em:</strong> {{ new Date(reservation.created_at).toLocaleDateString() }}</p>
    </div>

    <div class="mt-6">
      <h2 class="text-lg font-semibold">Localização da Viatura</h2>
      <p>{{ reservation.bemLocavel?.localizacao?.cidade || 'N/D' }} - {{ reservation.bemLocavel?.localizacao?.filial || 'N/D' }}</p>
    </div>

    <div class="mt-6">
      <h2 class="text-lg font-semibold">Características da Viatura</h2>
      <ul>
        <li v-for="carac in reservation.bemLocavel?.caracteristicas || []" :key="carac.id">
          {{ carac.nome }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  reservation: Object,
});
</script>

<!-- Página de detalhe de uma viatura -->
<template>
  <div class="flex gap-8">
    <div class="w-1/2">
      <img
        :src="bem.foto_url || '/images/placeholder-car.jpg'"
        :alt="`Foto da viatura ${bem.modelo}`"
        class="w-full h-auto rounded"
      />
    </div>
    <div class="w-1/2">
      <h1><strong>{{ bem.modelo }}</strong></h1>
      <br>
      <p><strong>Marca:</strong> {{ bem.marca.nome }}</p>

      <p><strong>Cor:</strong> {{ bem.cor }}</p>

<p><strong>Preço Diário:</strong> {{ Number(bem.preco_diario) ? Number(bem.preco_diario).toFixed(2) : 'N/D' }} €</p>
<br>
      <h3>Características</h3>
      <ul>
        <li v-for="carac in bem.caracteristicas" :key="carac.id">
          {{ carac.nome }}
        </li>
      </ul>
<br>
      <h3>Localização</h3>
      <p>{{ bem.localizacao?.cidade || 'N/D' }} - {{ bem.localizacao?.filial || 'N/D' }}</p>

      <h3>Reservas</h3>
      <div v-if="reservations.length > 0">
        <ul>
          <li v-for="reservation in reservations" :key="reservation.id">
            Início: {{ new Date(reservation.data_inicio).toLocaleDateString() }} -
            Fim: {{ new Date(reservation.data_fim).toLocaleDateString() }} -
            Status: {{ reservation.status }}
          </li>
        </ul>
      </div>
      <div v-else>
        <p>Não existem reservas para esta viatura.</p>
      </div>

      <h3>Fazer Reserva</h3>
      <form @submit.prevent="confirmReservation">
        <div>
          <label for="data_inicio">Data Início:</label>
          <input type="date" id="data_inicio" v-model="dataInicio" required />
        </div>
        <div>
          <label for="data_fim">Data Fim:</label>
          <input type="date" id="data_fim" v-model="dataFim" required />
        </div>
        <button type="submit">Confirmar Reserva</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

defineProps({
  bem: Object,
  reservations: {
    type: Array,
    default: () => [],
  },
});

const dataInicio = ref('');
const dataFim = ref('');

function confirmReservation() {
  if (!dataInicio.value || !dataFim.value) {
    alert('Por favor, selecione as datas de início e fim.');
    return;
  }
  if (dataFim.value < dataInicio.value) {
    alert('A data de fim deve ser posterior à data de início.');
    return;
  }
  // Redirect to payment page with query params (adjust route as needed)
  router.visit(route('areacliente.vehicles.reserve.payment', {
    id: __props.bem.id,
    dataInicio: dataInicio.value,
    dataFim: dataFim.value,
  }));
}
</script>

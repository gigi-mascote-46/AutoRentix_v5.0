<!-- Página de detalhe de uma viatura -->
<template>
  <GuestLayout>
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <!-- Breadcrumb -->
      <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <Link :href="route('home')" class="text-gray-500 hover:text-user-primary">
              Início
            </Link>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
              <Link :href="route('vehicles.index')" class="text-gray-500 hover:text-user-primary">
                Viaturas
              </Link>
            </div>
          </li>
          <li aria-current="page">
            <div class="flex items-center">
              <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
              <span class="font-medium text-user-text">{{ bem.modelo }}</span>
            </div>
          </li>
        </ol>
      </nav>

      <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
        <!-- Vehicle Image -->
        <div class="space-y-4">
          <div class="overflow-hidden card">
            <img :src="bem.foto_url || '/images/placeholder-car.jpg'"
                 :alt="`Foto da viatura ${bem.modelo}`"
                 class="object-cover w-full h-96" />
          </div>

          <!-- Additional Images (if available) -->
          <div v-if="bem.photos && bem.photos.length > 0"
               class="grid grid-cols-3 gap-2">
            <div v-for="photo in bem.photos.slice(0, 3)" :key="photo.id"
                 class="overflow-hidden transition-shadow cursor-pointer card hover:shadow-medium">
              <img :src="photo.photo_path"
                   :alt="`Foto adicional ${bem.modelo}`"
                   class="object-cover w-full h-24" />
            </div>
          </div>
        </div>

        <!-- Vehicle Details -->
        <div class="space-y-8">
          <!-- Header -->
          <div>
            <div class="flex items-center justify-between mb-4">
              <div>
                <h1 class="text-3xl font-bold text-user-text">{{ bem.modelo }}</h1>
                <p class="text-xl text-gray-600">{{ bem.marca?.nome }}</p>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-user-primary">
                  {{ Number(bem.preco_diario).toFixed(2) }}€
                </div>
                <p class="text-gray-500">por dia</p>
              </div>
            </div>

            <!-- Status Badge -->
            <div class="flex items-center space-x-2">
              <span v-if="!bem.manutencao"
                    class="px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                Disponível
              </span>
              <span v-else
                    class="px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                Em Manutenção
              </span>
              <span class="px-3 py-1 text-sm font-medium rounded-full bg-user-secondary text-user-text">
                {{ bem.ano }}
              </span>
            </div>
          </div>

          <!-- Vehicle Specifications -->
          <div class="p-6 card">
            <h3 class="mb-4 text-lg font-semibold text-user-text">Especificações</h3>
            <div class="grid grid-cols-2 gap-4">
              <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-user-primary/10">
                  <svg class="w-5 h-5 text-user-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Passageiros</p>
                  <p class="font-medium text-user-text">{{ bem.numero_passageiros }}</p>
                </div>
              </div>

              <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-user-primary/10">
                  <svg class="w-5 h-5 text-user-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-6" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Combustível</p>
                  <p class="font-medium capitalize text-user-text">{{ bem.combustivel }}</p>
                </div>
              </div>

              <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-user-primary/10">
                  <svg class="w-5 h-5 text-user-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Transmissão</p>
                  <p class="font-medium capitalize text-user-text">{{ bem.transmissao }}</p>
                </div>
              </div>

              <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-user-primary/10">
                  <svg class="w-5 h-5 text-user-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-6" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Ano</p>
                  <p class="font-medium text-user-text">{{ bem.ano }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Localização -->
          <h3>Localização</h3>
          <p>{{ bem.localizacao?.cidade || 'N/D' }} - {{ bem.localizacao?.filial || 'N/D' }}</p>

          <!-- Histórico de reservas -->
          <h3>Reservas</h3>
          <div v-if="reservations.length > 0">
            <ul>
              <li v-for="reservation in reservations" :key="reservation.id">
                <p>Início: {{ new Date(reservation.data_inicio).toLocaleDateString() }} -</p>
                <p>Fim: {{ new Date(reservation.data_fim).toLocaleDateString() }} - </p>
                <p>Status: {{ reservation.status }}</p>
              </li>
            </ul>
          </div>
          <div v-else>
            <p><i>Não existem reservas para esta viatura.</i></p>
          </div>

          <!-- Formulário de Reserva -->
          <h3><strong>Reserva</strong></h3>
          <form @submit.prevent="confirmReservation">
            <div>
              <label for="data_inicio"> Data Início: </label>
              <input
                type="date"
                id="data_inicio"
                v-model="dataInicio"
                :min="currentDate"
                class="px-5 pt-3 pb-3 mb-4 bg-white rounded shadow-md"
                required
              />
            </div>
            <div>
              <label for="data_fim"> Data Fim: </label>
              <input
                type="date"
                id="data_fim"
                v-model="dataFim"
                :min="nextDayDate"
                class="px-5 pt-3 pb-3 mb-4 bg-white rounded shadow-md"
                required
              />
            </div>
            <br>
            <button type="submit" class="px-4 py-2 font-semibold text-yellow-500 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">
              Confirmar Reserva
            </button>
          </form>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

import GuestLayout from '@/Layouts/GuestLayout.vue';
// Define o layout da página
defineOptions({ layout: GuestLayout });

// Props recebidas do controlador Laravel
const props = defineProps({
  bem: Object,          // Dados do veículo
  reservations: {       // Lista de reservas existentes
    type: Array,
    default: () => [],
  },
});

/**
 * Função para obter a data atual no formato YYYY-MM-DD
 * Compatível com inputs de data
 */
const getCurrentDate = () => {
  const today = new Date();
  return today.toISOString().split('T')[0];
};

/**
 * Função para obter o próximo dia de uma data
 * @param {String} startDate - Data de referência (opcional)
 * @returns Data no dia seguinte no formato YYYY-MM-DD
 */
const getNextDate = (startDate = null) => {
  const date = startDate ? new Date(startDate) : new Date();
  date.setDate(date.getDate() + 1);
  return date.toISOString().split('T')[0];
};

// Variáveis reativas para controle de datas
const currentDate = ref(getCurrentDate()); // Data atual para validação
const dataInicio = ref(getCurrentDate());  // Data inicial padrão: hoje
const dataFim = ref(getNextDate());        // Data final padrão: amanhã

/**
 * Watcher para a data de início:
 * - Garante que a data final seja sempre posterior à data de início
 * - Atualiza automaticamente a data final se necessário
 */
watch(dataInicio, (newStart) => {
  // Compara datas como objetos Date
  if (new Date(dataFim.value) < new Date(newStart)) {
    // Se data final for anterior à nova data de início
    dataFim.value = getNextDate(newStart);
  }
});

/**
 * Validação inicial ao montar o componente:
 * - Corrige qualquer inconsistência que possa existir entre datas
 */
onMounted(() => {
  if (new Date(dataFim.value) < new Date(dataInicio.value)) {
    dataFim.value = getNextDate(dataInicio.value);
  }
});

/**
 * Processa o formulário de reserva
 * - Valida datas selecionadas
 * - Redireciona para página de pagamento
 */
function confirmReservation() {
  // Validação básica de preenchimento
  if (!dataInicio.value || !dataFim.value) {
    alert('Por favor, selecione as datas de início e fim.');
    return;
  }

  // Validação de lógica temporal
  if (new Date(dataFim.value) < new Date(dataInicio.value)) {
    alert('A data de fim deve ser posterior à data de início.');
    return;
  }

  // Redireciona para página de pagamento com parâmetros
  router.visit(route('areacliente.vehicles.reserve.payment', {
    id: props.bem.id,              // ID do veículo
    dataInicio: dataInicio.value,  // Data de início selecionada
    dataFim: dataFim.value,        // Data de fim selecionada
  }));
}
</script>

<!-- Gestão de reservas -->
<template>
  <div>
    <!-- Título da página -->
    <h1>Lista de Reservas</h1>

    <!-- Tabela que apresenta a lista de reservas -->
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <!-- Cabeçalho com os títulos das colunas -->
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Utilizador</th>
          <th class="px-4 py-2 border border-gray-300">Viatura</th>
          <th class="px-4 py-2 border border-gray-300">Data Início</th>
          <th class="px-4 py-2 border border-gray-300">Data Fim</th>
          <th class="px-4 py-2 border border-gray-300">Status</th>
        </tr>
      </thead>
      <tbody>
        <!-- Ciclo v-for para percorrer todas as reservas recebidas por props -->
        <tr v-for="reservation in reservations" :key="reservation.id" class="hover:bg-gray-100">

          <!-- Mostra o ID da reserva -->
          <td class="px-4 py-2 border border-gray-300">{{ reservation.id }}</td>

          <!-- Mostra o nome do utilizador que fez a reserva, ou 'N/D' caso o dado não esteja disponível -->
          <td class="px-4 py-2 border border-gray-300">{{ reservation.user?.name || 'N/D' }}</td>

          <!-- Mostra o modelo da viatura reservada (bem locável), ou 'N/D' se não estiver disponível -->
          <td class="px-4 py-2 border border-gray-300">{{ reservation.bemLocavel?.modelo || 'N/D' }}</td>

          <!-- Mostra a data de início da reserva -->
          <td class="px-4 py-2 border border-gray-300">{{ reservation.data_inicio }}</td>

          <!-- Mostra a data de fim da reserva -->
          <td class="px-4 py-2 border border-gray-300">{{ reservation.data_fim }}</td>

          <!-- Mostra o estado atual da reserva (ex: ativa, concluída, cancelada) -->
          <td class="px-4 py-2 border border-gray-300">{{ reservation.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
// Importo o layout de administrador para garantir consistência visual com o resto do backoffice
import AdminLayout from '@/Layouts/AdminLayout.vue';

// Aplico o layout importado a esta página
defineOptions({ layout: AdminLayout });

// Defino que esta componente recebe uma prop chamada 'reservations', que será um array com os dados das reservas
defineProps({
  reservations: Array,
});
</script>

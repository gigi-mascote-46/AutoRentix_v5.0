<!-- Ver pagamentos -->
<template>
  <div>
    <!-- Título da página -->
    <h1>Lista de Pagamentos</h1>

    <!-- Tabela para apresentar os dados dos pagamentos -->
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <!-- Cabeçalho da tabela com os nomes das colunas -->
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Reserva</th>
          <th class="px-4 py-2 border border-gray-300">Método</th>
          <th class="px-4 py-2 border border-gray-300">Montante (€)</th>
          <th class="px-4 py-2 border border-gray-300">Status</th>
          <th class="px-4 py-2 border border-gray-300">Data</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop para percorrer todos os pagamentos recebidos como prop -->
        <tr v-for="payment in payments" :key="payment.id" class="hover:bg-gray-100">
          <!-- Mostra o ID do pagamento -->
          <td class="px-4 py-2 border border-gray-300">{{ payment.id }}</td>

          <!-- Mostra o ID da reserva associada e o modelo do bem locável, se existir -->
          <td class="px-4 py-2 border border-gray-300">
            Reserva #{{ payment.reservation_id }} - {{ payment.reservation?.bemLocavel?.modelo || 'N/D' }}
          </td>

          <!-- Mostra o método de pagamento (ex: cartão, MBWay, etc.) -->
          <td class="px-4 py-2 border border-gray-300">{{ payment.metodo }}</td>

          <!-- Mostra o montante do pagamento, formatado com 2 casas decimais -->
          <td class="px-4 py-2 border border-gray-300">{{ payment.montante.toFixed(2) }}</td>

          <!-- Mostra o estado atual do pagamento (ex: pago, pendente, etc.) -->
          <td class="px-4 py-2 border border-gray-300">{{ payment.status }}</td>

          <!-- Mostra a data em que o pagamento foi criado, no formato local (ex: dd/mm/aaaa) -->
          <td class="px-4 py-2 border border-gray-300">{{ new Date(payment.created_at).toLocaleDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
// Importo o layout de administração para que esta página fique com o mesmo aspeto das restantes páginas de admin
import AdminLayout from '@/Layouts/AdminLayout.vue';

// Aplico o layout importado à página
defineOptions({ layout: AdminLayout });

// Defino as propriedades que esta componente recebe — neste caso, um array de pagamentos
defineProps({
  payments: Array,
});
</script>

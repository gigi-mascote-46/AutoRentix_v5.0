<template>
  <div class="max-w-4xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Transação Concluída</h1>
    <div class="p-6 space-y-4 bg-white rounded shadow">
      <p><strong>Nome do Pagador:</strong> {{ payerName }}</p>
      <p><strong>Valor Pago:</strong> {{ amount }} €</p>
      <p>Obrigado pela sua reserva! A sua transação foi concluída com sucesso.</p>
      <router-link href="/areacliente/reservations" class="btn btn-primary">Ver Reservas</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });

const page = usePage();
const amount = computed(() => props.amount ?? page.props.amount ?? new URLSearchParams(window.location.search).get('amount'));
const payerName = computed(() => props.payerName ?? page.props.payerName ?? new URLSearchParams(window.location.search).get('payerName'));
const props = defineProps({
  amount: {
    type: [Number, String],
    default: null
  },
  payerName: {
    type: String,
    default: ''
  }
});
</script>

<style scoped>
.btn-primary {
  background-color: #facc15;
  color: #000;
  padding: 0.75rem 1.5rem;
  font-weight: bold;
  border-radius: 0.375rem;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  text-align: center;
}

.btn-primary:hover {
  background-color: #eab308;
}
</style>

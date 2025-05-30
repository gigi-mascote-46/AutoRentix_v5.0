<template>
  <div class="max-w-4xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Transação Concluída</h1>
    <p>Pagamento de {{ amount }} € realizado com sucesso por {{ payerName }}.</p>
    <router-link href="/" class="mt-4 btn btn-primary">Voltar ao Início</router-link>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  amount: String,
  payerName: String,
});

const amount = props.amount || 'desconhecido';
const payerName = props.payerName || 'desconhecido';
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
}
.btn-primary:hover {
  background-color: #eab308;
}
</style>

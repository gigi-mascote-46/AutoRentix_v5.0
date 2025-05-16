<template>
  <div>
    <h1>Detalhes da Viatura</h1>
    <p><strong>Marca:</strong> {{ bem.marca.nome }}</p>
    <p><strong>Modelo:</strong> {{ bem.modelo }}</p>
    <p><strong>Cor:</strong> {{ bem.cor }}</p>
    <p><strong>Registo:</strong> {{ bem.registo_unico_publico }}</p>
    <p><strong>Passageiros:</strong> {{ bem.numero_passageiros }}</p>
    <p><strong>Combustível:</strong> {{ bem.combustivel }}</p>
    <p><strong>Portas:</strong> {{ bem.numero_portas }}</p>
    <p><strong>Transmissão:</strong> {{ bem.transmissao }}</p>
    <p><strong>Ano:</strong> {{ bem.ano }}</p>
    <p><strong>Em Manutenção:</strong> {{ bem.manutencao ? 'Sim' : 'Não' }}</p>
    <p><strong>Preço Diário:</strong> {{ bem.preco_diario.toFixed(2) }} €</p>
    <p><strong>Observação:</strong> {{ bem.observacao || 'Nenhuma' }}</p>

    <h3>Características</h3>
    <ul>
      <li v-for="carac in bem.caracteristicas" :key="carac.id">{{ carac.nome }}</li>
    </ul>

    <h3>Localização</h3>
    <p>{{ bem.localizacao?.cidade || 'N/D' }} - {{ bem.localizacao?.filial || 'N/D' }} ({{ bem.localizacao?.posicao || 'N/D' }})</p>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
  bem: Object,
});
</script>

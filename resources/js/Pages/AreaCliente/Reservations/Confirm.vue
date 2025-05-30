<template>
  <div class="max-w-4xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Confirme a sua reserva</h1>
    <div class="p-6 bg-white rounded shadow">
      <h2 class="mb-2 text-xl font-semibold">Detalhes da Viatura</h2>
      <div class="flex gap-4">
        <img :src="bem.foto_url || '/images/placeholder-car.jpg'" alt="Foto da viatura" class="w-48 rounded" />
        <div>
          <p><strong>Modelo:</strong> {{ bem.modelo }}</p>
          <p><strong>Marca:</strong> {{ bem.marca.nome }}</p>
          <p><strong>Cor:</strong> {{ bem.cor }}</p>
          <p><strong>Preço Diário:</strong> {{ Number(bem.preco_diario).toFixed(2) }} €</p>
        </div>
      </div>
      <div class="mt-6">
        <inertia-link :href="route('vehicles.show', bem.id)" class="text-blue-600 hover:underline">Voltar à viatura</inertia-link>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  bem: Object,
});
</script>

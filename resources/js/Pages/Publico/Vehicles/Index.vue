<template>
  <div>
    <h1 class="mb-6 text-2xl font-bold">Viaturas Disponíveis para Aluguer</h1>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div
        v-for="bem in bens"
        :key="bem.id"
        class="p-4 transition bg-white border rounded-lg shadow hover:shadow-md"
      >
        <h2 class="mb-1 text-lg font-semibold">{{ bem.modelo }}</h2>
        <p class="mb-2 text-sm text-gray-600">Marca: {{ bem.marca.nome }}</p>

        <div class="relative w-full h-48 mb-4 overflow-hidden rounded">
          <img
            :src="bem.imageUrl || placeholderImage"
            alt="Imagem da viatura"
            class="object-cover w-full h-full transition-transform duration-300 transform hover:scale-105"
          />
          <div
            class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 opacity-0 cursor-pointer hover:opacity-100"
            @click="handleReservarClick(bem.id)"
          >
            <span class="text-lg font-semibold text-white">Reservar</span>
          </div>
        </div>

        <p><strong>Cor:</strong> {{ bem.cor }}</p>
        <p><strong>Transmissão:</strong> {{ bem.transmissao }}</p>
        <p><strong>Combustível:</strong> {{ bem.combustivel }}</p>
<p><strong>Preço diário:</strong> {{ typeof bem.preco_diario === 'number' ? bem.preco_diario.toFixed(2) : (typeof bem.preco_diario === 'string' ? bem.preco_diario : 'N/D') }} €</p>

        <Link
          :href="route('vehicles.show', bem.id)"
          class="inline-block mt-4 text-sm text-blue-600 hover:underline"
        >
          Ver detalhes
        </Link>
      </div>
    </div>

    <div v-if="showLoginMessage" class="fixed px-4 py-2 text-white transform -translate-x-1/2 bg-red-600 rounded shadow-lg bottom-4 left-1/2">
      Precisa estar logado para efetuar uma reserva.
      <button class="ml-4 underline" @click="showLoginMessage = false">Fechar</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/inertia-vue3';

defineProps({
  bens: Array,
});

const placeholderImage = '/images/placeholder-car.png'; // Ensure this path is valid and image exists

const page = usePage();
const user = page.props.auth.user || null;

const showLoginMessage = ref(false);

function handleReservarClick(bemId) {
  if (!user) {
    showLoginMessage.value = true;
  } else {
    // Proceed with reservation logic or navigation
    // For now, navigate to vehicle details page as placeholder
    window.location.href = route('vehicles.show', bemId);
  }
}
</script>

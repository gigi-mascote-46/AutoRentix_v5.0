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
              v-if="bem.photos && bem.photos.length > 0"
              :src="`/storage/${bem.photos[0].photo_path}`"
              alt="Imagem da viatura"
              class="object-cover w-full h-full transition-transform duration-300 transform hover:scale-105"
              @error="event => event.target.src = placeholderImage"
            />
            <img
              v-else
              :src="placeholderImage"
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
          :href="route('publico.vehicles.show', bem.id)"
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
import { usePage, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

defineProps({
  bens: Array,
});

const placeholderImage = '/images/placeholder-car.png'; // Ensure this path is valid and image exists

// Mapping from modelo_cor to full image filename including year and extension
const imageMap = {
  'captur_preto': 'captur_preto_2020.jpeg',
  'captur_red': 'captur_red_2021.jpeg',
  'civic_blue': 'civic_blue_2021.jpeg',
  'civic_grey': 'civic_grey_2020.jpeg',
  'clio_blue': 'clio_blue_2021.jpeg',
  'clio_white': 'clio_white_2020.jpeg',
  'corolla_grey': 'corolla_grey_2022.jpg',
  'corolla_white': 'corolla_white_2020.jpg',
  'ecosport_black': 'ecosport_black_2020.jpeg',
  'ecosport_white': 'ecosport_white_2022.jpeg',
  'fiesta_blue': 'fiesta_blue_2022.jpeg',
  'fiesta_red': 'fiesta_red_2020.jpeg',
  'fit_red': 'fit_red_2020.jpeg',
  'fit_white': 'fit_white_2022.jpeg',
  'focus_black': 'focus_black_2021.jpeg',
  'focus_white': 'focus_white_2020.jpg',
  'golf_black': 'golf_black_2022.jpeg',
  'golf_grey': 'golf_grey_2020.jpeg',
  'hrv_black': 'hrv_black_2020.jpeg',
  'hrv_grey': 'hrv_grey_2021.jpeg',
  'megane_blue': 'megane_blue_2020.jpeg',
  'megane_grey': 'megane_grey_2020.jpeg',
  'polo_grey': 'polo_grey_2022.jpeg',
  'polo_red': 'polo_red_2020.jpeg',
  'rav4_preto': 'rav4_preto_2023.jpeg',
  'rav4_white': 'rav4_white_2024.jpeg',
  'tiguan_black': 'tiguan_black_2022.jpeg',
  'tiguan_blue': 'tiguan_blue_2020.jpeg',
  'yaris_blue': 'yaris_blue_2021.jpg',
  'yaris_red': 'yaris_red_2021.jpg',
};

const page = usePage();
const user = page.props.auth.user || null;

const showLoginMessage = ref(false);

function handleReservarClick(bemId) {
  if (!user) {
    showLoginMessage.value = true;
  } else {
    // Proceed with reservation logic or navigation
    // For now, navigate to vehicle details page as placeholder
    window.location.href = route('publico.vehicles.show', bemId);
  }
}

// Helper function to normalize strings: lowercase and replace special chars
function normalizeString(str) {
  return str.toLowerCase().replace(/[^a-z0-9]/g, '');
}

// Function to get image path for a given bem
function getImagePath(bem) {
  const key = `${bem.modelo}_${bem.cor}`;
  const filename = imageMap[key] || null;
  if (filename) {
    return `/vehicles/${filename}`;
  }
  return placeholderImage;
}
</script>

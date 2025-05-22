<!-- Página inicial com destaque das viaturas e call-to-action -->
<template>
  <div>
    <!-- Custom Navbar -->
    <!-- <nav class="flex justify-center p-4 space-x-8 bg-center bg-no-repeat"
     style="background-image: url('/images/autorentix_logo.png'); background-size: cover; width: 100%; height: 100%;">   -->

      <!-- <inertia-link href="/sobre" class="font-semibold text-gray-700 hover:text-blue-600">Sobre</inertia-link>
      <inertia-link href="/viaturas" class="font-semibold text-gray-700 hover:text-blue-600">Viaturas</inertia-link>
      <inertia-link href="/login" class="font-semibold text-gray-700 hover:text-blue-600">Entrar</inertia-link>
      <inertia-link href="/register" class="font-semibold text-gray-700 hover:text-blue-600">Registar</inertia-link> -->
    <!-- </nav> -->

    <!-- Carousel -->
    <section class="max-w-6xl mx-auto my-8">
      <h2 class="mb-4 text-2xl font-bold text-center">Viaturas em Destaque</h2>
      <div class="relative overflow-hidden rounded-lg shadow-lg">
        <div class="flex transition-transform duration-500" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
          <div v-for="(car, index) in cars" :key="index" class="min-w-full">
            <img :src="car.image" :alt="car.name" class="object-cover w-full h-64 rounded-t-lg" />
            <div class="p-4 bg-white rounded-b-lg">
              <h3 class="text-xl font-semibold">{{ car.name }}</h3>
              <p class="text-gray-600">{{ car.description }}</p>
            </div>
          </div>
        </div>
        <button @click="prevSlide" class="absolute p-2 transform -translate-y-1/2 bg-white bg-opacity-75 rounded-full shadow top-1/2 left-2 hover:bg-opacity-100">‹</button>
        <button @click="nextSlide" class="absolute p-2 transform -translate-y-1/2 bg-white bg-opacity-75 rounded-full shadow top-1/2 right-2 hover:bg-opacity-100">›</button>
      </div>
    </section>

    <!-- Comments -->
    <section class="max-w-4xl mx-auto my-8">
      <h2 class="mb-4 text-2xl font-bold text-center">O que dizem os nossos clientes</h2>
      <div class="space-y-6">
        <div v-for="(comment, index) in comments" :key="index" class="p-4 bg-white border rounded shadow-sm">
          <p class="italic">"{{ comment.text }}"</p>
          <p class="mt-2 font-semibold text-right">- {{ comment.author }}</p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="p-6 mt-12 text-gray-700 bg-gray-100">
      <div class="grid max-w-6xl grid-cols-1 gap-8 mx-auto md:grid-cols-4">
        <div>
          <h3 class="mb-2 font-bold">Morada</h3>
          <p>Rua Exemplo, 123<br />Lisboa, Portugal</p>
        </div>
        <div>
          <h3 class="mb-2 font-bold">Contactos</h3>
          <p>Telefone: +351 123 456 789<br />Email: info@autorentix.pt</p>
        </div>
        <div>
          <h3 class="mb-2 font-bold">Redes Sociais</h3>
          <ul class="space-y-1">
            <li><a href="http://facebook.com" class="hover:underline">Facebook</a></li>
            <li><a href="http://instagram.com" class="hover:underline">Instagram</a></li>
          </ul>
        </div>
        <div>
          <h3 class="mb-2 font-bold">Ajuda & Políticas</h3>
          <ul class="space-y-1">
            <li><a href="help" class="hover:underline">Ajuda</a></li>
            <li><a href="complaint" class="hover:underline">Reclamação</a></li>
            <li><a href="terms" class="hover:underline">Termos e Condições</a></li>
            <li><a href="refund" class="hover:underline">Política de Reembolsos</a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

const cars = ref([
  {
    name: 'Fiat 500',
    description: 'Compacto, econômico e perfeito para a cidade.',
    image: '/images/fiat500.jpg',
  },
  {
    name: 'BMW Série 3',
    description: 'Conforto e desempenho para viagens longas.',
    image: '/images/bmw3.jpg',
  },
  {
    name: 'Audi A4',
    description: 'Luxo e tecnologia em cada detalhe.',
    image: '/images/audia4.jpg',
  },
]);

const comments = ref([
  { author: 'João Silva', text: 'Excelente serviço e atendimento!' },
  { author: 'Maria Santos', text: 'Viaturas em ótimo estado e preços justos.' },
  { author: 'Carlos Pereira', text: 'Recomendo a todos que procuram qualidade.' },
]);

const currentSlide = ref(0);

function nextSlide() {
  currentSlide.value = (currentSlide.value + 1) % cars.value.length;
}

function prevSlide() {
  currentSlide.value = (currentSlide.value - 1 + cars.value.length) % cars.value.length;
}
</script>

<template>
  <div class="flex flex-col gap-6 p-6 md:flex-row">
    <!-- Mapa -->
    <div id="map" class="w-full rounded-lg shadow-md md:w-1/2 h-96"></div>

    <!-- Informações de contacto -->
    <div class="w-full md:w-1/2">
      <h1 class="mb-4 text-2xl font-bold">Contactos</h1>
      <p>📧 Email: apoio@autorentix.pt</p>
      <p>📞 Telefone: +351 912 345 678</p>
      <p>📍 Morada: Rua da Mobilidade, nº 12, 1000-000 Lisboa, Portugal</p>

      <br>
      <h2 class="mt-6 text-xl font-semibold">Horário de atendimento:</h2>
      <p>Segunda a Sexta: 09h00 – 18h00</p>

      <p class="mt-4">Estamos aqui para ajudar!</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

import GuestLayout from '@/Layouts/GuestLayout.vue'
defineOptions({ layout: GuestLayout })

onMounted(() => {
  const map = L.map('map').setView([38.736946, -9.142685], 15) // Lisboa

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map)

  L.marker([38.736946, -9.142685])
    .addTo(map)
    .bindPopup('Autorentix - Rua da Mobilidade, nº 12')
    .openPopup()
})
</script>

<style scoped>
/* Corrigir ícones do Leaflet */
.leaflet-container {
  z-index: 0;
}
</style>

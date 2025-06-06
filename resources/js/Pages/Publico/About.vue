<!-- sobre a empresa    -->

<template>
  <div class="about-container">
    <h1>Sobre a AutoRentix</h1>
    <p>Na AutoRentix, acreditamos que alugar um veículo deve ser simples, rápido e acessível.</p>
    <p>Criámos esta plataforma para facilitar a mobilidade de todos, com uma seleção de viaturas que se adapta às tuas necessidades — seja para uma escapadinha de fim de semana, uma viagem de negócios ou uma mudança de casa.</p>
    <p>Trabalhamos com parceiros de confiança para garantir segurança, conforto e qualidade em cada aluguer.</p>
    <p>A nossa missão é tornar a experiência de aluguer mais transparente, digital e centrada no utilizador.</p>
    <p>AutoRentix — a tua mobilidade, simplificada.</p>
  </div>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
defineOptions({ layout: GuestLayout });
</script>

<style scoped>
.about-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  margin-bottom: 20px;
}

p {
  margin-bottom: 15px;
  line-height: 1.6;
}
</style>

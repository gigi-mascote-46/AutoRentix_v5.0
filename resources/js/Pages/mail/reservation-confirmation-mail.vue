<template>
  <div class="container">
    <div class="header">
      <h1>Confirmação de Reserva</h1>
    </div>
    <div class="content">
      <p>Olá, <strong>{{ client }}</strong>!</p>

      <p>Confirmamos com prazer a sua reserva.</p>

      <p><strong>Retirada:</strong> {{ local }}, a partir das 13h.</p>

      <p>Por favor, leve seus documentos de identificação para concluir a locação.</p>

      <p>Agradecemos por escolher nossos serviços! Em caso de dúvidas, estamos à disposição.</p>

      <Link href="/dashboard" class="button">Acesse os detalhes da reserva</Link>
    </div>
    <div class="footer">
      &copy; {{ currentYear }} Empresa AutoRentix. Todos os direitos reservados.
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  client: {
    type: String,
    default: 'Cliente'
  },
  local: {
    type: String,
    default: 'Loja Central'
  }
})

const currentYear = computed(() => new Date().getFullYear())
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  background: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  font-family: Arial, sans-serif;
  color: #333;
  line-height: 1.5;
}
.header {
  background-color: #4f46e5;
  color: white;
  padding: 20px;
  text-align: center;
  border-radius: 8px 8px 0 0;
}
.content {
  padding: 20px;
  background-color: white;
}
.button {
  display: inline-block;
  margin-top: 20px;
  padding: 12px 20px;
  background-color: #4f46e5;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-size: 16px;
}
.footer {
  font-size: 12px;
  color: #777;
  margin-top: 30px;
  text-align: center;
}
</style>

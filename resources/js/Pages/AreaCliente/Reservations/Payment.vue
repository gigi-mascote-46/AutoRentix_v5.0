<template>
  <div class="max-w-4xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Confirme a sua reserva</h1>
    <form @submit.prevent="submitPayment" class="p-6 space-y-6 bg-white rounded shadow">
      <section>
        <h2 class="mb-2 text-xl font-semibold">1. Detalhes do Condutor</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label for="nome" class="block font-medium">Nome*</label>
            <input id="nome" v-model="form.nome" type="text" required class="input" />
          </div>
          <div>
            <label for="apelido" class="block font-medium">Apelido*</label>
            <input id="apelido" v-model="form.apelido" type="text" required class="input" />
          </div>
          <div>
            <label for="data_nascimento" class="block font-medium">Data de Nascimento*</label>
            <input id="data_nascimento" v-model="form.data_nascimento" type="date" required class="input" />
          </div>
          <div>
            <label for="email" class="block font-medium">Email*</label>
            <input id="email" v-model="form.email" type="email" required class="input" />
          </div>
          <div>
            <label for="telefone" class="block font-medium">Número de telefone*</label>
            <input id="telefone" v-model="form.telefone" type="tel" required class="input" />
          </div>
        </div>
      </section>

      <section>
        <h2 class="mb-2 text-xl font-semibold">2. Detalhes de pagamento</h2>
        <div class="p-4 border border-green-400 rounded bg-green-50">
          <p class="mb-2 font-semibold">Método de pagamento</p>
          <div class="mb-4">
            <label class="inline-flex items-center mr-6">
              <input type="radio" class="form-radio" value="paypal" v-model="form.metodo_pagamento" />
              <span class="ml-2">PayPal</span>
            </label>
            <label class="inline-flex items-center mr-6">
              <input type="radio" class="form-radio" value="cartao_credito" v-model="form.metodo_pagamento" />
              <span class="ml-2">Cartão de crédito</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" class="form-radio" value="referencia_multibanco" v-model="form.metodo_pagamento" />
              <span class="ml-2">Referência Multibanco</span>
            </label>
          </div>

          <div v-if="form.metodo_pagamento === 'cartao_credito'">
            <p class="mb-2 font-semibold">Cartão de crédito</p>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <div>
                <label for="cartao_numero" class="block font-medium">Número de cartão*</label>
                <input id="cartao_numero" v-model="form.cartao_numero" type="text" required class="input" />
              </div>
              <div>
                <label for="cartao_validade" class="block font-medium">Data de validade (MM/AA)*</label>
                <input id="cartao_validade" v-model="form.cartao_validade" type="text" required class="input" placeholder="MM/AA" />
              </div>
              <div>
                <label for="cartao_cvv" class="block font-medium">CVV*</label>
                <input id="cartao_cvv" v-model="form.cartao_cvv" type="text" required class="input" />
              </div>
            </div>
            <p class="mt-2 text-sm text-gray-600">
              Para sua segurança, a verificação da sua identidade pode ser solicitada.
            </p>
          </div>

          <div v-if="form.metodo_pagamento === 'paypal'">
            <p class="mb-2 font-semibold">Pagamento via PayPal será processado após a submissão do formulário. (API PayPal precisa ser instalada)</p>
          </div>

          <div v-if="form.metodo_pagamento === 'referencia_multibanco'">
            <p class="mb-2 font-semibold">Referência Multibanco</p>
            <p>Entidade: 12345 (fictícia)</p>
            <p>Referência: 1234 5678 9012 3456 (fictícia)</p>
            <p>Valor: {{ total.toFixed(2) }} €</p>
            <p>Esta é uma fatura pro forma para pagamento via Multibanco.</p>
          </div>
        </div>
      </section>

      <section>
        <h2 class="mb-2 text-xl font-semibold">3. Resumo da reserva</h2>
        <div class="p-4 border rounded">
          <p><strong>Veículo:</strong> {{ bem.modelo }} - {{ bem.marca.nome }}</p>
          <p><strong>Data Início:</strong> {{ dataInicio }}</p>
          <p><strong>Data Fim:</strong> {{ dataFim }}</p>
          <p><strong>Total a pagar:</strong> {{ total.toFixed(2) }} €</p>
        </div>
      </section>

      <div class="flex items-center space-x-4">
        <button type="submit" class="btn btn-primary">Pagar já</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import jsPDF from 'jspdf';
// Removed import of 'route' from 'ziggy-js' due to unresolved import error

// Instead, use global route helper if available or define a fallback
function route(name, params) {
  if (window.route) {
    return window.route(name, params);
  }
  // Fallback: construct URL manually or throw error
  throw new Error('Route helper is not defined');
}


defineOptions({ layout: GuestLayout });

const props = defineProps({
  bem: Object,
  dataInicio: String,
  dataFim: String,
  total: Number,
});

const form = reactive({
  nome: '',
  apelido: '',
  data_nascimento: '',
  email: '',
  telefone: '',
  metodo_pagamento: 'cartao_credito',
  cartao_numero: '',
  cartao_validade: '',
  cartao_cvv: '',
  total: props.total,
});

function generateProformaPDF() {
  const doc = new jsPDF();

  doc.setFontSize(16);
  doc.text('Fatura Pro Forma - Referência Multibanco', 20, 20);

  doc.setFontSize(12);
  doc.text('Entidade: 12345 (fictícia)', 20, 40);
  doc.text('Referência: 1234 5678 9012 3456 (fictícia)', 20, 50);
  doc.text(`Valor: ${form.total.toFixed(2)} €`, 20, 60);
  doc.text('Esta é uma fatura pro forma para pagamento via Multibanco.', 20, 80);

  doc.save('fatura_proforma_multibanco.pdf');
}

const submitPayment = async () => {
    console.log('submitPayment called');

    if (form.metodo_pagamento === 'referencia_multibanco') {
      generateProformaPDF();
    }

    if (form.metodo_pagamento === 'paypal') {
      // Redirect to PayPal transaction creation page
      window.location.href = route('paypal.createTransaction');
      return;
    }

    // For all payment methods except PayPal, send reservation and show success message, then redirect to home
    // Temporary workaround: hardcode the URL to bypass Ziggy route error
    await router.post(`/viaturas/${props.bem.id}/reservar/pagamento`, form);
    alert('Reserva efetuada com sucesso');
    router.visit(route('home'));
  }
</script>

<style scoped>
.input {
  border: 1px solid #ccc;
  padding: 0.5rem;
  border-radius: 0.25rem;
  width: 100%;
}
.btn-primary {
  background-color: #facc15;
  color: #000;
  padding: 0.75rem 1.5rem;
  font-weight: bold;
  border-radius: 0.375rem;
  cursor: pointer;
}
.btn-primary:hover {
  background-color: #eab308;
}
</style>

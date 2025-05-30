<template>
  <div class="max-w-4xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Processando Transação PayPal</h1>
    <p>Você será redirecionado para o PayPal para completar o pagamento...</p>
    <div id="paypal-button-container" class="mt-6"></div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRouter } from '@inertiajs/vue3';

const router = useRouter();

onMounted(() => {
  if (!window.paypal) {
    const script = document.createElement('script');
    script.src = 'https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=EUR';
    script.onload = renderPayPalButtons;
    document.head.appendChild(script);
  } else {
    renderPayPalButtons();
  }
});

function renderPayPalButtons() {
  window.paypal.Buttons({
    createOrder: function (data, actions) {
      // Call backend to create the order
      return fetch(route('paypal.createTransaction'), {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ amount: 1.00 }) // Adjust amount as needed or pass via props
      })
      .then(res => res.json())
      .then(data => {
        if (data.id) {
          return data.id;
        } else {
          alert('Erro ao criar pedido PayPal');
          throw new Error('Erro ao criar pedido PayPal');
        }
      });
    },
    onApprove: function (data, actions) {
      // Capture the order on backend
      return fetch(route('paypal.processTransaction'), {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ token: data.orderID })
      })
      .then(res => res.json())
      .then(response => {
        if (response.status === 'COMPLETED') {
          router.visit(route('paypal.successTransaction', { token: data.orderID }));
        } else {
          alert('Pagamento não completado');
          router.visit(route('paypal.cancelTransaction'));
        }
      });
    },
    onCancel: function (data) {
      alert('Pagamento cancelado');
      router.visit(route('paypal.cancelTransaction'));
    },
    onError: function (err) {
      console.error(err);
      alert('Erro no pagamento PayPal');
      router.visit(route('paypal.cancelTransaction'));
    }
  }).render('#paypal-button-container');
}
</script>

<style scoped>
#paypal-button-container {
  max-width: 400px;
  margin: 0 auto;
}
</style>

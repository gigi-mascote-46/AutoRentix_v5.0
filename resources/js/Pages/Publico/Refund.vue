<template>
  <div class="max-w-3xl p-6 mx-auto bg-white shadow-md dark:bg-gray-900 rounded-xl">
    <h1 class="mb-6 text-2xl font-bold text-green-600">Política de Reembolsos</h1>

    <section class="space-y-4 text-gray-800 dark:text-gray-200">
      <p>
        Na <strong>Autorentix</strong>, comprometemo-nos a proporcionar uma experiência de aluguer de viaturas transparente e justa. Esta política define os termos aplicáveis a pedidos de <strong>reembolso</strong>.
      </p>

      <div>
        <h2 class="text-lg font-semibold text-green-500">1. Cancelamento com Reembolso Total</h2>
        <p>
          O cliente terá direito a um <strong>reembolso total</strong> se cancelar a reserva com pelo menos <strong>48 horas de antecedência</strong> relativamente ao levantamento da viatura.
        </p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-green-500">2. Cancelamento Tardio</h2>
        <ul class="ml-6 list-disc">
          <li>Entre 24h e 48h antes do levantamento: <strong>50% de reembolso</strong></li>
          <li>Menos de 24h: <strong>sem reembolso</strong> (exceto em casos excecionais)</li>
        </ul>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-green-500">3. Faltas de Comparência</h2>
        <p>
          A não comparência no local e hora marcados será considerada uma <strong>desistência</strong>, não havendo lugar a reembolso.
        </p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-green-500">4. Circunstâncias Excecionais</h2>
        <p>
          Poderemos considerar reembolsos totais ou parciais em casos devidamente justificados, como:
        </p>
        <ul class="ml-6 list-disc">
          <li>Doença grave (com comprovativo)</li>
          <li>Problemas mecânicos da viatura imputáveis à Autorentix</li>
          <li>Cancelamento da reserva pela Autorentix</li>
        </ul>
        <p>
          Cada caso será analisado individualmente pela nossa equipa de apoio.
        </p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-green-500">5. Método e Prazos de Reembolso</h2>
        <p>
          Os reembolsos serão processados para o mesmo método de pagamento utilizado. O prazo de processamento é de <strong>5 a 10 dias úteis</strong> após aprovação.
        </p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-green-500">6. Pedido de Reembolso</h2>
        <p>
          Envia um pedido para <strong>suporte@autorentix.pt</strong> com:
        </p>
        <ul class="ml-6 list-disc">
          <li>Nome completo</li>
          <li>Referência da reserva</li>
          <li>Motivo do pedido</li>
          <li>Documentação justificativa (se aplicável)</li>
        </ul>
      </div>

      <p class="text-sm italic text-gray-500 dark:text-gray-400">
        Nota: Esta política pode ser atualizada sem aviso prévio. Consulta regularmente esta página para te manteres informado.
      </p>
    </section>
  </div>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })
</script>

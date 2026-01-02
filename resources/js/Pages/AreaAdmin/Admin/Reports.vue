<!-- Relatórios e exportações (PDF/Excel) -->
<template>
  <div>
    <h1>Relatórios</h1>

    <!-- Filters Section -->
    <div class="flex flex-wrap gap-4 mt-4 print:hidden">
      <select v-model="filters.month" class="p-2 border rounded">
        <option value="">Mês</option>
        <option v-for="m in months" :key="m.value" :value="m.value">{{ m.text }}</option>
      </select>

      <select v-model="filters.year" class="p-2 border rounded">
        <option value="">Ano</option>
        <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
      </select>

      <select v-model="filters.brand" class="p-2 border rounded">
        <option value="">Marca</option>
        <option v-for="brand in brands" :key="brand.id" :value="brand.name">{{ brand.name }}</option>
      </select>

      <input type="date" v-model="filters.date" class="p-2 border rounded" placeholder="Data" />

      <button @click="applyFilters" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
        Filtrar
      </button>

      <button @click="resetFilters" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
        Limpar
      </button>

      <!-- Export and Print Buttons -->
      <button @click="printReport" title="Imprimir" class="p-2 ml-auto hover:text-gray-700" aria-label="Imprimir">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12v4H6v-4z" />
        </svg>
      </button>

      <button @click="exportPDF" title="Exportar PDF" class="p-2 hover:text-gray-700" aria-label="Exportar PDF">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4v16m8-8H4" />
        </svg>
      </button>

      <button @click="exportExcel" title="Exportar Excel" class="p-2 hover:text-gray-700" aria-label="Exportar Excel">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 4h16v16H4V4zM8 8h8M8 12h8M8 16h8" />
        </svg>
      </button>
    </div>

    <div class="grid grid-cols-2 gap-6 mt-8">
      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="mb-2 text-lg font-semibold">Total de Receita (€)</h2>
        <p class="text-3xl">{{ filteredReports.totalReceita.toFixed(2) }}</p>
      </div>

      <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="mb-2 text-lg font-semibold">Total de Reservas</h2>
        <p class="text-3xl">{{ filteredReports.totalReservas }}</p>
      </div>

      <div class="col-span-2 p-4 bg-gray-100 rounded shadow">
        <h2 class="mb-2 text-lg font-semibold">Reservas por Mês</h2>
        <ul class="list-disc list-inside">
          <li v-for="(count, mes) in filteredReports.reservasPorMes" :key="mes">
            {{ mes }}: {{ count }} reservas
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';

defineOptions({ layout: AdminLayout });

const props = defineProps({
  reports: {
    type: Object,
    required: true,
  },
  brands: {
    type: Array,
    default: () => [],
  },
});

const filters = ref({
  month: new URLSearchParams(window.location.search).get('month') || '',
  year: new URLSearchParams(window.location.search).get('year') || '',
  brand: new URLSearchParams(window.location.search).get('brand') || '',
  date: new URLSearchParams(window.location.search).get('date') || '',
});

const months = [
  { value: '01', text: 'Janeiro' },
  { value: '02', text: 'Fevereiro' },
  { value: '03', text: 'Março' },
  { value: '04', text: 'Abril' },
  { value: '05', text: 'Maio' },
  { value: '06', text: 'Junho' },
  { value: '07', text: 'Julho' },
  { value: '08', text: 'Agosto' },
  { value: '09', text: 'Setembro' },
  { value: '10', text: 'Outubro' },
  { value: '11', text: 'Novembro' },
  { value: '12', text: 'Dezembro' },
];

const currentYear = new Date().getFullYear();
const years = [];
for (let y = currentYear; y >= currentYear - 10; y--) {
  years.push(y);
}

const filteredReports = computed(() => props.reports);

function applyFilters() {
  router.get(route(route().current()), filters.value, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
}

function resetFilters() {
  filters.value = {
    month: '',
    year: '',
    brand: '',
    date: '',
  };
  applyFilters();
}

function printReport() {
  window.print();
}

function exportPDF() {
  const doc = new jsPDF();
  doc.text('Relatório', 14, 20);

  const rows = Object.entries(filteredReports.value.reservasPorMes).map(([mes, count]) => [mes, count.toString()]);

  autoTable(doc, {
    head: [['Mês', 'Reservas']],
    body: rows,
    startY: 30,
  });

  doc.save('relatorio.pdf');
}

function exportExcel() {
  const ws_data = [
    ['Mês', 'Reservas'],
    ...Object.entries(filteredReports.value.reservasPorMes),
  ];
  const ws = XLSX.utils.aoa_to_sheet(ws_data);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Relatório');
  XLSX.writeFile(wb, 'relatorio.xlsx');
}
</script>

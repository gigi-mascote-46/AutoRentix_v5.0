<!-- Criar nova viatura -->
<template>
  <div>
    <h1>Criar Nova Viatura</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="marca_id">Marca:</label>
        <select v-model="form.marca_id" id="marca_id" required>
          <option disabled value="">Seleciona uma marca</option>
          <option v-for="marca in marcas" :key="marca.id" :value="marca.id">
            {{ marca.nome }}
          </option>
        </select>
      </div>

      <div>
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" v-model="form.modelo" required maxlength="100" />
      </div>

      <div>
        <label for="registo_unico_publico">Registo Único Público:</label>
        <input type="text" id="registo_unico_publico" v-model="form.registo_unico_publico" required maxlength="20" />
      </div>

      <div>
        <label for="cor">Cor:</label>
        <input type="text" id="cor" v-model="form.cor" required maxlength="20" />
      </div>

      <div>
        <label for="numero_passageiros">Número de Passageiros:</label>
        <input type="number" id="numero_passageiros" v-model="form.numero_passageiros" min="1" required />
      </div>

      <div>
        <label for="combustivel">Combustível:</label>
        <select v-model="form.combustivel" id="combustivel" required>
          <option disabled value="">Seleciona um combustível</option>
          <option value="gasolina">Gasolina</option>
          <option value="diesel">Diesel</option>
          <option value="elétrico">Elétrico</option>
          <option value="híbrido">Híbrido</option>
          <option value="outro">Outro</option>
        </select>
      </div>

      <div>
        <label for="numero_portas">Número de Portas:</label>
        <input type="number" id="numero_portas" v-model="form.numero_portas" min="1" required />
      </div>

      <div>
        <label for="transmissao">Transmissão:</label>
        <select v-model="form.transmissao" id="transmissao" required>
          <option disabled value="">Seleciona uma transmissão</option>
          <option value="manual">Manual</option>
          <option value="automática">Automática</option>
        </select>
      </div>

      <div>
        <label for="ano">Ano:</label>
        <input type="number" id="ano" v-model="form.ano" min="1900" :max="new Date().getFullYear() + 1" required />
      </div>

      <div>
        <label for="manutencao">Em Manutenção:</label>
        <input type="checkbox" id="manutencao" v-model="form.manutencao" />
      </div>

      <div>
        <label for="preco_diario">Preço Diário (€):</label>
        <input type="number" id="preco_diario" v-model="form.preco_diario" min="0" step="0.01" required />
      </div>

      <div>
        <label for="observacao">Observação:</label>
        <textarea id="observacao" v-model="form.observacao" maxlength="200"></textarea>
      </div>

      <button type="submit">Criar</button>
    </form>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  marcas: Array,
});

const form = useForm({
  marca_id: '',
  modelo: '',
  registo_unico_publico: '',
  cor: '',
  numero_passageiros: 1,
  combustivel: '',
  numero_portas: 1,
  transmissao: '',
  ano: new Date().getFullYear(),
  manutencao: false,
  preco_diario: 0,
  observacao: '',
});

function submit() {
  form.post(route('admin.vehicles.store'));
}
</script>

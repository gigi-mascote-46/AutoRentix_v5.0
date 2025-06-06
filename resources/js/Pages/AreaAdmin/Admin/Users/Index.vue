<template>
  <div>
    <!-- Título da página -->
    <h1>Lista de Utilizadores</h1>

    <!-- Tabela que apresenta a lista de utilizadores -->
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <!-- Cabeçalho da tabela com os nomes das colunas -->
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Nome</th>
          <th class="px-4 py-2 border border-gray-300">Email</th>
          <th class="px-4 py-2 border border-gray-300">Admin</th>
          <th class="px-4 py-2 border border-gray-300">Criado em</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop para percorrer todos os utilizadores passados como prop -->
        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">

          <!-- Mostra o ID do utilizador -->
          <td class="px-4 py-2 border border-gray-300">{{ user.id }}</td>

          <!-- Mostra o nome do utilizador -->
          <td class="px-4 py-2 border border-gray-300">{{ user.name }}</td>

          <!-- Mostra o email do utilizador -->
          <td class="px-4 py-2 border border-gray-300">{{ user.email }}</td>

          <!-- Verifica se o utilizador é administrador (is_admin true) e mostra "Sim" ou "Não" -->
          <td class="px-4 py-2 border border-gray-300">{{ user.is_admin ? 'Sim' : 'Não' }}</td>

          <!-- Mostra a data em que o utilizador foi criado, formatada de forma legível -->
          <td class="px-4 py-2 border border-gray-300">{{ new Date(user.created_at).toLocaleDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
// Importo o layout de administrador para aplicar a estrutura padrão do painel de administração
import AdminLayout from '@/Layouts/AdminLayout.vue';

// Aplico esse layout ao componente atual
defineOptions({ layout: AdminLayout });

// Defino a propriedade 'users', que será um array com os dados dos utilizadores
defineProps({
  users: Array,
});
</script>

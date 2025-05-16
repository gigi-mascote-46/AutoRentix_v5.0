<template>
  <div>
    <h1>Admin - Lista de Utilizadores</h1>
    <table class="min-w-full border border-collapse border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border border-gray-300">ID</th>
          <th class="px-4 py-2 border border-gray-300">Nome</th>
          <th class="px-4 py-2 border border-gray-300">Email</th>
          <th class="px-4 py-2 border border-gray-300">Admin</th>
          <th class="px-4 py-2 border border-gray-300">Criado em</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
          <td class="px-4 py-2 border border-gray-300">{{ user.id }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ user.name }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ user.email }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ user.is_admin ? 'Sim' : 'Não' }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ new Date(user.created_at).toLocaleDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
  users: Array,
});
</script>

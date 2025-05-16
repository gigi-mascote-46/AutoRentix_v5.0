<template>
  <div class="flex flex-col min-h-screen">
    <!-- Cabeçalho -->
    <header class="flex items-center justify-between p-4 text-white bg-gray-800">
      <h1 class="text-xl font-bold">AutoRentix - Admin</h1>
      <nav>
        <button @click="logout" class="hover:underline">Sair</button>
      </nav>
    </header>

    <div class="flex flex-1">
      <!-- Sidebar -->
      <aside class="w-64 p-4 bg-gray-100 border-r border-gray-300">
        <nav class="space-y-2">
          <inertia-link href="/admin/viaturas" class="block px-2 py-1 rounded hover:bg-gray-300" :class="{ 'bg-gray-300 font-semibold': isActive('/admin/viaturas') }">Viaturas</inertia-link>
          <inertia-link href="/admin/utilizadores" class="block px-2 py-1 rounded hover:bg-gray-300" :class="{ 'bg-gray-300 font-semibold': isActive('/admin/utilizadores') }">Utilizadores</inertia-link>
          <inertia-link href="/admin/reservas" class="block px-2 py-1 rounded hover:bg-gray-300" :class="{ 'bg-gray-300 font-semibold': isActive('/admin/reservas') }">Reservas</inertia-link>
          <inertia-link href="/admin/pagamentos" class="block px-2 py-1 rounded hover:bg-gray-300" :class="{ 'bg-gray-300 font-semibold': isActive('/admin/pagamentos') }">Pagamentos</inertia-link>
          <inertia-link href="/admin/relatorios" class="block px-2 py-1 rounded hover:bg-gray-300" :class="{ 'bg-gray-300 font-semibold': isActive('/admin/relatorios') }">Relatórios</inertia-link>
        </nav>
      </aside>

      <!-- Conteúdo principal -->
      <main class="flex-1 p-6 bg-white">
        <slot />
      </main>
    </div>

    <!-- Rodapé -->
    <footer class="p-4 text-sm text-center bg-gray-200 border-t border-gray-300">
      &copy; {{ new Date().getFullYear() }} AutoRentix. Todos os direitos reservados.
    </footer>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const page = usePage();

function logout() {
  if (confirm('Deseja terminar a sessão?')) {
    Inertia.post(route('logout'));
  }
}

const isActive = (path) => {
  return page.url.startsWith(path);
};
</script>

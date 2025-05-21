<template>
  <div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-white shadow">
      <inertia-link href="/" class="text-2xl font-bold text-blue-600">AutoRentix</inertia-link>

      <nav class="space-x-4">
        <inertia-link href="/" class="hover:text-blue-600">Home</inertia-link>
        <inertia-link href="/viaturas" class="hover:text-blue-600">Viaturas</inertia-link>
        <inertia-link href="/sobre" class="hover:text-blue-600">Sobre</inertia-link>
        <inertia-link href="/contacto" class="hover:text-blue-600">Contacto</inertia-link>

        <template v-if="!user">
          <inertia-link href="/login" class="font-semibold text-blue-600 hover:underline">Entrar</inertia-link>
          <inertia-link href="/register" class="font-semibold text-blue-600 hover:underline">Registar</inertia-link>
        </template>

        <template v-else>
          <inertia-link href="/dashboard" class="font-semibold text-blue-600 hover:underline">Dashboard</inertia-link>
          <button @click="logout" class="text-red-600 hover:underline">Sair</button>
        </template>
      </nav>
    </header>

    <!-- Main content -->
    <main class="flex-grow p-6 mx-auto max-w-7xl">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="p-4 text-sm text-center text-gray-600 bg-gray-100">
      &copy; {{ new Date().getFullYear() }} AutoRentix. Todos os direitos reservados.
    </footer>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const page = usePage();
const user = page.props?.auth?.user || null;

function logout() {
  if (confirm('Deseja terminar a sessão?')) {
    Inertia.post(route('logout'));
  }
}
</script>

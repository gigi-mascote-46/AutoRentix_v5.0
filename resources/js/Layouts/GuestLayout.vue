<template>
  <div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-white shadow">
      <Link href="/" class="text-2xl font-bold text-blue-600">AutoRentix</Link>

      <nav class="space-x-4">
        <Link href="/" class="hover:text-blue-600">Home</Link>
        <Link href="/viaturas" class="hover:text-blue-600">Viaturas</Link>
        <Link href="/sobre" class="hover:text-blue-600">Sobre</Link>
        <Link href="/contacto" class="hover:text-blue-600">Contacto</Link>

        <template v-if="!user">
          <Link href="/login" class="font-semibold text-blue-600 hover:underline">Entrar</Link>
          <Link href="/register" class="font-semibold text-blue-600 hover:underline">Registar</Link>
        </template>

        <template v-else>
          <Link href="/areacliente/dashboard" class="font-semibold text-blue-600 hover:underline">Dashboard</Link>
          <button @click="logout" class="text-red-600 hover:underline">Sair</button>
        </template>
      </nav>
    </header>

    <!-- Main content -->
    <main class="flex-grow w-full p-6">
      <slot />
    </main>

    <!-- Footer -->

    <footer class="p-4 text-sm text-center text-gray-600 bg-gray-100">
      &copy; {{ new Date().getFullYear() }} AutoRentix. Todos os direitos reservados.
    </footer>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const page = usePage();
const user = page.props?.auth?.user || null;

function logout() {
  if (confirm('Deseja terminar a sessão?')) {
    Inertia.post(route('logout'));
  }
}
</script>

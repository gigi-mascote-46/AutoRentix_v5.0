<!-- layout generico para auth  -->

<template>
  <div class="flex flex-col items-center justify-center min-h-screen px-4 bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded shadow-md">
      <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-blue-600">AutoRentix</h1>
        <p class="mt-1 text-sm text-gray-500">Gestão de reservas e viaturas</p>
      </div>

      <slot />
    </div>
    <p class="mt-6 text-sm text-center text-gray-500">
      &copy; {{ new Date().getFullYear() }} AutoRentix. Todos os direitos reservados.
    </p>
  </div>
</template>


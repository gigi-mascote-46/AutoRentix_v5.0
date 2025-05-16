<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        Estas logado!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <div class="max-w-sm p-5 mx-auto">
      @if (session('success'))
         <div
            class="px-6 py-4 font-semibold text-green-800 bg-green-100 rounded-lg shadow-lg alert alert-success ring-1 ring-green-300">
            {{ session('success') }}
         </div>
      @endif

      <form action="{{ route('send.email') }}" method="POST" class="flex flex-col items-center p-2 mt-5 space-y-2 bg-gray-100 border-2 border-gray-500 rounded-lg shadow-lg">
      @csrf
         <label for="pickup" class="text-lg font-medium text-gray-700">Local de levantamento da reserva:</label>
         <input type="text" id="pickup" name="pickup" required
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
         <button type="submit"
            class="px-8 py-3 text-base font-medium text-white transition duration-300 bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 md:text-lg hover:shadow-lg">
            Enviar confirmação por e-mail
         </button>
      </form>
   </div>
</template>

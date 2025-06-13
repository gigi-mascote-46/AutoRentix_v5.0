<template>
    <GuestLayout>
        <div class="px-4 py-8 mx-auto max-w-7xl">
            <h1 class="mb-6 text-3xl font-bold">Viaturas Disponíveis</h1>

            <!-- Filtros -->
            <form @submit.prevent="applyFilters" class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-5">
                <select v-model="localFilters.tipo_bem_id" class="p-2 border rounded">
                    <option value="">Tipo de Veículo</option>
                    <option v-for="type in filters.types" :key="type.id" :value="type.id">{{ type.nome }}</option>
                </select>

                <select v-model="localFilters.marca_id" class="p-2 border rounded">
                    <option value="">Marca</option>
                    <option v-for="brand in filters.brands" :key="brand.id" :value="brand.id">{{ brand.nome }}</option>
                </select>

                <select v-model="localFilters.localizacao_id" class="p-2 border rounded">
                    <option value="">Localização</option>
                    <option v-for="loc in filters.locations" :key="loc.cidade" :value="loc.cidade">
                        {{ loc.cidade }}
                    </option>
                </select>

                <input v-model="localFilters.search" type="text" placeholder="Pesquisar..."
                    class="p-2 border rounded" />
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    Filtrar
                </button>
            </form>

            <!-- Mensagem de erro -->
            <div v-if="error" class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                {{ error }}
            </div>

            <!-- Grelha de veículos -->
            <div v-if="vehicles.data && vehicles.data.length > 0" class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div v-for="vehicle in vehicles.data" :key="vehicle.id"
                    class="flex flex-col p-4 bg-white rounded shadow">
                    <img :src="vehicle.foto_url || '/images/placeholder-car.jpg'" :alt="vehicle.modelo"
                        class="object-cover w-full h-48 mb-4 rounded" />
                    <h2 class="mb-1 text-xl font-semibold">{{ vehicle.modelo }}</h2>
                    <p class="mb-1 text-gray-600">{{ vehicle.marca?.nome }}</p>
                    <p class="mb-1 text-gray-500">{{ vehicle.localizacao?.cidade }}</p>
                    <p class="mb-2 font-bold text-blue-700">{{ Number(vehicle.preco_por_dia).toFixed(2) }} €/dia</p>
                    <Link :href="`/vehicles/${vehicle.id}`"
                        class="inline-block px-4 py-2 mt-auto text-white bg-blue-600 rounded hover:bg-blue-700">
                    Ver detalhes
                    </Link>
                </div>
            </div>
            <div v-else class="py-12 text-center text-gray-500">
                Nenhum veículo encontrado.
            </div>

            <!-- Paginação -->
            <div v-if="vehicles.meta && vehicles.meta.links && vehicles.meta.links.length > 3"
                class="flex justify-center mt-8 space-x-2">
                <button v-for="link in vehicles.meta.links" :key="link.label" :disabled="!link.url"
                    @click="goToPage(link.url)" v-html="link.label" :class="[
                        'px-3 py-1 rounded',
                        link.active ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700',
                        !link.url ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-100'
                    ]" />
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const props = defineProps({
    vehicles: { type: Object, required: true },
    filters: { type: Object, required: true },
    queryParams: { type: Object, default: () => ({}) },
    error: { type: String, default: '' }
})

// Filtros locais (para o formulário)
const localFilters = reactive({
    tipo_bem_id: props.queryParams.tipo_bem_id || '',
    marca_id: props.queryParams.marca_id || '',
    localizacao_id: props.queryParams.localizacao_id || '',
    search: props.queryParams.search || ''
})

// Aplicar filtros
function applyFilters() {
    router.get('/vehicles', {
        ...localFilters
    }, { preserveState: true, preserveScroll: true })
}

// Paginação
function goToPage(url) {
    router.visit(url, { preserveState: true, preserveScroll: true })
}
</script>

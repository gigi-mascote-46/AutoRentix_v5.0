<template>
  <GuestLayout>
    <div class="min-h-screen bg-gray-50">
      <!-- Header Section -->
      <div class="bg-white shadow-sm">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="mb-4 text-3xl font-bold text-gray-900">
              Nossa Frota de Veículos
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">
              Descubra a viatura perfeita para a sua próxima aventura
            </p>
          </div>
        </div>
      </div>

      <!-- Filters Section -->
      <div class="bg-white border-b">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <form @submit.prevent="applyFilters" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Type Filter -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">
                Tipo de Veículo
              </label>
              <select
                v-model="filters.tipo_bem_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Todos os tipos</option>
                <option
                  v-for="type in filterOptions.tiposBem"
                  :key="type.id"
                  :value="type.id"
                >
                  {{ type.nome }}
                </option>
              </select>
            </div>

            <!-- Location Filter -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">
                Localização
              </label>
              <select
                v-model="filters.localizacao_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Todas as localizações</option>
                <option
                  v-for="location in filterOptions.localizacoes"
                  :key="location.id"
                  :value="location.id"
                >
                  {{ location.cidade }}
                </option>
              </select>
            </div>

            <!-- Price Range -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">
                Preço Máximo (€/dia)
              </label>
              <input
                type="number"
                v-model="filters.preco_max"
                placeholder="Ex: 50"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
            </div>

            <!-- Search -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">
                Pesquisar
              </label>
              <div class="flex">
                <input
                  type="text"
                  v-model="filters.search"
                  placeholder="Nome ou descrição..."
                  class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                <button
                  type="submit"
                  class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-r-md hover:bg-blue-700"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </form>

          <!-- Clear Filters -->
          <div class="flex items-center justify-between mt-4">
            <button
              @click="clearFilters"
              class="text-sm text-gray-600 hover:text-gray-900"
            >
              Limpar filtros
            </button>
            <div class="text-sm text-gray-600">
              {{ vehicles.total || 0 }} veículo(s) encontrado(s)
            </div>
          </div>
        </div>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded">
          {{ error }}
        </div>
      </div>

      <!-- Vehicles Grid -->
      <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div v-if="vehicles.data && vehicles.data.length > 0" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <div
            v-for="vehicle in vehicles.data"
            :key="vehicle.id"
            class="overflow-hidden transition-shadow duration-200 bg-white rounded-lg shadow-md hover:shadow-lg"
          >
            <!-- Vehicle Image -->
            <div class="bg-gray-200 aspect-w-16 aspect-h-9">
              <img
                :src="vehicle.first_photo || '/images/default-vehicle.jpg'"
                :alt="vehicle.nome"
                class="object-cover w-full h-48"
                @error="handleImageError"
              >
            </div>

            <!-- Vehicle Info -->
            <div class="p-4">
              <div class="flex items-start justify-between mb-2">
                <h3 class="text-lg font-semibold text-gray-900 truncate">
                  {{ vehicle.nome }}
                </h3>
                <span class="text-lg font-bold text-blue-600">
                  {{ formatPrice(vehicle.preco_por_dia) }}€/dia
                </span>
              </div>

              <div class="mb-4 space-y-1 text-sm text-gray-600">
                <div v-if="vehicle.marca">
                  <span class="font-medium">Marca:</span> {{ vehicle.marca.nome }}
                </div>
                <div v-if="vehicle.tipo_bem">
                  <span class="font-medium">Tipo:</span> {{ vehicle.tipo_bem.nome }}
                </div>
                <div v-if="vehicle.localizacao">
                  <span class="font-medium">Local:</span> {{ vehicle.localizacao.nome }}
                </div>
              </div>

              <!-- Action Button -->
              <Link
                :href="route('vehicles.show', vehicle.id)"
                class="block w-full px-4 py-2 font-medium text-center text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700"
              >
                Ver Detalhes
              </Link>
            </div>
          </div>
        </div>

        <!-- No Results -->
        <div v-else class="py-12 text-center">
          <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.881-6.08-2.33.893-.533 1.928-.84 3.08-.84.974 0 1.888.22 2.7.613M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum veículo encontrado</h3>
          <p class="mt-1 text-sm text-gray-500">Tente ajustar os filtros de pesquisa.</p>
        </div>

        <!-- Pagination -->
        <div v-if="vehicles.data && vehicles.data.length > 0 && vehicles.last_page > 1" class="mt-8">
          <nav class="flex justify-center">
            <div class="flex space-x-2">
              <Link
                v-if="vehicles.prev_page_url"
                :href="vehicles.prev_page_url"
                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
              >
                Anterior
              </Link>

              <span class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md">
                Página {{ vehicles.current_page }} de {{ vehicles.last_page }}
              </span>

              <Link
                v-if="vehicles.next_page_url"
                :href="vehicles.next_page_url"
                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
              >
                Próxima
              </Link>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

// Props
const props = defineProps({
  vehicles: {
    type: Object,
    default: () => ({ data: [], total: 0 })
  },
  filters: {
    type: Object,
    default: () => ({
      tiposBem: [],
      marcas: [],
      localizacoes: [],
      caracteristicas: []
    })
  },
  queryParams: {
    type: Object,
    default: () => ({})
  },
  error: String
})

// Reactive data
const filters = reactive({
  tipo_bem_id: props.queryParams.tipo_bem_id || '',
  localizacao_id: props.queryParams.localizacao_id || '',
  preco_max: props.queryParams.preco_max || '',
  search: props.queryParams.search || ''
})

const filterOptions = reactive({
  tiposBem: props.filters.tiposBem || [],
  marcas: props.filters.marcas || [],
  localizacoes: props.filters.localizacoes || [],
  caracteristicas: props.filters.caracteristicas || []
})

// Methods
  const applyFilters = () => {
    const params = {}

    Object.keys(filters).forEach(key => {
      if (filters[key]) {
        params[key] = filters[key]
      }
    })

    router.get('/viaturas', params, {
      preserveState: true,
      preserveScroll: true
    })
  }

  const clearFilters = () => {
    Object.keys(filters).forEach(key => {
      filters[key] = ''
    })

    router.get('/viaturas', {}, {
      preserveState: true,
      preserveScroll: true
    })
  }

const formatPrice = (price) => {
  return parseFloat(price).toFixed(2).replace('.', ',')
}

const handleImageError = (event) => {
  event.target.src = '/images/default-vehicle.jpg'
}
</script>

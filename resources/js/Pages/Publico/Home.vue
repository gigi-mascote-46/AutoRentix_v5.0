<template>
  <GuestLayout>
    <div class="min-h-screen bg-gradient-to-br from-blue-500 to-blue-700">
      <!-- Hero Section -->
      <div class="relative overflow-hidden">
        <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:py-24">
          <div class="grid items-center grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
            <!-- Left Column with Headline and CTA -->
            <div class="space-y-6 text-white">
              <h1 class="text-4xl font-bold leading-tight lg:text-5xl xl:text-6xl">
                Rent the <span class="text-yellow-300">perfect</span> vehicle for your trip
              </h1>
              <p class="max-w-lg text-lg text-blue-100 lg:text-xl">
                Discover our premium fleet and enjoy an unforgettable driving experience.
              </p>
              <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                <Link
                  :href="vehiclesIndexUrl"
                  class="inline-flex items-center justify-center px-8 py-3 font-semibold text-blue-900 transition-colors duration-200 bg-yellow-400 rounded-lg hover:bg-yellow-500"
                >
                Vehicles
                </Link>
                <Link
                  :href=('/public/about')
                  class="inline-flex items-center justify-center px-8 py-3 font-semibold text-white transition-colors duration-200 border-2 border-white rounded-lg hover:bg-white hover:text-blue-700"
                >
                  Learn More
                </Link>
              </div>
            </div>

            <!-- Right Column with Search Form -->
            <div class="w-full max-w-md mx-auto lg:mx-0 lg:max-w-none">
              <div class="p-6 bg-white shadow-2xl rounded-xl lg:p-8">
                <h3 class="mb-6 text-xl font-semibold text-gray-900">
                  Vehicle?
                </h3>
                <form @submit.prevent="searchVehicles" class="space-y-4">
                  <!-- Location Selector -->
                  <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                    <select
                      v-model="searchForm.localizacao_id"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                      <option value="">Select a location</option>
                      <option v-for="location in locations" :key="location.id" :value="location.id">
                        {{ location.nome }}
                      </option>
                    </select>
                  </div>

                  <!-- Vehicle Type Selector -->
                  <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Vehicle Type</label>
                    <select
                      v-model="searchForm.tipo_bem_id"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                      <option value="">All types</option>
                      <option v-for="type in vehicleTypes" :key="type.id" :value="type.id">
                        {{ type.nome }}
                      </option>
                    </select>
                  </div>

                  <!-- Date Range -->
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="block mb-2 text-sm font-medium text-gray-700">Start Date</label>
                      <input
                        type="date"
                        v-model="searchForm.data_inicio"
                        :min="today"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                    </div>
                    <div>
                      <label class="block mb-2 text-sm font-medium text-gray-700">End Date</label>
                      <input
                        type="date"
                        v-model="searchForm.data_fim"
                        :min="searchForm.data_inicio || today"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                    </div>
                  </div>

                  <!-- Search Button -->
                  <button
                    type="submit"
                    class="flex items-center justify-center w-full px-6 py-3 font-semibold text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700"
                  >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search Vehicles
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Features Section -->
      <div class="py-16 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="mb-12 text-center">
            <h2 class="mb-4 text-3xl font-bold text-gray-900">Why Choose AutoRentix?</h2>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">
              We offer the best car rental experience with premium service and competitive prices.
            </p>
          </div>

          <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Feature: Quality -->
            <div class="p-6 text-center">
              <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 class="mb-2 text-xl font-semibold text-gray-900">Guaranteed Quality</h3>
              <p class="text-gray-600">All our vehicles are inspected and maintained to the highest standards.</p>
            </div>

            <!-- Feature: Pricing -->
            <div class="p-6 text-center">
              <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
              </div>
              <h3 class="mb-2 text-xl font-semibold text-gray-900">Competitive Pricing</h3>
              <p class="text-gray-600">We offer the best prices in the market without compromising on service quality.</p>
            </div>

            <!-- Feature: Support -->
            <div class="p-6 text-center">
              <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 109.75 9.75A9.75 9.75 0 0012 2.25z" />
                </svg>
              </div>
              <h3 class="mb-2 text-xl font-semibold text-gray-900">24/7 Support</h3>
              <p class="text-gray-600">Our team is available around the clock to assist you in any situation.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineProps({
  locations: Array,
  vehicleTypes: Array,
  vehiclesIndexUrl: String,
  aboutUrl: String
})

const searchForm = ref({
  localizacao_id: '',
  tipo_bem_id: '',
  data_inicio: '',
  data_fim: ''
})

const today = computed(() => new Date().toISOString().split('T')[0])

const searchVehicles = () => {
  const params = {}

  if (searchForm.value.localizacao_id) params.localizacao_id = searchForm.value.localizacao_id
  if (searchForm.value.tipo_bem_id) params.tipo_bem_id = searchForm.value.tipo_bem_id
  if (searchForm.value.data_inicio) params.data_inicio = searchForm.value.data_inicio
  if (searchForm.value.data_fim) params.data_fim = searchForm.value.data_fim

  router.get('public.vehicles.index', params)
}
</script>

<template>
    <div class="min-h-screen bg-admin-background">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out transform bg-white shadow-strong lg:translate-x-0"
             :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-admin-primary">
                <div class="flex items-center space-x-2">
                    <div class="flex items-center justify-center w-8 h-8 bg-white rounded-lg">
                        <svg class="w-5 h-5 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-white">Admin Panel</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-4 mt-8">
                <div class="space-y-2">
                    <Link :href="route('admin.dashboard')"
                          :class="route().current('admin.dashboard') ? 'nav-link-admin-active' : 'nav-link-admin-inactive'"
                          class="flex items-center w-full space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7z" />
                        </svg>
                        <span>Dashboard</span>
                    </Link>

                    <Link :href="route('admin.vehicles.index')"
                          :class="route().current('admin.vehicles.*') ? 'nav-link-admin-active' : 'nav-link-admin-inactive'"
                          class="flex items-center w-full space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Viaturas</span>
                    </Link>

                    <Link :href="route('admin.reservations.index')"
                          :class="route().current('admin.reservations.*') ? 'nav-link-admin-active' : 'nav-link-admin-inactive'"
                          class="flex items-center w-full space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Reservas</span>
                    </Link>

                    <Link :href="route('admin.users.index')"
                          :class="route().current('admin.users.*') ? 'nav-link-admin-active' : 'nav-link-admin-inactive'"
                          class="flex items-center w-full space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <span>Utilizadores</span>
                    </Link>

                    <Link :href="route('admin.payments.index')"
                          :class="route().current('admin.payments.*') ? 'nav-link-admin-active' : 'nav-link-admin-inactive'"
                          class="flex items-center w-full space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Pagamentos</span>
                    </Link>

                    <Link :href="route('admin.reports')"
                          :class="route().current('admin.reports') ? 'nav-link-admin-active' : 'nav-link-admin-inactive'"
                          class="flex items-center w-full space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Relatórios</span>
                    </Link>
                </div>

                <div class="pt-8 mt-8 border-t border-gray-200">
                    <Link :href="route('home')" class="flex items-center w-full space-x-3 nav-link-admin-inactive">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Voltar ao Site</span>
                    </Link>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Navigation -->
            <div class="sticky top-0 z-40 flex items-center h-16 px-4 bg-white border-b border-gray-200 shadow-sm shrink-0 gap-x-4 sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = !sidebarOpen">
                    <span class="sr-only">Abrir sidebar</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="w-px h-6 bg-gray-200 lg:hidden" aria-hidden="true"></div>

                <div class="flex self-stretch flex-1 gap-x-4 lg:gap-x-6">
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Page title -->
                        <h1 class="text-xl font-semibold text-admin-text" v-if="$slots.header">
                            <slot name="header" />
                        </h1>
                    </div>
                    <div class="flex items-center ml-auto gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center space-x-2 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-admin-primary">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-admin-primary">
                                            <span class="text-sm font-medium text-white">
                                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                            </span>
                                        </div>
                                        <span class="font-medium text-admin-text">{{ $page.props.auth.user.name }}</span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
</template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">Perfil</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Sair
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { Link, Dropdown, DropdownLink } from '@inertiajs/vue3';
</script>

<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import AppFooter from '@/Components/AppFooter.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-[#f5faf6] text-slate-800 flex flex-col">
        <nav class="sticky top-0 z-40 border-b border-green-100 bg-white/90 backdrop-blur-xl shadow-sm shadow-green-900/5">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 justify-between">
                    <div class="flex items-center">
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('dashboard')" class="group flex items-center gap-3 transition hover:scale-105">
                                <img src="/images/lumira.png" alt="LUMIRA" class="h-12 w-12" />
                                <div class="hidden sm:block">
                                    <p class="text-lg font-black tracking-wide text-[#0b2617]">LUMIRA</p>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-500">Layanan Ulang Material</p>
                                </div>
                            </Link>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <div class="relative ms-3">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-full">
                                        <button type="button" class="inline-flex items-center rounded-full border border-green-100 bg-[#f4faf5] px-4 py-2 text-sm font-semibold leading-4 text-slate-700 transition hover:border-green-200 hover:bg-white hover:text-[#0c7c43] focus:outline-none">
                                            {{ $page.props.auth.user.name }}
                                            <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')" class="flex items-center gap-3 text-slate-700 hover:text-[#0c7c43]">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#edf9ee] text-[#0c7c43]">
                                            <i class="fas fa-user-circle text-sm"></i>
                                        </span>
                                        <span>Profile</span>
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center gap-3 text-slate-700 hover:text-[#0c7c43]">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-50 text-red-500">
                                            <i class="fas fa-power-off text-sm"></i>
                                        </span>
                                        <span>Log Out</span>
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center rounded-xl border border-green-100 bg-white p-2 text-slate-500 transition hover:bg-green-50 hover:text-[#0c7c43] focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                <div class="space-y-1 border-t border-green-100 bg-white pb-3 pt-2">
                </div>

                <div class="border-t border-green-100 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-medium text-slate-800">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm font-medium text-slate-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')" class="flex items-center gap-3 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#edf9ee] text-[#0c7c43]">
                                <i class="fas fa-user-circle text-sm"></i>
                            </span>
                            <span>Profile</span>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="flex items-center gap-3 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-red-50 text-red-500">
                                <i class="fas fa-power-off text-sm"></i>
                            </span>
                            <span>Log Out</span>
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <header v-if="$slots.header" class="border-b border-green-100 bg-gradient-to-r from-[#f2faf4] via-white to-[#edf9ee]">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main class="flex-1 mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <slot />
        </main>

        <AppFooter />
    </div>
</template>

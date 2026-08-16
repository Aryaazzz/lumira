<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    sellers: Array,
})

function warningSeller(id) {
    if (confirm('Berikan warning kepada seller ini?')) {
        router.post(route('admin.sellers.warning', id))
    }
}

function suspendSeller(id) {
    if (confirm('Suspend seller ini?')) {
        router.post(route('admin.sellers.suspend', id))
    }
}

function unsuspendSeller(id) {
    if (confirm('Aktifkan kembali seller ini?')) {
        router.post(route('admin.sellers.unsuspend', id))
    }
}

const getInitials = (name = '') => {
    const parts = name.trim().split(/\s+/).filter(Boolean)
    if (!parts.length) return 'S'
    return parts.slice(0, 2).map((part) => part[0]?.toUpperCase() || '').join('')
}

const statusClass = (isSuspended) =>
    isSuspended ? 'bg-red-100 text-red-700 ring-1 ring-red-200' : 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200'
</script>

<template>
    <Head title="Kelola Seller" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#0c7c43]">Marketplace</p>
                    <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-900">Kelola Seller</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl py-8">
            <section class="grid gap-4 md:grid-cols-3" data-aos="fade-up">
                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Total Seller</p>
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#edf9ee] text-[#0c7c43]"><i class="fas fa-users"></i></div>
                    </div>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ sellers?.length ?? 0 }}</p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Warning</p>
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-100 text-amber-600"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ sellers?.reduce((sum, seller) => sum + Number(seller.warning_count || 0), 0) }}</p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Suspended</p>
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-100 text-red-600"><i class="fas fa-ban"></i></div>
                    </div>
                    <p class="mt-4 text-3xl font-black text-slate-900">{{ sellers?.filter((seller) => seller.is_suspended).length ?? 0 }}</p>
                </div>
            </section>

            <section class="mt-8 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm ring-1 ring-slate-100" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-[#0c7c43]">Seller</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">Daftar Seller</h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#edf9ee] text-[#0c7c43]">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div v-if="sellers && sellers.length" class="grid gap-4 xl:grid-cols-2">
                    <div
                        v-for="seller in sellers"
                        :key="seller.id"
                        class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-white hover:shadow-md"
                    >
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#0c7c43] to-[#0b2617] text-lg font-black text-white shadow-lg shadow-green-950/15">
                                    {{ getInitials(seller.name) }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-slate-900">{{ seller.name }}</h4>
                                    <p class="text-xs text-slate-500">{{ seller.email }}</p>
                                </div>
                            </div>

                            <span :class="statusClass(seller.is_suspended)" class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-[0.16em]">
                                {{ seller.is_suspended ? 'Suspended' : 'Active' }}
                            </span>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl bg-white p-3 ring-1 ring-slate-200">
                                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Toko</p>
                                <p class="mt-2 font-bold text-slate-800">{{ seller.store?.name ?? '-' }}</p>
                            </div>

                            <div class="rounded-2xl bg-white p-3 ring-1 ring-slate-200">
                                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Warning</p>
                                <p class="mt-2 font-black text-slate-800">{{ seller.warning_count }}</p>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            <button @click="warningSeller(seller.id)" class="rounded-xl bg-amber-500 px-3.5 py-2 text-xs font-bold text-white shadow-lg shadow-amber-900/15 transition hover:-translate-y-0.5 hover:bg-amber-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Warning
                            </button>
                            <button v-if="!seller.is_suspended" @click="suspendSeller(seller.id)" class="rounded-xl bg-red-600 px-3.5 py-2 text-xs font-bold text-white shadow-lg shadow-red-900/15 transition hover:-translate-y-0.5 hover:bg-red-700">
                                <i class="fas fa-ban mr-1"></i>Suspend
                            </button>
                            <button v-else @click="unsuspendSeller(seller.id)" class="rounded-xl bg-emerald-600 px-3.5 py-2 text-xs font-bold text-white shadow-lg shadow-emerald-900/15 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                                <i class="fas fa-check mr-1"></i>Unsuspend
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else class="rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
                    Belum ada seller terdaftar.
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
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
</script>

<template>
    <Head title="Kelola Seller" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-red-600">Marketplace</p>
                    <h2 class="text-xl font-bold text-slate-800">Kelola Seller</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Total Seller</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ sellers?.length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-5 shadow-sm ring-1 ring-emerald-200">
                    <p class="text-sm text-emerald-700">Seller Aktif</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">{{ sellers?.filter(s => !s.is_suspended).length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-red-50 p-5 shadow-sm ring-1 ring-red-200">
                    <p class="text-sm text-red-700">Seller Suspended</p>
                    <p class="mt-3 text-3xl font-bold text-red-700">{{ sellers?.filter(s => s.is_suspended).length ?? 0 }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 p-5">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Seller</h3>
                </div>

                <div v-if="!sellers?.length" class="p-8 text-center text-slate-500">Belum ada seller.</div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-left text-slate-600">
                            <tr>
                                <th class="p-4">Seller</th>
                                <th class="p-4">Toko</th>
                                <th class="p-4">Warning</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="seller in sellers" :key="seller.id" class="border-t border-slate-200">
                                <td class="p-4">
                                    <div class="font-semibold text-slate-800">{{ seller.name }}</div>
                                    <div class="text-xs text-slate-500">{{ seller.email }}</div>
                                </td>
                                <td class="p-4 text-slate-700">{{ seller.store?.name || '-' }}</td>
                                <td class="p-4"><span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-700">{{ seller.warning_count }}</span></td>
                                <td class="p-4">
                                    <span v-if="seller.is_suspended" class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Suspended</span>
                                    <span v-else class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button @click="warningSeller(seller.id)" class="rounded-xl bg-yellow-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-yellow-600">Warning</button>
                                        <button v-if="!seller.is_suspended" @click="suspendSeller(seller.id)" class="rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Suspend</button>
                                        <button v-else @click="unsuspendSeller(seller.id)" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">Unsuspend</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


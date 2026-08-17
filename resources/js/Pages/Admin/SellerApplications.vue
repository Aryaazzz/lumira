<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    applications: Array,
})

const approve = (id) => {
    router.post(route('admin.seller.approve', id))
}

const reject = (id) => {
    router.post(route('admin.seller.reject', id))
}
</script>

<template>
    <Head title="Pengajuan Seller" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-600">Seller</p>
                    <h2 class="text-xl font-bold text-slate-800">Pengajuan Seller</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Total Pengajuan</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ applications?.length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-amber-50 p-5 shadow-sm ring-1 ring-amber-200">
                    <p class="text-sm text-amber-700">Menunggu Review</p>
                    <p class="mt-3 text-3xl font-bold text-amber-700">{{ applications?.length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-5 shadow-sm ring-1 ring-emerald-200">
                    <p class="text-sm text-emerald-700">Siap Diproses</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">{{ applications?.length ?? 0 }}</p>
                </div>
            </div>

            <div v-if="!applications?.length" class="rounded-2xl bg-white p-8 text-center text-slate-500 shadow-sm ring-1 ring-slate-200">
                Belum ada pengajuan seller.
            </div>

            <div v-else class="space-y-4">
                <div
                    v-for="item in applications"
                    :key="item.id"
                    class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm"
                >
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Toko</p>
                            <h3 class="mt-2 text-2xl font-bold text-slate-800">{{ item.store_name }}</h3>
                            <div class="mt-3 space-y-1 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-700">Pemilik:</span> {{ item.user?.name }}</p>
                                <p><span class="font-semibold text-slate-700">Status:</span> {{ item.seller_status }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button @click="approve(item.id)" class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">Approve</button>
                            <button @click="reject(item.id)" class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    topUps: Array,
})

const approve = (id) => {
    router.post(route('admin.topups.approve', id))
}

const reject = (id) => {
    router.post(route('admin.topups.reject', id))
}
</script>

<template>
    <Head title="Manajemen Top Up" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">Finance</p>
                    <h2 class="text-xl font-bold text-slate-800">Manajemen Top Up</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Total Request</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ topUps?.length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-amber-50 p-5 shadow-sm ring-1 ring-amber-200">
                    <p class="text-sm text-amber-700">Pending</p>
                    <p class="mt-3 text-3xl font-bold text-amber-700">{{ topUps?.filter(item => item.status === 'pending').length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-5 shadow-sm ring-1 ring-emerald-200">
                    <p class="text-sm text-emerald-700">Approved</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">{{ topUps?.filter(item => item.status === 'approved').length ?? 0 }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 p-5">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Permintaan Top Up</h3>
                </div>

                <div v-if="!topUps?.length" class="p-8 text-center text-slate-500">Belum ada request top up.</div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-left text-slate-600">
                            <tr>
                                <th class="p-4">User</th>
                                <th class="p-4">Nominal</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="topup in topUps" :key="topup.id" class="border-t border-slate-200">
                                <td class="p-4 font-medium text-slate-800">{{ topup.user?.name }}</td>
                                <td class="p-4 text-slate-700">Rp {{ Number(topup.amount || 0).toLocaleString('id-ID') }}</td>
                                <td class="p-4">
                                    <span v-if="topup.status === 'pending'" class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pending</span>
                                    <span v-else-if="topup.status === 'approved'" class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Approved</span>
                                    <span v-else class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Rejected</span>
                                </td>
                                <td class="p-4">
                                    <div v-if="topup.status === 'pending'" class="flex flex-wrap gap-2">
                                        <button @click="approve(topup.id)" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">Approve</button>
                                        <button @click="reject(topup.id)" class="rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Reject</button>
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

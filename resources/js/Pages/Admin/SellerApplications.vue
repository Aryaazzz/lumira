<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    applications: Array,
})

const sortedApplications = computed(() => {
    return [...props.applications].sort((a, b) => a.id - b.id)
})

const approve = (id) => {
    router.post(route('admin.seller.approve', id))
}

const reject = (id) => {
    router.post(route('admin.seller.reject', id))
}

const statusClass = (status = '') => {
    const normalized = status.toLowerCase()

    if (normalized.includes('approved') || normalized.includes('disetujui')) {
        return 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200'
    }

    if (normalized.includes('rejected') || normalized.includes('ditolak')) {
        return 'bg-red-100 text-red-700 ring-1 ring-red-200'
    }

    return 'bg-amber-100 text-amber-700 ring-1 ring-amber-200'
}
</script>

<template>
    <Head title="Pengajuan Seller" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#0c7c43]">Admin</p>
                    <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-900">Pengajuan Seller</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl py-8">
            <section class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm ring-1 ring-slate-100" data-aos="fade-up">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-[#0c7c43]">Review</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">Daftar Pengajuan</h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#edf9ee] text-[#0c7c43]">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>

                <div v-if="applications && applications.length" class="space-y-5">
                    <div
                        v-for="item in sortedApplications"
                        :key="item.id"
                        class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md"
                    >
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#0c7c43] to-[#0b2617] text-lg font-black text-white">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900">{{ item.store_name }}</h3>
                                        <p class="text-sm text-slate-500">Pemilik: {{ item.user?.name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <span :class="statusClass(item.status)" class="inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.12em]">
                                    {{ item.status }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <button
                                v-if="!String(item.status).toLowerCase().includes('approved') && !String(item.status).toLowerCase().includes('disetujui') && !String(item.status).toLowerCase().includes('rejected') && !String(item.status).toLowerCase().includes('ditolak')"
                                @click="approve(item.id)"
                                class="rounded-xl bg-[#0c7c43] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-green-900/15 transition hover:-translate-y-0.5 hover:bg-[#0b2617]"
                            >
                                <i class="fas fa-check mr-2"></i>Approve
                            </button>
                            <button
                                v-if="!String(item.status).toLowerCase().includes('approved') && !String(item.status).toLowerCase().includes('disetujui') && !String(item.status).toLowerCase().includes('rejected') && !String(item.status).toLowerCase().includes('ditolak')"
                                @click="reject(item.id)"
                                class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-900/15 transition hover:-translate-y-0.5 hover:bg-red-700"
                            >
                                <i class="fas fa-times mr-2"></i>Reject
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else class="rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
                    Belum ada pengajuan seller.
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
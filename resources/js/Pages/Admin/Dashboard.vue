
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js'

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale
)
import { onMounted, ref, onBeforeUnmount } from 'vue'

const props = defineProps({
    stats: Object,
    topSeller: Object,
    topProduct: Object,
    latestOrders: Array,
    salesChart: Array,
    totalCommission: {
        type: Number,
        default: 0,
    },
})

const chartRef = ref(null)
const chartInstance = ref(null)

const adminLinks = [
    { label: 'Pengajuan Seller', href: route('admin.seller.applications'), tone: 'emerald' },
    { label: 'Kelola Seller', href: route('admin.sellers.index'), tone: 'red' },
    { label: 'Kelola Top Up', href: route('admin.topups.index'), tone: 'amber' },
    { label: 'Kelola Kategori', href: route('admin.categories.index'), tone: 'blue' },
    { label: 'Kelola Pengumuman', href: route('admin.announcements.index'), tone: 'violet' },
    { label: 'Kelola Produk', href: route('admin.products.index'), tone: 'indigo' },
    { label: 'Withdrawal Seller', href: route('admin.withdrawals.index'), tone: 'slate' },
    { label: 'Kelola Banner', href: route('admin.banners.index'), tone: 'teal' },
]

const toneClasses = {
    emerald: 'bg-emerald-600 hover:bg-emerald-700',
    red: 'bg-red-600 hover:bg-red-700',
    amber: 'bg-amber-500 hover:bg-amber-600',
    blue: 'bg-blue-600 hover:bg-blue-700',
    violet: 'bg-violet-600 hover:bg-violet-700',
    indigo: 'bg-indigo-600 hover:bg-indigo-700',
    slate: 'bg-slate-700 hover:bg-slate-800',
    teal: 'bg-teal-600 hover:bg-teal-700',
}

const formatCurrency = (value) => Number(value || 0).toLocaleString('id-ID')

onMounted(() => {
    if (!chartRef.value || !props.salesChart || !props.salesChart.length) {
        return
    }

    if (chartInstance.value) {
        chartInstance.value.destroy()
        chartInstance.value = null
    }

    chartInstance.value = new Chart(chartRef.value, {
        type: 'bar',
        data: {
            labels: props.salesChart.map(item => 'Bulan ' + item.month),
            datasets: [{
                label: 'Penjualan',
                data: props.salesChart.map(item => item.total),
                backgroundColor: 'rgba(16,185,129,0.9)',
                borderRadius: 8,
                borderSkipped: false,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 200 },
            scales: {
                y: { beginAtZero: true },
            },
            plugins: { legend: { display: false } },
        },
    })
})

onBeforeUnmount(() => {
    if (chartInstance.value) {
        chartInstance.value.destroy()
        chartInstance.value = null
    }
})
</script>

<template>
    <Head title="Dashboard Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-600">Admin Control</p>
                    <h2 class="mt-1 text-xl font-bold text-slate-800">Dashboard Admin</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <section class="mb-8 overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-700 p-6 text-white shadow-xl">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-200">Overview</p>
                        <h1 class="mt-3 text-3xl font-bold">Kelola marketplace Lumira</h1>
                        <p class="mt-2 max-w-2xl text-sm text-slate-200">Pantau seller, produk, order, komisi, dan aktivitas platform dari satu tempat.</p>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-white/5 px-4 py-3 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">Komisi hari ini</p>
                        <p class="mt-2 text-2xl font-bold">Rp {{ formatCurrency(totalCommission) }}</p>
                    </div>
                </div>
            </section>

            <section class="mb-8 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                <Link
                    v-for="link in adminLinks"
                    :key="link.label"
                    :href="link.href"
                    class="rounded-2xl px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5"
                    :class="toneClasses[link.tone]"
                >
                    {{ link.label }}
                </Link>
            </section>

            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total User</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ stats.users }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Seller</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ stats.sellers }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Produk</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ stats.products }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Order</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ stats.orders }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Pendapatan</p>
                    <p class="mt-3 text-2xl font-bold text-emerald-600">Rp {{ formatCurrency(stats.revenue) }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Top Up Pending</p>
                    <p class="mt-3 text-3xl font-bold text-amber-600">{{ stats.pendingTopups }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Pengajuan Seller</p>
                    <p class="mt-3 text-3xl font-bold text-violet-600">{{ stats.pendingSellerApplications }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Produk Sold Out</p>
                    <p class="mt-3 text-3xl font-bold text-red-600">{{ stats.soldOutProducts }}</p>
                </div>
            </section>

            <section class="mt-8 grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-800">Grafik Penjualan</h3>
                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Trend</span>
                    </div>
                    <div class="h-72">
                        <canvas ref="chartRef" class="h-full w-full"></canvas>
                    </div>
                </div>

                <div class="rounded-3xl border border-violet-200 bg-gradient-to-br from-violet-50 to-purple-50 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-violet-900">Komisi Lumira</h3>
                        <span class="text-2xl">💼</span>
                    </div>
                    <p class="mt-5 text-3xl font-bold text-violet-900">Rp {{ formatCurrency(totalCommission) }}</p>
                    <p class="mt-3 text-sm text-violet-700">Total komisi yang berhasil terkumpul dari transaksi platform.</p>
                </div>
            </section>

            <section class="mt-8 grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-slate-800">🏆 Top Seller</h3>
                    <div v-if="topSeller" class="space-y-2">
                        <p class="text-xl font-semibold text-slate-800">{{ topSeller.name }}</p>
                        <p class="text-sm text-slate-500">Total Sales: {{ topSeller.total_sales }}</p>
                    </div>
                    <p v-else class="text-sm text-slate-500">Belum ada data seller.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-slate-800">🔥 Produk Terlaris</h3>
                    <div v-if="topProduct" class="space-y-2">
                        <p class="text-xl font-semibold text-slate-800">{{ topProduct.name }}</p>
                        <p class="text-sm text-slate-500">Terjual: {{ topProduct.sold_count }}</p>
                    </div>
                    <p v-else class="text-sm text-slate-500">Belum ada data produk.</p>
                </div>
            </section>

            <section class="mt-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-xl font-bold text-slate-800">Pesanan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-left text-slate-600">
                                <th class="py-3 pr-3">ID</th>
                                <th class="py-3 pr-3">User</th>
                                <th class="py-3 pr-3">Total</th>
                                <th class="py-3 pr-3">Status</th>
                                <th class="py-3 pr-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in latestOrders" :key="order.id" class="border-b border-slate-100">
                                <td class="py-3 pr-3">#{{ order.id }}</td>
                                <td class="py-3 pr-3">{{ order.user?.name }}</td>
                                <td class="py-3 pr-3">Rp {{ Number(order.total_price || 0).toLocaleString('id-ID') }}</td>
                                <td class="py-3 pr-3">
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ order.status }}</span>
                                </td>
                                <td class="py-3 pr-3">{{ order.created_at ? new Date(order.created_at).toLocaleDateString('id-ID') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>


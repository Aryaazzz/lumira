
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    announcement: Object,
    stats: Object,
    topProduct: Object,
    store: Object,
    pendingOrders: Number,
    completedOrders: Number,
    currentMonthRevenue: Number,
})

const formatCurrency = (value) => {
    return Number(value || 0).toLocaleString('id-ID')
}
</script>

<template>
    <Head title="Dashboard Seller" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
            <section class="overflow-hidden rounded-3xl bg-gradient-to-r from-green-700 via-emerald-600 to-lime-500 shadow-xl">
                <div class="flex flex-col gap-5 p-6 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <img
                            v-if="store?.logo"
                            :src="'/storage/' + store.logo"
                            class="h-20 w-20 rounded-full border-4 border-white/90 object-cover shadow-lg"
                        />

                        <div class="text-white">
                            <p class="text-sm uppercase tracking-[0.2em] text-emerald-100">
                                Toko Anda
                            </p>
                            <h1 class="mt-1 text-3xl font-bold">
                                {{ store?.name }}
                            </h1>
                            <p class="mt-1 max-w-xl text-sm text-emerald-50">
                                {{ store?.description || 'Belum ada deskripsi toko.' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 text-sm text-white/90">
                        <span class="rounded-full bg-white/15 px-3 py-1.5 backdrop-blur-sm">
                            ⭐ {{ store?.rating || 0 }}
                        </span>
                        <span class="rounded-full bg-white/15 px-3 py-1.5 backdrop-blur-sm">
                            📝 {{ store?.total_reviews || 0 }} Review
                        </span>
                        <span class="rounded-full bg-white/15 px-3 py-1.5 backdrop-blur-sm">
                            🛒 {{ store?.total_sales || 0 }} Terjual
                        </span>
                    </div>
                </div>
            </section>

            <section class="rounded-3xl bg-gradient-to-r from-emerald-500 to-green-600 p-7 text-white shadow-lg">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-100">
                            Ringkasan
                        </p>
                        <h2 class="mt-2 text-3xl font-bold">
                            Dashboard Seller Lumira
                        </h2>
                    </div>

                    <p class="max-w-xl text-sm text-emerald-50">
                        Kelola produk, pantau pesanan, dan lihat performa tokomu dalam satu tampilan.
                    </p>
                </div>
            </section>

            <section v-if="announcement" class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-200 text-lg">
                        📢
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-yellow-800">
                            {{ announcement.title }}
                        </h3>
                        <p class="mt-2 text-sm leading-6 text-yellow-700">
                            {{ announcement.content }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Total Produk</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ stats?.products ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Produk Aktif</p>
                    <h3 class="mt-3 text-3xl font-bold text-green-600">
                        {{ stats?.activeProducts ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Sold Out</p>
                    <h3 class="mt-3 text-3xl font-bold text-red-600">
                        {{ stats?.soldOutProducts ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Total Terjual</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ stats?.soldItems ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Pendapatan</p>
                    <h3 class="mt-3 text-2xl font-bold text-blue-600">
                        Rp {{ formatCurrency(stats?.revenue) }}
                    </h3>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-orange-50 p-5 shadow-sm ring-1 ring-orange-100">
                    <p class="text-sm text-orange-700">Order Pending</p>
                    <h3 class="mt-3 text-3xl font-bold text-orange-600">
                        {{ pendingOrders ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-green-50 p-5 shadow-sm ring-1 ring-green-100">
                    <p class="text-sm text-green-700">Order Selesai</p>
                    <h3 class="mt-3 text-3xl font-bold text-green-600">
                        {{ completedOrders ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-2xl bg-blue-50 p-5 shadow-sm ring-1 ring-blue-100">
                    <p class="text-sm text-blue-700">Pendapatan Bulan Ini</p>
                    <h3 class="mt-3 text-2xl font-bold text-blue-600">
                        Rp {{ formatCurrency(currentMonthRevenue) }}
                    </h3>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">💬 Percakapan Terbaru</h3>
                    <Link :href="route('chat.index')" class="text-sm text-blue-600">Lihat Semua</Link>
                </div>

                <div class="flex items-center justify-center gap-4">
                    <div class="text-sm text-gray-700">
                        <span class="font-semibold">Terbaru:</span>
                        <span v-if="$page.props.conversations && $page.props.conversations.length">{{ $page.props.conversations[0].buyer?.name || 'Pengguna' }}</span>
                        <span v-else>Belum ada pesan</span>
                    </div>

                    <Link :href="route('chat.index')" class="bg-indigo-600 text-white px-6 py-3 rounded-lg">Pesan</Link>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <Link
                    :href="route('seller.products.index')"
                    class="group rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 p-6 text-white shadow-lg transition-transform duration-200 hover:-translate-y-1"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-3xl">📦</span>
                        <span class="rounded-full bg-white/15 px-2 py-1 text-xs">Kelola</span>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Produk Saya</h3>
                    <p class="mt-2 text-sm text-blue-100">
                        Lihat dan atur semua produk toko Anda.
                    </p>
                </Link>

                <Link
                    :href="route('seller.products.create')"
                    class="group rounded-2xl bg-gradient-to-br from-green-600 to-emerald-500 p-6 text-white shadow-lg transition-transform duration-200 hover:-translate-y-1"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-3xl">➕</span>
                        <span class="rounded-full bg-white/15 px-2 py-1 text-xs">Baru</span>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Tambah Produk</h3>
                    <p class="mt-2 text-sm text-green-100">
                        Tambahkan produk baru ke katalog Anda.
                    </p>
                </Link>

                <Link
                    :href="route('seller.orders.index')"
                    class="group rounded-2xl bg-gradient-to-br from-violet-600 to-purple-500 p-6 text-white shadow-lg transition-transform duration-200 hover:-translate-y-1"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-3xl">🛒</span>
                        <span class="rounded-full bg-white/15 px-2 py-1 text-xs">Pesanan</span>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Pesanan</h3>
                    <p class="mt-2 text-sm text-violet-100">
                        Pantau status pesanan masuk dengan cepat.
                    </p>
                </Link>

                <Link
    :href="route('seller.store.edit')"
    class="bg-indigo-600 text-white rounded-xl p-6 shadow"
>
    🏪 Profil Toko
</Link>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">🔥 Produk Terlaris</h3>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                        Top Seller
                    </span>
                </div>

                <div v-if="topProduct" class="flex flex-col gap-4 md:flex-row md:items-center">
                    <img
                        :src="'/storage/' + topProduct.image"
                        class="h-28 w-28 rounded-2xl object-cover shadow-md"
                    />

                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-slate-800">
                            {{ topProduct.name }}
                        </h4>
                        <p class="mt-1 text-sm text-slate-500">
                            Terjual: {{ topProduct.sold_count || 0 }} unit
                        </p>
                        <p class="mt-3 text-lg font-bold text-green-600">
                            Rp {{ formatCurrency(topProduct.price) }}
                        </p>
                    </div>
                </div>

                <div v-else class="rounded-xl bg-slate-50 p-6 text-center text-slate-500">
                    Belum ada produk terjual.
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

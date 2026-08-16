<script setup>
import { computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps({
    announcement: Object,
    stats: {
        type: Object,
        default: () => ({
            balance: 0,
            orders: 0,
            shippedOrders: 0,
            wishlistCount: 0,
        }),
    },
    latestProducts: {
        type: Array,
        default: () => [],
    },
    recentOrders: {
        type: Array,
        default: () => [],
    },
    bestSellingProducts: {
        type: Array,
        default: () => [],
    },
    topStores: {
        type: Array,
        default: () => [],
    },
})

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(Number(value ?? 0))
}

const statsCards = computed(() => [
    {
        label: 'Saldo',
        value: formatCurrency(props.stats.balance),
        tone: 'emerald',
        icon: '💰',
    },
    {
        label: 'Total Pesanan',
        value: props.stats.orders ?? 0,
        tone: 'blue',
        icon: '📦',
    },
    {
        label: 'Sedang Dikirim',
        value: props.stats.shippedOrders ?? 0,
        tone: 'amber',
        icon: '🚚',
    },
    {
        label: 'Wishlist',
        value: props.stats.wishlistCount ?? 0,
        tone: 'pink',
        icon: '❤️',
    },
])
</script>

<template>
    <Head title="Dashboard User" />

    <AuthenticatedLayout>
        <div v-if="announcement" class="mx-auto mt-6 max-w-7xl px-4 sm:px-0">
            <div class="rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-yellow-50 p-4 shadow-sm shadow-amber-200/40">
                <h3 class="text-lg font-black text-[#0b2617]">
                    <i class="fas fa-bullhorn mr-2 text-slate-500"></i>{{ announcement.title }}
                </h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    {{ announcement.content }}
                </p>
            </div>
        </div>

        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-[#0c7c43]">Welcome back</p>
                    <h2 class="mt-2 text-2xl font-black text-[#0b2617] md:text-3xl">
                        Halo, {{ $page.props.auth.user.name }}
                    </h2>
                </div>

                <div class="flex flex-wrap gap-2">
                    <Link :href="route('topup.index')" class="rounded-xl bg-[#0c7c43] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-green-900/20 transition hover:-translate-y-0.5 hover:bg-[#0b2617]">
                        <i class="fas fa-wallet mr-2"></i>Top Up Saldo
                    </Link>
                    <Link :href="route('orders.index')" class="rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:text-[#0c7c43]">
                        <i class="fas fa-box mr-2 text-slate-500"></i>Pesanan Saya
                    </Link>
                    <Link :href="route('notifications.index')" class="rounded-xl bg-[#eafaf1] px-4 py-2.5 text-sm font-bold text-[#0c7c43] shadow-sm ring-1 ring-green-100 transition hover:-translate-y-0.5">
                        <i class="fas fa-bell mr-2"></i>Notifikasi
                    </Link>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl py-8">
            <div v-if="page.props.flash?.error" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                {{ page.props.flash.error }}
            </div>

            <div v-if="$page.props.auth.user.seller_status === 'suspended'" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-6 shadow-sm">
                <h3 class="text-lg font-black text-red-700">Akun Seller Ditangguhkan</h3>
                <p class="mt-2 text-sm leading-6 text-red-600">
                    Hak seller Anda sedang dicabut oleh admin. Anda masih dapat menggunakan akun ini sebagai pembeli.
                </p>
                <div class="mt-4">
                    <Link href="/seller/apply" class="inline-block rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700">
                        Ajukan Seller Kembali
                    </Link>
                </div>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div v-for="(stat, index) in statsCards" :key="index" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ stat.label }}</p>
                            <h2 class="mt-3 text-2xl font-bold" :class="{ 'text-emerald-600': stat.tone === 'emerald', 'text-blue-600': stat.tone === 'blue', 'text-amber-600': stat.tone === 'amber', 'text-pink-600': stat.tone === 'pink' }">
                                {{ stat.value }}
                            </h2>
                        </div>
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl text-xl shadow-sm" :class="{ 'bg-emerald-100 text-emerald-600': stat.tone === 'emerald', 'bg-blue-100 text-blue-600': stat.tone === 'blue', 'bg-amber-100 text-amber-600': stat.tone === 'amber', 'bg-pink-100 text-pink-600': stat.tone === 'pink' }">
                            {{ stat.icon }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white p-6 shadow-[0_20px_60px_rgba(18,41,24,0.08)] ring-1 ring-slate-100 md:p-8">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-[#0c7c43]">Marketplace</p>
                        <h1 class="mt-2 text-3xl font-black text-[#0b2617] md:text-4xl">
                            Selamat datang di Lumira
                        </h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 rounded-full bg-[#edf9ee] px-4 py-2 text-sm font-bold text-[#0c7c43]">
                        <i class="fas fa-leaf text-[#0c7c43]"></i>
                        Marketplace Sampah Daur Ulang Indonesia
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <Link :href="route('marketplace')" class="group rounded-2xl bg-gradient-to-br from-[#0c7c43] to-[#0b2617] p-6 text-white shadow-lg shadow-green-900/20 transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-2xl">
                            <i class="fas fa-store"></i>
                        </div>
                        <h3 class="text-lg font-bold">Marketplace</h3>
                        <p class="mt-2 text-sm text-green-50">Jelajahi produk daur ulang</p>
                    </Link>

                    <Link :href="route('cart.index')" class="group rounded-2xl bg-gradient-to-br from-[#f3f7f5] to-[#ebf8f0] p-6 text-slate-800 ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-900/10">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white text-2xl text-slate-500">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="text-lg font-bold">Keranjang</h3>
                        <p class="mt-2 text-sm text-slate-500">Produk yang sudah Anda pilih</p>
                    </Link>

                    <Link :href="route('wishlist.index')" class="group rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="text-lg font-bold">Wishlist</h3>
                        <p class="mt-2 text-sm text-pink-50">Produk favorit yang disimpan</p>
                    </Link>

                    <Link v-if="$page.props.auth.user.seller_status !== 'suspended'" :href="route('seller.apply')" class="group rounded-2xl bg-gradient-to-br from-[#edf9ee] to-[#e4f8e7] p-6 text-slate-800 ring-1 ring-green-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-900/10">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white text-2xl text-[#0c7c43]">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h3 class="text-lg font-bold">Daftar Seller</h3>
                        <p class="mt-2 text-sm text-slate-500">Mulai jualan dan bangun bisnis Anda</p>
                    </Link>

                    <div v-else class="rounded-2xl bg-slate-100 p-6 text-slate-600 ring-1 ring-slate-200">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white text-2xl text-slate-500">
                            <i class="fas fa-ban"></i>
                        </div>
                        <h3 class="text-lg font-bold">Status Seller Ditangguhkan</h3>
                        <p class="mt-2 text-sm">Hubungi admin atau ajukan kembali.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 xl:grid-cols-[1.1fr_1.9fr]">
                <div v-if="recentOrders.length" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-800">Pesanan Terakhir</h2>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            {{ recentOrders.length }} item
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div v-for="order in recentOrders" :key="order.id" class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <div>
                                <p class="font-semibold text-slate-800">Order #{{ order.id }}</p>
                                <p class="text-sm text-slate-500">{{ order.created_at }}</p>
                            </div>
                            <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-700">
                                {{ order.status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div v-if="bestSellingProducts.length" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-800">Produk Terlaris</h2>
                        <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                            Top picks
                        </span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div v-for="product in bestSellingProducts" :key="product.id" class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm">
                            <img :src="'/storage/' + product.image" class="h-36 w-full object-cover" />
                            <div class="p-4">
                                <h3 class="line-clamp-2 text-base font-bold text-slate-800">{{ product.name }}</h3>
                                <p class="mt-1 text-xs text-slate-500">Terjual {{ product.sold_count }} kali</p>
                                <p class="mt-2 text-base font-bold text-emerald-600">
                                    Rp {{ Number(product.price).toLocaleString('id-ID') }}
                                </p>
                                <Link :href="route('marketplace.show', product.id)" class="mt-4 block rounded-xl bg-orange-500 px-3 py-2 text-center text-sm font-semibold text-white transition hover:bg-orange-600">
                                    Lihat Produk
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <h2 class="mb-4 text-2xl font-bold text-slate-800">🏆 Seller Terbaik</h2>
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div v-for="(store, index) in topStores" :key="store.id" class="flex items-center justify-between border-b border-slate-200 p-4 last:border-b-0">
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-500 font-bold text-white">
                                {{ index + 1 }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ store.name }}</p>
                                <p class="text-sm text-gray-500">{{ store.reviews_count ?? 0 }} review</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="font-bold text-yellow-600">⭐ {{ store.rating ?? 0 }}</div>
                            <Link
                                v-if="store.slug"
                                :href="route('store.show', store.slug)"
                                class="rounded-lg bg-emerald-600 px-3 py-1 text-sm font-medium text-white"
                            >
                                Kunjungi
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-slate-800">Produk Terbaru</h2>
                    <Link :href="route('marketplace')" class="text-sm font-semibold text-emerald-600 transition hover:text-emerald-700">
                        Lihat Semua →
                    </Link>
                </div>

                <div v-if="latestProducts.length" class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div v-for="product in latestProducts" :key="product.id" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                        <img :src="'/storage/' + product.image" class="h-44 w-full object-cover" />
                        <div class="p-4">
                            <h3 class="line-clamp-2 text-base font-bold text-slate-800">{{ product.name }}</h3>
                            <p class="mt-2 text-lg font-bold text-emerald-600">Rp {{ Number(product.price).toLocaleString('id-ID') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ product.store?.name }}</p>
                            <Link :href="route('marketplace.show', product.id)" class="mt-4 block rounded-xl bg-emerald-600 px-3 py-2 text-center text-sm font-semibold text-white transition hover:bg-emerald-700">
                                Lihat Produk
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-else class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500">
                    Belum ada produk terbaru saat ini.
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

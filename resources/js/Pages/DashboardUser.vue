<script setup>
import {
    computed,
    ref,
    onMounted,
    onUnmounted
} from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps({
    announcement: {
        type: Object,
        default: null,
    },
    banners: {
        type: Array,
        default: () => [],
    },
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

const formatCurrency = (value) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(Number(value ?? 0))

const recentOrders = computed(() => props.recentOrders ?? [])
const bestSellingProducts = computed(() => props.bestSellingProducts ?? [])
const latestProducts = computed(() => props.latestProducts ?? [])
const topStores = computed(() => props.topStores ?? [])
const banners = computed(() => props.banners ?? [])

const currentBanner = ref(0)

const bannerList = computed(() => props.banners ?? [])
const activeBanner = computed(() => bannerList.value[currentBanner.value] ?? null)
const bannerImage = (image) => (image ? `/storage/${image}` : '/images/default-product.jpg')

let interval = null

onMounted(() => {
    if (bannerList.value.length > 1) {
        interval = setInterval(() => {
            currentBanner.value = (currentBanner.value + 1) % bannerList.value.length
        }, 4000)
    }
})

onUnmounted(() => {
    if (interval) {
        clearInterval(interval)
    }
})

const statsCards = computed(() => [
    {
        label: 'Saldo',
        value: formatCurrency(props.stats?.balance ?? 0),
        tone: 'emerald',
        icon: '💰',
    },
    {
        label: 'Total Pesanan',
        value: props.stats?.orders ?? 0,
        tone: 'blue',
        icon: '📦',
    },
    {
        label: 'Sedang Dikirim',
        value: props.stats?.shippedOrders ?? 0,
        tone: 'amber',
        icon: '🚚',
    },
    {
        label: 'Wishlist',
        value: props.stats?.wishlistCount ?? 0,
        tone: 'pink',
        icon: '❤️',
    },
])

const getProductImage = (image) => (image ? `/storage/${image}` : '/images/default-product.jpg')
</script>

<template>
    <Head title="Dashboard User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-bold text-slate-800">Dashboard User</h2>

                <div class="flex flex-wrap gap-2">
                    <Link
                        :href="route('topup.index')"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-emerald-700"
                    >
                        Top Up Saldo
                    </Link>

                    <Link
                        :href="route('orders.index')"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                    >
                        Pesanan Saya
                    </Link>

                    <Link
                        :href="route('notifications.index')"
                        class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-amber-600"
                    >
                        Notifikasi
                    </Link>
                </div>
            </div>
        </template>

        <div v-if="bannerList.length" class="mb-8 px-4 pt-6 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-green-500 to-teal-500 shadow-lg">
                <img
                    v-if="activeBanner?.image"
                    :src="bannerImage(activeBanner.image)"
                    class="h-72 w-full object-cover opacity-80"
                />

                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/70 via-slate-900/35 to-transparent" />

                <div class="absolute inset-0 flex items-center justify-between gap-6 p-6 sm:p-8 lg:p-10">
                    <div class="relative max-w-xl text-white">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100">Promo</p>
                        <h2 class="text-2xl font-bold sm:text-3xl lg:text-4xl">{{ activeBanner?.title }}</h2>
                        <p v-if="activeBanner?.description" class="mt-3 max-w-md text-sm text-emerald-50 sm:text-base">
                            {{ activeBanner.description }}
                        </p>

                        <a
                            v-if="activeBanner?.button_link"
                            :href="activeBanner.button_link"
                            class="mt-5 inline-flex rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50"
                        >
                            {{ activeBanner.button_text || 'Lihat Selengkapnya' }}
                        </a>
                    </div>

                    <div v-if="bannerList.length > 1" class="flex gap-2">
                        <button
                            v-for="(item, index) in bannerList"
                            :key="item.id ?? index"
                            type="button"
                            @click="currentBanner = index"
                            class="h-2.5 w-8 rounded-full transition"
                            :class="currentBanner === index ? 'bg-white' : 'bg-white/50'"
                            :aria-label="`Pilih banner ${index + 1}`"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div v-if="announcement" class="mx-auto max-w-7xl px-4 sm:px-0">
            <div class="rounded-2xl border border-amber-300 bg-gradient-to-r from-amber-100 via-yellow-50 to-orange-100 p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 text-lg shadow-sm">
                        📢
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-amber-900">{{ announcement.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-amber-800">
                            {{ announcement.content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div
                    v-for="(stat, index) in statsCards"
                    :key="index"
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ stat.label }}</p>
                            <h2
                                class="mt-3 text-2xl font-bold"
                                :class="{
                                    'text-emerald-600': stat.tone === 'emerald',
                                    'text-blue-600': stat.tone === 'blue',
                                    'text-amber-600': stat.tone === 'amber',
                                    'text-pink-600': stat.tone === 'pink',
                                }"
                            >
                                {{ stat.value }}
                            </h2>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl text-xl shadow-sm"
                            :class="{
                                'bg-emerald-100 text-emerald-600': stat.tone === 'emerald',
                                'bg-blue-100 text-blue-600': stat.tone === 'blue',
                                'bg-amber-100 text-amber-600': stat.tone === 'amber',
                                'bg-pink-100 text-pink-600': stat.tone === 'pink',
                            }"
                        >
                            {{ stat.icon }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="page.props.flash?.error"
                class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700"
            >
                {{ page.props.flash.error }}
            </div>

            <div
                v-if="$page.props.auth.user.seller_status === 'suspended'"
                class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-6 text-red-700 shadow-sm"
            >
                <h3 class="text-lg font-bold">Akun Seller Ditangguhkan</h3>
                <p class="mt-2 text-sm leading-relaxed">
                    Hak seller Anda sedang dicabut oleh admin. Anda masih dapat menggunakan akun ini sebagai pembeli.
                </p>

                <div class="mt-4">
                    <Link
                        href="/seller/apply"
                        class="inline-flex rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                    >
                        Ajukan Seller Kembali
                    </Link>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
                <div class="flex flex-col gap-2 border-b border-slate-200 pb-5">
                    <span class="inline-flex w-max items-center rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-emerald-700">
                        Dashboard
                    </span>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-800">Selamat Datang di Lumira</h1>
                    <p class="text-gray-600">Marketplace Sampah Daur Ulang Indonesia</p>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <Link
                        :href="route('marketplace')"
                        class="group rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">🛒</div>
                        <h3 class="text-lg font-bold">Marketplace</h3>
                        <p class="mt-2 text-sm text-blue-50">Lihat produk daur ulang</p>
                    </Link>

                    <Link
                        :href="route('cart.index')"
                        class="group rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">🧺</div>
                        <h3 class="text-lg font-bold">Keranjang</h3>
                        <p class="mt-2 text-sm text-amber-50">Produk yang akan dibeli</p>
                    </Link>

                    <Link
                        :href="route('wishlist.index')"
                        class="group rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">❤️</div>
                        <h3 class="text-lg font-bold">Wishlist</h3>
                        <p class="mt-2 text-sm text-pink-50">Produk favorit yang disimpan</p>
                    </Link>

                    <Link
                        v-if="$page.props.auth.user.seller_status !== 'suspended'"
                        :href="route('seller.apply')"
                        class="group rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">🏪</div>
                        <h3 class="text-lg font-bold">Daftar Seller</h3>
                        <p class="mt-2 text-sm text-emerald-50">Mulai berjualan di Lumira</p>
                    </Link>

                    <div v-else class="rounded-2xl bg-slate-200 p-6 text-slate-600 shadow-sm ring-1 ring-slate-300">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-300 text-2xl">⚠️</div>
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
                        <div
                            v-for="order in recentOrders"
                            :key="order.id"
                            class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3"
                        >
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
                        <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">Top picks</span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div
                            v-for="product in bestSellingProducts"
                            :key="product.id"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                        >
                            <img :src="getProductImage(product.image)" class="h-36 w-full object-cover" />

                            <div class="p-4">
                                <h3 class="line-clamp-2 text-base font-bold text-slate-800">{{ product.name }}</h3>
                                <p class="mt-1 text-xs text-slate-500">Terjual {{ product.sold_count }} kali</p>
                                <p class="mt-2 text-base font-bold text-emerald-600">
                                    Rp {{ Number(product.price).toLocaleString('id-ID') }}
                                </p>

                                <Link
                                    :href="route('marketplace.show', product.id)"
                                    class="mt-4 block rounded-xl bg-orange-500 px-3 py-2 text-center text-sm font-semibold text-white transition hover:bg-orange-600"
                                >
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
                    <div
                        v-for="(store, index) in topStores"
                        :key="store.id"
                        class="flex items-center justify-between border-b border-slate-200 p-4 last:border-b-0"
                    >
                        <div class="flex items-center gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-500 font-bold text-white">
                                {{ index + 1 }}
                            </div>

                            <div>
                                <p class="font-bold text-slate-800">{{ store.name }}</p>
                                <p class="text-sm text-gray-500">{{ store.reviews_count }} review</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="font-bold text-yellow-600">⭐ {{ store.rating ?? 0 }}</div>

                            <Link
                                :href="route('store.show', store.slug)"
                                class="rounded-lg bg-emerald-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-emerald-700"
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
                    <Link
                        :href="route('marketplace')"
                        class="text-sm font-semibold text-emerald-600 transition hover:text-emerald-700"
                    >
                        Lihat Semua →
                    </Link>
                </div>

                <div v-if="latestProducts.length" class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div
                        v-for="product in latestProducts"
                        :key="product.id"
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md"
                    >
                        <img :src="getProductImage(product.image)" class="h-44 w-full object-cover" />

                        <div class="p-4">
                            <h3 class="line-clamp-2 text-base font-bold text-slate-800">{{ product.name }}</h3>
                            <p class="mt-2 text-lg font-bold text-emerald-600">
                                Rp {{ Number(product.price).toLocaleString('id-ID') }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">{{ product.store?.name }}</p>

                            <Link
                                :href="route('marketplace.show', product.id)"
                                class="mt-4 block rounded-xl bg-emerald-600 px-3 py-2 text-center text-sm font-semibold text-white transition hover:bg-emerald-700"
                            >
                                Lihat Produk
                            </Link>
                        </div>
                    </div>
                </div>

                <div
                    v-else
                    class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500"
                >
                    Belum ada produk terbaru saat ini.
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
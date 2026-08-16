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

        <div
            v-if="announcement"
            class="max-w-7xl mx-auto mt-6 px-4 sm:px-0"
        >
            <div
                class="bg-gradient-to-r from-amber-100 via-yellow-50 to-orange-100 border border-amber-300 rounded-2xl p-5 shadow-sm"
            >
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 text-lg shadow-sm">
                        📢
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-amber-900">
                            {{ announcement.title }}
                        </h3>

                        <p class="mt-2 text-sm text-amber-800 leading-relaxed">
                            {{ announcement.content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div
                v-for="(stat, index) in statsCards"
                :key="index"
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md"
            >
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            {{ stat.label }}
                        </p>
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

        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-bold text-slate-800">
                    Dashboard User
                </h2>

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

        <div class="mx-auto max-w-7xl py-8">
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
                <h3 class="text-lg font-bold">
                    Akun Seller Ditangguhkan
                </h3>
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
                    <h1 class="text-3xl font-bold tracking-tight text-slate-800">
                        Selamat Datang di Lumira
                    </h1>
                    <p class="text-gray-600">
                        Marketplace Sampah Daur Ulang Indonesia
                    </p>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <Link
                        :href="route('marketplace')"
                        class="group rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">
                            🛒
                        </div>
                        <h3 class="text-lg font-bold">
                            Marketplace
                        </h3>
                        <p class="mt-2 text-sm text-blue-50">
                            Lihat produk daur ulang
                        </p>
                    </Link>

                    <Link
                        :href="route('cart.index')"
                        class="group rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">
                            🧺
                        </div>
                        <h3 class="text-lg font-bold">
                            Keranjang
                        </h3>
                        <p class="mt-2 text-sm text-amber-50">
                            Produk yang akan dibeli
                        </p>
                    </Link>

                    <Link
                        :href="route('wishlist.index')"
                        class="group rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">
                            ❤️
                        </div>
                        <h3 class="text-lg font-bold">
                            Wishlist
                        </h3>
                        <p class="mt-2 text-sm text-pink-50">
                            Produk favorit yang disimpan
                        </p>
                    </Link>

                    <Link
                        v-if="$page.props.auth.user.seller_status !== 'suspended'"
                        :href="route('seller.apply')"
                        class="group rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 p-6 text-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl shadow-inner">
                            🏪
                        </div>
                        <h3 class="text-lg font-bold">
                            Daftar Seller
                        </h3>
                        <p class="mt-2 text-sm text-emerald-50">
                            Mulai berjualan di Lumira
                        </p>
                    </Link>

                    <div
                        v-else
                        class="rounded-2xl bg-slate-200 p-6 text-slate-600 shadow-sm ring-1 ring-slate-300"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-300 text-2xl">
                            ⚠️
                        </div>
                        <h3 class="text-lg font-bold">
                            Status Seller Ditangguhkan
                        </h3>
                        <p class="mt-2 text-sm">
                            Hubungi admin atau ajukan kembali.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 xl:grid-cols-[1.1fr_1.9fr]">
                <div v-if="props.recentOrders.length" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-800">
                            Pesanan Terakhir
                        </h2>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            {{ props.recentOrders.length }} item
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="order in props.recentOrders"
                            :key="order.id"
                            class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3"
                        >
                            <div>
                                <p class="font-semibold text-slate-800">
                                    Order #{{ order.id }}
                                </p>
                                <p class="text-sm text-slate-500">
                                    {{ order.created_at }}
                                </p>
                            </div>

                            <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-700">
                                {{ order.status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div v-if="props.bestSellingProducts.length" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-800">
                            Produk Terlaris
                        </h2>
                        <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                            Top picks
                        </span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-2">
                        <div
                            v-for="product in props.bestSellingProducts"
                            :key="product.id"
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition duration-200 hover:-translate-y-0.5 hover:shadow-sm"
                        >
                            <img
                                :src="'/storage/' + product.image"
                                class="h-36 w-full object-cover"
                            >

                            <div class="p-4">
                                <h3 class="line-clamp-2 text-base font-bold text-slate-800">
                                    {{ product.name }}
                                </h3>
                                <p class="mt-1 text-xs text-slate-500">
                                    Terjual {{ product.sold_count }} kali
                                </p>
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

    <h2 class="text-2xl font-bold mb-4">
        🏆 Seller Terbaik
    </h2>

    <div class="bg-white rounded-2xl shadow">

        <div
            v-for="(store, index) in props.topStores"
            :key="store.id"
            class="flex items-center justify-between p-4 border-b last:border-b-0"
        >

            <div class="flex items-center gap-4">

                <div
                    class="w-10 h-10 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold"
                >
                    {{ index + 1 }}
                </div>

                <div>

                    <p class="font-bold">
                        {{ store.name }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ store.reviews_count }} review
                    </p>

                </div>

            </div>

           <div class="flex items-center gap-3">

    <div class="font-bold text-yellow-600">
        ⭐ {{ store.rating ?? 0 }}
    </div>

    <Link
        :href="route('store.show', store.slug)"
        class="px-3 py-1 bg-emerald-600 text-white rounded-lg text-sm"
    >
        Kunjungi
    </Link>

</div>

        </div>

    </div>

</div>

            <div class="mt-10">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-slate-800">
                        Produk Terbaru
                    </h2>
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
                        <img
                            :src="'/storage/' + product.image"
                            class="h-44 w-full object-cover"
                        >

                        <div class="p-4">
                            <h3 class="line-clamp-2 text-base font-bold text-slate-800">
                                {{ product.name }}
                            </h3>
                            <p class="mt-2 text-lg font-bold text-emerald-600">
                                Rp {{ Number(product.price).toLocaleString('id-ID') }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ product.store?.name }}
                            </p>

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
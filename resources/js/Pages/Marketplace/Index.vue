
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
    stats: Object,
    topWishlistProducts: Array,
})

const filter = reactive({
    search: props.filters?.search ?? '',
    category: props.filters?.category ?? '',
    sort: props.filters?.sort ?? '',
})

const formatCurrency = (value) => {
    return Number(value || 0).toLocaleString('id-ID')
}

function applyFilter() {
    router.get(
        route('marketplace'),
        {
            search: filter.search,
            category: filter.category,
            sort: filter.sort,
        },
        {
            preserveState: true,
            replace: true,
        }
    )
}

function resetFilter() {
    filter.search = ''
    filter.category = ''
    filter.sort = ''

    router.get(route('marketplace'))
}
</script>

<template>
    <Head title="Marketplace" />

    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl px-4 py-8">
            <section class="mb-8 overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-lime-500 p-8 text-white shadow-xl">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-100">
                            Marketplace
                        </p>
                        <h1 class="mt-2 text-3xl font-bold md:text-4xl">
                            Temukan produk daur ulang terbaik
                        </h1>
                    </div>

                    <div class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur-sm">
                        {{ stats?.products ?? 0 }} produk tersedia
                    </div>
                </div>
            </section>

            <div
    v-if="topWishlistProducts.length"
    class="mb-8"
>

    <h2
        class="text-2xl font-bold mb-4"
    >
        🔥 Produk Favorit User
    </h2>

    <div
        class="grid md:grid-cols-4 gap-4"
    >

        <div
            v-for="product in topWishlistProducts"
            :key="product.id"
            class="bg-white rounded-2xl shadow p-4"
        >

            <img
                :src="'/storage/' + product.image"
                class="w-full h-40 object-cover rounded-lg"
            >

            <h3
                class="font-bold mt-3"
            >
                {{ product.name }}
            </h3>

            <p
                class="text-pink-600 text-sm mt-1"
            >
                ❤️
                {{ product.wishlists_count }}
                wishlist
            </p>

            <Link
                :href="
                    route(
                        'marketplace.show',
                        product.id
                    )
                "
                class="block mt-3 bg-green-600 text-white text-center py-2 rounded-lg"
            >
                Lihat
            </Link>

        </div>

    </div>

</div>

            <div
                v-if="products.data.length === 0"
                class="rounded-3xl bg-white p-12 text-center shadow-sm ring-1 ring-slate-100"
            >
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-3xl">
                    🔎
                </div>
                <h3 class="text-2xl font-bold text-slate-800">
                    Tidak ada produk ditemukan
                </h3>
                <p class="mt-2 text-slate-500">
                    Coba ubah kata kunci pencarian atau filter kategori.
                </p>
            </div>

            <div v-else class="mb-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Total Produk</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ stats?.products ?? 0 }}
                    </h2>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Total Kategori</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ stats?.categories ?? 0 }}
                    </h2>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <p class="text-sm text-slate-500">Produk Aktif</p>
                    <h2 class="mt-3 text-3xl font-bold text-green-600">
                        {{ stats?.activeProducts ?? 0 }}
                    </h2>
                </div>
            </div>

            <section class="mb-8 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100 md:p-5">
                <div class="grid gap-4 md:grid-cols-4">
                    <input
                        v-model="filter.search"
                        type="text"
                        placeholder="Cari produk..."
                        class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-400 focus:bg-white"
                    >

                    <select
                        v-model="filter.category"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-400 focus:bg-white"
                    >
                        <option value="">Semua Kategori</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>

                    <select
                        v-model="filter.sort"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-emerald-400 focus:bg-white"
                    >
                        <option value="">Urutkan</option>
                        <option value="price_low">Harga Termurah</option>
                        <option value="price_high">Harga Termahal</option>
                        <option value="best_seller">Terlaris</option>
                    </select>

                    <div class="flex gap-2">
                        <button
                            @click="applyFilter"
                            class="flex-1 rounded-xl bg-emerald-600 px-4 py-3 font-medium text-white transition hover:bg-emerald-700"
                        >
                            Terapkan
                        </button>

                        <button
                            @click="resetFilter"
                            class="rounded-xl bg-slate-200 px-4 py-3 font-medium text-slate-700 transition hover:bg-slate-300"
                        >
                            Reset
                        </button>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div
                    v-for="product in products.data"
                    :key="product.id"
                    class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-100 transition duration-200 hover:-translate-y-1 hover:shadow-xl"
                >
                    <div class="relative overflow-hidden">
                        <img
                            :src="'/storage/' + product.image"
                            class="h-56 w-full object-cover transition duration-300 group-hover:scale-105"
                        />
                        <span class="absolute right-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-emerald-700 shadow-sm">
                            {{ product.category?.name || 'Kategori' }}
                        </span>
                    </div>

                    <div class="space-y-3 p-4">
                        <div>
                            <h3 class="line-clamp-2 text-lg font-bold text-slate-800">
                                {{ product.name }}
                            </h3>
                        </div>

                        <p class="text-xl font-bold text-emerald-600">
                            Rp {{ formatCurrency(product.price) }}
                        </p>

                        <div class="flex items-center justify-between text-sm text-slate-500">
                            <span>Terjual</span>
                            <span class="font-medium text-slate-700">
                                {{ product.sold_count || 0 }}
                            </span>

                            <p class="text-sm text-pink-600 font-semibold">
    ❤️ {{ product.wishlists_count || 0 }} Wishlist
</p>
                        </div>

       
                        <Link
                            :href="route('marketplace.show', product.id)"
                            class="mt-2 block rounded-xl bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-700"
                        >
                            Lihat Detail
                        </Link>
                    </div>
                </div>
            </section>

            <div v-if="products.links?.length" class="mt-8 flex flex-wrap items-center justify-center gap-2">
                <Link
                    v-for="link in products.links"
                    :key="link.label"
                    :href="link.url ?? '#'
                    "
                    v-html="link.label"
                    class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-emerald-400 hover:text-emerald-600"
                    :class="{
                        'bg-emerald-600 text-white border-emerald-600 hover:text-white': link.active,
                    }"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    products: { type: Array, default: () => [] },
})

const formatCurrency = (value) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(Number(value || 0))

const productImage = (image) =>
    image ? `/storage/${image}` : 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=900&q=80'

const highlightTags = ['Material daur ulang', 'Hemat biaya', 'Ekologis', 'Produk unggulan']
</script>

<template>
    <Head title="Marketplace Lumira" />

    <div class="min-h-screen bg-[#f5faf6] text-slate-800">
        <header class="relative overflow-hidden bg-gradient-to-br from-[#edf9ee] via-white to-[#f3faf5] text-slate-800">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(12,124,67,0.08),_transparent_30%)]"></div>
            <div class="relative mx-auto max-w-7xl px-6 py-10 lg:px-8">
                <nav class="mb-8 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#0c7c43] to-[#0b2617] text-xl font-black text-white shadow-lg shadow-green-900/15">L</div>
                        <div>
                            <p class="text-lg font-black tracking-[0.22em] text-[#0b2617]">LUMIRA</p>
                            <p class="text-[10px] uppercase tracking-[0.25em] text-slate-500">Marketplace</p>
                        </div>
                    </div>
                    <Link href="/dashboard" class="rounded-full border border-green-200 bg-white px-4 py-2 text-sm font-bold text-[#0c7c43] shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        Kembali ke dashboard
                    </Link>
                </nav>

                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.28em] text-[#0c7c43]">Sampah jadi peluang</p>
                    <h1 class="mt-4 text-4xl font-black leading-tight text-[#0b2617] md:text-5xl">
                        Marketplace <span class="text-[#0c7c43]">barang daur ulang</span>
                    </h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-slate-600 md:text-lg">
                        Temukan produk berkualitas, ramah lingkungan, dan terjangkau untuk kebutuhan rumah, usaha, maupun komunitas Anda.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <span v-for="tag in highlightTags" :key="tag" class="rounded-full bg-white px-3 py-1.5 text-xs font-bold text-[#0c7c43] shadow-sm ring-1 ring-green-100">
                            {{ tag }}
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-10 lg:px-8">
            <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-[#0c7c43]">Produk terbaru</p>
                    <h2 class="mt-2 text-3xl font-black text-[#0b2617]">Pilih item favorit Anda</h2>
                </div>
                <div class="rounded-full bg-white px-4 py-2 text-sm font-bold text-slate-600 shadow-sm ring-1 ring-slate-200">
                    {{ products.length }} item tersedia
                </div>
            </div>

            <div v-if="products.length === 0" class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-2xl text-[#0c7c43]">
                    <i class="fas fa-store"></i>
                </div>
                <h3 class="mt-5 text-2xl font-black text-slate-900">Belum ada produk</h3>
                <p class="mt-2 text-slate-500">Produk yang baru ditambahkan akan muncul di sini.</p>
            </div>

            <div v-else class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <Link
                    v-for="product in products"
                    :key="product.id"
                    :href="`/marketplace/${product.id}`"
                    class="group overflow-hidden rounded-[1.75rem] bg-white shadow-[0_16px_40px_rgba(15,23,42,0.08)] ring-1 ring-slate-200 transition duration-300 hover:-translate-y-2 hover:shadow-[0_28px_60px_rgba(12,124,67,0.18)]"
                >
                    <div class="relative overflow-hidden">
                        <img
                            :src="productImage(product.image)"
                            :alt="product.name"
                            class="h-64 w-full object-cover transition duration-500 group-hover:scale-105"
                        >
                        <span class="absolute right-4 top-4 rounded-full bg-[#0c7c43] px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-white shadow-lg">
                            Baru
                        </span>
                    </div>

                    <div class="space-y-4 p-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ product.store?.name || 'Store' }}</p>
                            <h3 class="mt-2 line-clamp-2 text-xl font-black text-slate-900">{{ product.name }}</h3>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-2xl font-black text-[#0c7c43]">{{ formatCurrency(product.price) }}</p>
                            <span class="rounded-full bg-[#edf9ee] px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-[#0c7c43]">
                                {{ product.stock || 0 }} stok
                            </span>
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-100 pt-3 text-sm text-slate-500">
                            <span><i class="fas fa-star mr-1 text-amber-400"></i>{{ Number(product.sold_count || 0) }} terjual</span>
                            <span class="font-bold text-slate-700">Lihat detail</span>
                        </div>
                    </div>
                </Link>
            </div>
        </main>
    </div>
</template>

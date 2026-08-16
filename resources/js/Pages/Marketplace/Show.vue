<script setup>
import { Head, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
})

const quantity = ref(1)
const selectedImage = ref(0)
const activeTab = ref('description')

const mainImage = computed(() => {
    const gallery = [
        props.product?.image,
        'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80',
    ]

    return gallery[selectedImage.value] ? `/storage/${gallery[selectedImage.value]}` : gallery[1]
})

const formatCurrency = (value) =>
    new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(Number(value || 0))

const totalPrice = computed(() => Number(props.product?.price || 0) * quantity.value)

const galleryImages = computed(() => {
    const list = []

    if (props.product?.image) {
        list.push(`/storage/${props.product.image}`)
    }

    list.push('https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80')
    list.push('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80')

    return [...new Set(list)]
})

const startChat = (productId) => {
    router.post(route('chat.start', productId))
}

const addToCart = (productId) => {
    router.post(route('cart.add', productId), {
        quantity: quantity.value,
    })
}
</script>

<template>
    <Head :title="product?.name || 'Detail Produk'" />

    <div class="min-h-screen bg-[#f5faf6] text-slate-800">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <nav class="mb-8 flex items-center gap-2 text-sm text-slate-500">
                <a href="/marketplace" class="font-semibold text-[#0c7c43] transition hover:text-[#0a6d3a]">Marketplace</a>
                <span>/</span>
                <span class="text-slate-700">{{ product?.category?.name || 'Produk' }}</span>
            </nav>

            <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-5">
                    <div class="overflow-hidden rounded-[2rem] bg-white p-3 shadow-[0_22px_60px_rgba(15,23,42,0.08)] ring-1 ring-slate-200">
                        <img
                            :src="mainImage"
                            :alt="product?.name"
                            class="h-[420px] w-full rounded-[1.5rem] object-cover md:h-[520px]"
                        />
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <button
                            v-for="(image, index) in galleryImages"
                            :key="image"
                            type="button"
                            @click="selectedImage = index"
                            class="overflow-hidden rounded-2xl border transition duration-200"
                            :class="selectedImage === index ? 'border-[#0c7c43] ring-4 ring-green-100' : 'border-slate-200 hover:border-slate-300'"
                        >
                            <img :src="image" :alt="product?.name" class="h-24 w-full object-cover" />
                        </button>
                    </div>
                </div>

                <aside class="rounded-[2rem] bg-white p-6 shadow-[0_22px_60px_rgba(15,23,42,0.08)] ring-1 ring-slate-200 lg:sticky lg:top-8 lg:h-fit">
                    <div class="flex items-center justify-between gap-3">
                        <span class="rounded-full bg-[#edf9ee] px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-[#0c7c43]">
                            {{ product?.category?.name || 'Produk' }}
                        </span>
                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-amber-700">
                            {{ product?.sold_count || 0 }} terjual
                        </span>
                    </div>

                    <h1 class="mt-5 text-3xl font-black leading-tight text-slate-900 md:text-4xl">
                        {{ product?.name }}
                    </h1>

                    <div class="mt-5 flex items-center gap-3">
                        <div class="flex items-center gap-1 text-amber-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-600">{{ product?.store?.rating ?? 0 }}/5</span>
                    </div>

                    <p class="mt-4 text-3xl font-black text-[#0c7c43]">
                        {{ formatCurrency(product?.price) }}
                    </p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-[1.25rem] bg-slate-50 p-3 ring-1 ring-slate-200">
                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Penjual</p>
                            <p class="mt-2 font-black text-slate-800">{{ product?.store?.name || 'Toko Lumira' }}</p>
                        </div>
                        <div class="rounded-[1.25rem] bg-slate-50 p-3 ring-1 ring-slate-200">
                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Stok</p>
                            <p class="mt-2 font-black text-slate-800">{{ product?.stock ?? 0 }} pcs</p>
                        </div>
                        <div class="rounded-[1.25rem] bg-emerald-50 p-3 ring-1 ring-emerald-100 sm:col-span-2">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-emerald-700">Pengiriman</p>
                                    <p class="mt-2 font-black text-emerald-700">Gratis ongkir</p>
                                </div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-lg text-emerald-600 shadow-sm">
                                    <i class="fas fa-truck"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="mb-2 block text-sm font-bold text-slate-700">Jumlah</label>
                        <div class="flex w-fit items-center rounded-2xl border border-slate-200 bg-slate-50 p-1">
                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="flex h-10 w-10 items-center justify-center rounded-xl text-xl font-bold text-slate-600 transition hover:bg-white">
                                −
                            </button>
                            <span class="w-12 text-center text-lg font-black text-slate-800">{{ quantity }}</span>
                            <button type="button" @click="quantity = quantity + 1" class="flex h-10 w-10 items-center justify-center rounded-xl text-xl font-bold text-slate-600 transition hover:bg-white">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 rounded-[1.5rem] bg-[#edf9ee] p-4 text-sm font-bold text-[#0c7c43] ring-1 ring-green-100">
                        Total: {{ formatCurrency(totalPrice) }}
                    </div>

                    <div v-if="$page.props.auth?.user?.role === 'user'" class="mt-6 space-y-3">
                        <button
                            @click="addToCart(product.id)"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-[#0c7c43] to-[#0b2617] px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-green-900/20 transition hover:-translate-y-0.5 hover:shadow-xl"
                        >
                            <i class="fas fa-shopping-cart"></i>
                            Tambah ke Keranjang
                        </button>

                        <button
                            @click="startChat(product.id)"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl border border-[#0c7c43] bg-[#edf9ee] px-5 py-3.5 text-sm font-black text-[#0c7c43] transition hover:bg-[#e1f5e7]"
                        >
                            <i class="fas fa-comments"></i>
                            Chat Penjual
                        </button>
                    </div>
                </aside>
            </div>

            <section class="mt-8 rounded-[2rem] bg-white p-6 shadow-[0_20px_50px_rgba(15,23,42,0.06)] ring-1 ring-slate-200 md:p-8">
                <div class="mb-6 grid gap-4 md:grid-cols-4">
                    <div class="rounded-[1.5rem] bg-[#f7faf7] p-4 ring-1 ring-slate-200">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Terjual</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ product?.sold_count || 0 }}</p>
                    </div>
                    <div class="rounded-[1.5rem] bg-[#fffaf0] p-4 ring-1 ring-amber-100">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-amber-700">Rating</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ product?.store?.rating ?? 0 }}</p>
                    </div>
                    <div class="rounded-[1.5rem] bg-[#edf9ee] p-4 ring-1 ring-emerald-100">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-emerald-700">Pengiriman</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">1-3 hari</p>
                    </div>
                    <div class="rounded-[1.5rem] bg-[#f3f4ff] p-4 ring-1 ring-indigo-100">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-indigo-700">Review</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ product?.store?.reviews?.length ?? 0 }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-4">
                    <button
                        type="button"
                        @click="activeTab = 'description'"
                        class="rounded-full px-4 py-2 text-sm font-bold transition"
                        :class="activeTab === 'description' ? 'bg-[#0c7c43] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    >
                        Deskripsi
                    </button>
                    <button
                        type="button"
                        @click="activeTab = 'reviews'"
                        class="rounded-full px-4 py-2 text-sm font-bold transition"
                        :class="activeTab === 'reviews' ? 'bg-[#0c7c43] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    >
                        Review
                    </button>
                    <button
                        type="button"
                        @click="activeTab = 'details'"
                        class="rounded-full px-4 py-2 text-sm font-bold transition"
                        :class="activeTab === 'details' ? 'bg-[#0c7c43] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    >
                        Detail produk
                    </button>
                </div>

                <div class="mt-6">
                    <div v-if="activeTab === 'description'" class="space-y-4 text-slate-600">
                        <p class="text-lg leading-8">
                            {{ product?.description || 'Deskripsi produk belum tersedia.' }}
                        </p>
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="rounded-2xl bg-[#f8faf8] p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Kualitas</p>
                                <p class="mt-2 font-bold text-slate-800">Dipilih dengan cermat</p>
                            </div>
                            <div class="rounded-2xl bg-[#f8faf8] p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Bahan</p>
                                <p class="mt-2 font-bold text-slate-800">Daur ulang & tahan lama</p>
                            </div>
                            <div class="rounded-2xl bg-[#f8faf8] p-4 ring-1 ring-slate-200">
                                <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Dukungan</p>
                                <p class="mt-2 font-bold text-slate-800">Chat cepat dengan penjual</p>
                            </div>
                        </div>
                    </div>

                    <div v-else-if="activeTab === 'reviews'" class="space-y-4">
                        <div v-if="product?.store?.reviews?.length" class="space-y-4">
                            <div
                                v-for="review in product.store.reviews"
                                :key="review.id"
                                class="rounded-[1.5rem] bg-slate-50 p-4 ring-1 ring-slate-200"
                            >
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-black text-slate-900">{{ review.user?.name }}</p>
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">⭐ {{ review.rating }}/5</span>
                                </div>
                                <p class="mt-3 text-sm leading-7 text-slate-600">{{ review.comment }}</p>
                            </div>
                        </div>
                        <div v-else class="rounded-[1.5rem] bg-slate-50 p-8 text-center text-slate-500 ring-1 ring-slate-200">
                            Belum ada review untuk produk ini.
                        </div>
                    </div>

                    <div v-else class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-[1.5rem] bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Kategori</p>
                            <p class="mt-2 text-lg font-black text-slate-800">{{ product?.category?.name || '-' }}</p>
                        </div>
                        <div class="rounded-[1.5rem] bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Toko</p>
                            <p class="mt-2 text-lg font-black text-slate-800">{{ product?.store?.name || '-' }}</p>
                        </div>
                        <div class="rounded-[1.5rem] bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Rating toko</p>
                            <p class="mt-2 text-lg font-black text-slate-800">{{ product?.store?.rating ?? 0 }}/5</p>
                        </div>
                        <div class="rounded-[1.5rem] bg-slate-50 p-4 ring-1 ring-slate-200">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-500">Total review</p>
                            <p class="mt-2 text-lg font-black text-slate-800">{{ product?.store?.reviews?.length ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

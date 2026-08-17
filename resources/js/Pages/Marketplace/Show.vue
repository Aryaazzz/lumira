<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
    isWishlisted: {
        type: Boolean,
        default: false,
    },
})


const selectedImage = ref(null)

const productReviews = computed(() => {
    return Array.isArray(props.product?.reviews) ? props.product.reviews : []
})

const formatPrice = (value) => {
    const number = Number(value ?? 0)

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(number)
}

const getImageUrl = (imagePath) => {
    if (!imagePath) {
        return 'https://placehold.co/1200x900/f3f4f6/64748b?text=No+Image'
    }

    return `/storage/${imagePath}`
}

const openImage = (imagePath) => {
    selectedImage.value = getImageUrl(imagePath)
}

const closeImage = () => {
    selectedImage.value = null
}

const startChat = (productId) => {
    router.post(route('chat.start', productId), {}, {
        preserveScroll: true,
    })
}

const addToCart = () => {
    router.post(route('cart.add', props.product?.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            window.alert('Produk berhasil ditambahkan ke keranjang.')
        },
        onError: () => {
            window.alert('Gagal menambahkan produk ke keranjang.')
        },
    })
}

const toggleWishlist = () => {
    const productId = props.product?.id

    if (!productId) {
        return
    }

    if (props.isWishlisted) {
        router.delete(route('wishlist.destroy', productId), {
            preserveScroll: true,
        })
        return
    }

    router.post(route('wishlist.store', productId), {}, {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head :title="props.product?.name || 'Produk'" />

    <div class="min-h-screen bg-slate-100">
        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="grid gap-8 lg:grid-cols-[1.4fr_0.9fr]">
                        <div>
                            <button
                                type="button"
                                @click="openImage(props.product?.image)"
                                class="block w-full overflow-hidden rounded-2xl shadow-sm ring-1 ring-slate-200 transition hover:opacity-95"
                            >
                                <img
                                    :src="getImageUrl(props.product?.image)"
                                    alt="Produk"
                                    class="h-[360px] w-full object-cover sm:h-[420px]"
                                >
                            </button>

                            <div
                                v-if="props.product?.images?.length"
                                class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4"
                            >
                                <button
                                    v-for="image in props.product.images"
                                    :key="image.id"
                                    type="button"
                                    @click="openImage(image.image)"
                                    class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm transition hover:border-slate-300 hover:shadow-md"
                                >
                                    <img
                                        :src="getImageUrl(image.image)"
                                        alt="Gallery produk"
                                        class="h-24 w-full object-cover sm:h-28"
                                    >
                                </button>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <p class="text-sm font-medium uppercase tracking-wide text-green-600">
                                    {{ props.product?.category?.name || 'Kategori' }}
                                </p>
                                <h1 class="mt-2 text-3xl font-bold text-slate-800 sm:text-4xl">
                                    {{ props.product?.name || 'Nama produk' }}
                                </h1>
                            </div>

                            <div class="rounded-2xl bg-green-50 p-4">
                                <p class="text-sm text-green-700">Harga</p>
                                <p class="mt-1 text-3xl font-bold text-green-700">
                                    {{ formatPrice(props.product?.price) }}
                                </p>
                            </div>

                            <div class="grid gap-3 text-sm text-slate-600 sm:grid-cols-2">
                                <div class="rounded-xl bg-slate-50 p-3">
                                    <span class="block text-slate-500">Toko</span>
                                    <span class="mt-1 block font-semibold text-slate-700">
                                        {{ props.product?.store?.name || 'Toko belum tersedia' }}
                                    </span>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-3">
                                    <span class="block text-slate-500">Terjual</span>
                                    <span class="mt-1 block font-semibold text-slate-700">
                                        {{ props.product?.sold_count ?? 0 }} item
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button
                                    @click="startChat(props.product?.id)"
                                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                                >
                                    Chat Penjual
                                </button>

                                <button
                                    @click="addToCart"
                                    class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
                                >
                                    Tambah ke Keranjang
                                </button>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button
                                    v-if="!props.isWishlisted"
                                    @click="toggleWishlist"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110"
                                >
                                    <span>❤️</span>
                                    <span>Wishlist</span>
                                </button>

                                <button
                                    v-else
                                    @click="toggleWishlist"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110"
                                >
                                    <span>💔</span>
                                    <span>Hapus Wishlist</span>
                                </button>

                                <Link
                                    v-if="props.product?.store?.slug"
                                    :href="route('store.show', props.product.store.slug)"
                                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50"
                                >
                                    Kunjungi Toko
                                </Link>
                            </div>

                            <div class="rounded-xl border border-pink-100 bg-pink-50 px-4 py-3 text-sm text-pink-700">
                                ❤️ Disimpan {{ props.product?.wishlists_count ?? 0 }} pengguna
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h2 class="text-xl font-bold text-slate-800">Deskripsi</h2>
                            <p class="mt-3 leading-7 text-slate-600">
                                {{ props.product?.description || 'Belum ada deskripsi untuk produk ini.' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                            <h2 class="text-xl font-bold text-slate-800">Rating Toko</h2>
                            <div class="mt-3 flex items-center gap-2 text-amber-600">
                                <span class="text-2xl">⭐</span>
                                <span class="text-lg font-bold">
                                    {{ props.product?.store?.rating ?? 0 }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">
                                Total review: {{ productReviews.length }}
                            </p>
                        </div>
                    </div>

                    <div
                        v-if="productReviews.length"
                        class="mt-8"
                    >
                        <h2 class="mb-4 text-xl font-bold text-slate-800">Review Pembeli</h2>
                        <div class="space-y-4">
                            <div
                                v-for="review in productReviews"
                                :key="review.id"
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-4"
                            >
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-semibold text-slate-800">
                                        {{ review.user?.name || 'Pembeli' }}
                                    </p>
                                    <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        ⭐ {{ review.rating ?? 0 }}/5
                                    </span>
                                </div>
                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    {{ review.comment || 'Tidak ada komentar.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        v-if="selectedImage"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4"
        @click.self="closeImage"
    >
        <div class="relative max-h-[90vh] max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <button
                type="button"
                @click="closeImage"
                class="absolute right-3 top-3 z-10 rounded-full bg-white/80 px-2.5 py-1 text-sm font-bold text-slate-700 shadow hover:bg-white"
            >
                ✕
            </button>
            <img
                :src="selectedImage"
                alt="Preview produk"
                class="max-h-[90vh] w-auto max-w-full object-contain"
            >
        </div>
    </div>
</template>

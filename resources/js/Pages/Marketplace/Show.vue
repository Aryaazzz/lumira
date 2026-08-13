<script setup>
import { Head, router } from '@inertiajs/vue3'

defineProps({
    product: Object
})

const startChat = (productId) => {
    router.post(
        route('chat.start', productId)
    )
}
</script>

<template>
    <Head :title="product.name" />

    <div class="min-h-screen bg-slate-100">

        <div class="max-w-6xl mx-auto py-10 px-6">

            <div class="bg-white rounded-2xl shadow p-6">

                <img
                    :src="`/storage/${product.image}`"
                    class="w-full h-96 object-cover rounded-xl"
                >

                <h1 class="text-4xl font-bold mt-6">
                    {{ product.name }}
                </h1>

                <p class="text-2xl text-green-700 font-bold mt-4">
                    Rp {{ product.price }}
                </p>

                <div class="mt-4 text-gray-600">
                    Kategori:
                    {{ product.category?.name }}
                </div>

                <div class="mt-2 text-gray-600">
                    Toko:
                    {{ product.store?.name }}
                </div>

                <div class="mt-2 text-gray-600">
                    Terjual:
                    {{ product.sold_count }}
                </div>

                <div class="mt-8">
                    <h2 class="font-bold text-xl mb-3">
                        Deskripsi
                    </h2>

                    <p>
                        {{ product.description }}
                    </p>
                </div>

                <div class="mt-8">

    <h2 class="font-bold text-xl mb-3">
        Rating Toko
    </h2>

    <div class="bg-yellow-50 p-4 rounded">

        <p class="font-bold">
            ⭐ {{ product.store?.rating ?? 0 }}
        </p>

        <p>
            Total Review:
            {{ product.store?.reviews?.length ?? 0 }}
        </p>

    </div>

</div>

<div
    v-if="product.store?.reviews?.length"
    class="mt-6"
>

    <h2 class="font-bold text-xl mb-3">
        Review Pembeli
    </h2>

    <div
        v-for="review in product.store.reviews"
        :key="review.id"
        class="bg-gray-100 p-4 rounded mb-3"
    >

        <p class="font-bold">
            {{ review.user?.name }}
        </p>

        <p>
            ⭐ {{ review.rating }}/5
        </p>

        <p>
            {{ review.comment }}
        </p>

    </div>

</div>

                <div class="mt-8 flex gap-3">

                    <button
                        @click="startChat(product.id)"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg"
                    >
                        Chat Penjual
                    </button>

                    <button
                        @click="
                            router.post(
                                route('cart.add', product.id)
                            )
                        "
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg"
                    >
                        Tambah ke Keranjang
                    </button>

                </div>

            </div>

        </div>

    </div>
</template>
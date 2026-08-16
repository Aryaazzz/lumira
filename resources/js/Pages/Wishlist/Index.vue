<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
    wishlists: Array,
})

const removeWishlist = (productId) => {
    if (
        confirm(
            'Hapus produk dari wishlist?'
        )
    ) {
        router.delete(
            route(
                'wishlist.destroy',
                productId
            )
        )
    }
}

const formatPrice = (price) => {
    return Number(
        price || 0
    ).toLocaleString('id-ID')
}
</script>

<template>
    <Head title="Wishlist Saya" />

    <AuthenticatedLayout>

        <div
            class="max-w-7xl mx-auto py-8 px-4"
        >

            <div
                class="flex items-center justify-between mb-8"
            >
                <div>
                    <h1
                        class="text-3xl font-bold"
                    >
                        ❤️ Wishlist Saya
                    </h1>

                    <p
                        class="text-gray-500 mt-2"
                    >
                        Produk yang ingin kamu beli nanti.
                    </p>
                </div>

                <div
                    class="bg-pink-100 text-pink-700 px-4 py-2 rounded-xl font-bold"
                >
                    {{ wishlists.length }}
                    Produk
                </div>
            </div>

            <div
                v-if="wishlists.length === 0"
                class="bg-white rounded-2xl shadow p-12 text-center"
            >
                <div class="text-6xl">
                    💔
                </div>

                <h2
                    class="text-2xl font-bold mt-4"
                >
                    Wishlist Masih Kosong
                </h2>

                <p
                    class="text-gray-500 mt-2"
                >
                    Tambahkan produk favoritmu ke wishlist.
                </p>

                <Link
                    :href="route('marketplace')"
                    class="inline-block mt-6 bg-green-600 text-white px-6 py-3 rounded-xl"
                >
                    Ke Marketplace
                </Link>
            </div>

            <div
                v-else
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
            >

                <div
                    v-for="item in wishlists"
                    :key="item.id"
                    class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-xl transition"
                >

                    <img
                        :src="`/storage/${item.product.image}`"
                        class="w-full h-56 object-cover"
                    >

                    <div class="p-4">

                        <h3
                            class="font-bold text-lg line-clamp-2"
                        >
                            {{ item.product.name }}
                        </h3>

                        <p
                            class="text-sm text-gray-500 mt-1"
                        >
                            {{
                                item.product.category?.name
                            }}
                        </p>

                        <p
                            class="text-sm text-gray-500 mt-1"
                        >
                            🏪
                            {{
                                item.product.store?.name
                            }}
                        </p>

                        <p
                            class="text-green-600 font-bold text-xl mt-3"
                        >
                            Rp
                            {{
                                formatPrice(
                                    item.product.price
                                )
                            }}
                        </p>

                        <div
                            class="flex gap-2 mt-4"
                        >

                            <Link
                                :href="
                                    route(
                                        'marketplace.show',
                                        item.product.id
                                    )
                                "
                                class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg"
                            >
                                Detail
                            </Link>

                            <button
                                @click="
                                    removeWishlist(
                                        item.product.id
                                    )
                                "
                                class="bg-red-600 text-white px-4 rounded-lg"
                            >
                                ✕
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
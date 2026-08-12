<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    products: Array
})
</script>

<template>
    <Head title="Marketplace Lumira" />

    <div class="min-h-screen bg-slate-100">

        <div class="bg-green-700 text-white py-10">

            <div class="max-w-7xl mx-auto px-6">

                <h1 class="text-5xl font-bold">
                    Lumira
                </h1>

                <p class="mt-3 text-lg">
                    Marketplace Sampah Daur Ulang Indonesia
                </p>

            </div>

        </div>

        <div class="max-w-7xl mx-auto px-6 py-10">

            <h2 class="text-2xl font-bold mb-8">
                Produk Terbaru
            </h2>

            <div class="grid md:grid-cols-4 gap-6">

                <Link
                    v-for="product in products"
                    :key="product.id"
                    :href="`/marketplace/${product.id}`"
                    class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition"
                >

                    <img
                        :src="`/storage/${product.image}`"
                        class="w-full h-56 object-cover"
                    >

                    <div class="p-4">

                        <h3 class="font-bold">
                            {{ product.name }}
                        </h3>

                        <p class="text-green-700 font-bold mt-2">
                            Rp {{ product.price }}
                        </p>

                        <p class="text-sm text-gray-500 mt-2">
                            {{ product.store?.name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Terjual {{ product.sold_count }}
                        </p>

                    </div>

                </Link>

            </div>

        </div>

    </div>
</template>
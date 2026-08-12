<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({
    product: Object
})
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

            </div>

        </div>

    </div>
</template>
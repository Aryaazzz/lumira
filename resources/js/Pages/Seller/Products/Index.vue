<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'

defineProps({
    products: Array
})

const removeProduct = (id) => {
    if (confirm('Hapus produk?')) {
        router.delete(`/seller/products/${id}`)
    }
}
</script>

<template>
    <Head title="Produk Saya" />

    <AuthenticatedLayout>

        <div class="p-8">

            <div class="flex justify-between mb-6">

                <h1 class="text-2xl font-bold">
                    Produk Saya
                </h1>

                <Link
                    href="/seller/products/create"
                    class="bg-green-600 text-white px-4 py-2 rounded"
                >
                    Tambah Produk
                </Link>

            </div>

            <div class="grid md:grid-cols-3 gap-6">

                <div
                    v-for="product in products"
                    :key="product.id"
                    class="bg-white rounded-xl shadow p-4"
                >

                    <img
                        :src="`/storage/${product.image}`"
                        class="w-full h-48 object-cover rounded"
                    >

                    <h3 class="font-bold mt-3">
                        {{ product.name }}
                    </h3>

                    <p>
                        Rp {{ product.price }}
                    </p>

                    <p>
                        Stock : {{ product.stock }}
                    </p>

                    <p>
                        Terjual : {{ product.sold_count }}
                    </p>

                    <div class="mt-3 flex gap-2">
                        <Link
                            :href="route('seller.products.edit', product.id)"
                            class="bg-blue-600 text-white px-3 py-2 rounded"
                        >
                            Edit
                        </Link>

                        <button
                            @click="removeProduct(product.id)"
                            class="bg-red-600 text-white px-3 py-2 rounded"
                        >
                            Hapus
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
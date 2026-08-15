<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    products: Array,
})

const hideProduct = (id) => {

    router.post(
        route(
            'admin.products.hide',
            id
        )
    )
}

const showProduct = (id) => {

    router.post(
        route(
            'admin.products.show',
            id
        )
    )
}

const deleteProduct = (id) => {

    if (
        !confirm(
            'Hapus produk ini?'
        )
    ) {
        return
    }

    router.delete(
        route(
            'admin.products.destroy',
            id
        )
    )
}
</script>

<template>
    <Head title="Kelola Produk" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Kelola Produk
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div
                class="bg-white rounded-lg shadow p-6"
            >

                <table class="w-full">

                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3">
                                Produk
                            </th>

                            <th class="text-left py-3">
                                Kategori
                            </th>

                            <th class="text-left py-3">
                                Seller
                            </th>

                            <th class="text-left py-3">
                                Harga
                            </th>

                            <th class="text-left py-3">
                                Status
                            </th>

                            <th class="text-left py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr
                            v-for="product in products"
                            :key="product.id"
                            class="border-b"
                        >
                            <td class="py-3">
                                {{ product.name }}
                            </td>

                            <td class="py-3">
                                {{ product.category?.name }}
                            </td>

                            <td class="py-3">
                                {{ product.store?.name }}
                            </td>

                            <td class="py-3">
                                Rp {{ product.price }}
                            </td>

                            <td class="py-3">

                                <span
                                    v-if="product.is_hidden"
                                    class="text-red-600 font-semibold"
                                >
                                    Disembunyikan
                                </span>

                                <span
                                    v-else
                                    class="text-green-600 font-semibold"
                                >
                                    Aktif
                                </span>

                            </td>

                            <td class="py-3 flex gap-2">

                                <button
                                    v-if="!product.is_hidden"
                                    @click="hideProduct(product.id)"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded"
                                >
                                    Hide
                                </button>

                                <button
                                    v-else
                                    @click="showProduct(product.id)"
                                    class="bg-green-600 text-white px-3 py-1 rounded"
                                >
                                    Show
                                </button>

                                <button
                                    @click="deleteProduct(product.id)"
                                    class="bg-red-600 text-white px-3 py-1 rounded"
                                >
                                    Hapus
                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
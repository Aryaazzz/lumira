<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
    product: Object,
    buyers: Array,
})

const startChatWithBuyer = (buyerId) => {
    if (!confirm('Mulai chat dengan pembeli ini?')) return

    router.post(route('chat.startWith', [props.product.id, buyerId]))
}

const removeProduct = (id) => {
    if (confirm('Hapus produk?')) {
        router.delete(`/seller/products/${id}`)
    }
}
</script>

<template>
    <Head :title="product.name" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto py-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex gap-6">
                    <img :src="`/storage/${product.image}`" class="w-48 h-48 object-cover rounded" />

                    <div class="flex-1">
                        <h1 class="text-2xl font-bold">{{ product.name }}</h1>
                        <p class="text-lg text-green-700 font-bold mt-2">Rp {{ product.price }}</p>
                        <div class="mt-2 text-gray-600">Kategori: {{ product.category?.name }}</div>
                        <div class="mt-2 text-gray-600">Stock: {{ product.stock }}</div>

                        <div class="mt-6 flex gap-2">
                            <Link :href="route('seller.products.edit', product.id)" class="bg-blue-600 text-white px-4 py-2 rounded">Edit</Link>

                            <button @click="startChatWithBuyer(buyers[0]?.id)" v-if="buyers && buyers.length" class="bg-indigo-600 text-white px-4 py-2 rounded">Chat Pembeli</button>

                            <button @click="removeProduct(product.id)" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
                        </div>

                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-bold">Deskripsi</h3>
                    <p class="mt-2 whitespace-pre-wrap">{{ product.description }}</p>
                </div>

                <div v-if="buyers && buyers.length" class="mt-6">
                    <h3 class="font-bold">Pembeli yang membeli produk ini</h3>
                    <div class="mt-3 space-y-3">
                        <div v-for="buyer in buyers" :key="buyer.id" class="flex items-center justify-between p-3 border rounded">
                            <div>
                                <div class="font-semibold">{{ buyer.name }}</div>
                                <div class="text-sm text-gray-500">{{ buyer.email }}</div>
                            </div>

                            <div class="flex gap-2">
                                <button @click="startChatWithBuyer(buyer.id)" class="bg-indigo-600 text-white px-3 py-2 rounded">Chat</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

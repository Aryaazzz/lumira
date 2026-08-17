<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    product: Object,
    categories: Array,
})

const sortedCategories = computed(() => {
    return [...props.categories].sort((a, b) => a.id - b.id)
})

const form = useForm({
    name: props.product.name ?? '',
    category_id: props.product.category_id ?? '',
    description: props.product.description ?? '',
    price: props.product.price ?? '',
    stock: props.product.stock ?? '',
    status: props.product.status ?? 'active',
    image: null,
})

function submit() {
    form.put(route('seller.products.update', props.product.id), {
        forceFormData: true,
    })
}
</script>

<template>
    <Head title="Edit Produk" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">
                    Edit Produk
                </h1>

                <Link
                    :href="route('seller.products.index')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    Kembali
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <input
                    v-model="form.name"
                    placeholder="Nama Produk"
                    class="w-full border rounded p-3"
                >

                <select
                    v-model="form.category_id"
                    class="w-full border rounded p-3"
                >
                    <option value="">
                        Pilih Kategori
                    </option>

                    <option
                        v-for="category in sortedCategories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>

                <textarea
                    v-model="form.description"
                    rows="5"
                    class="w-full border rounded p-3"
                ></textarea>

                <input
                    v-model="form.price"
                    type="number"
                    placeholder="Harga"
                    class="w-full border rounded p-3"
                >

                <input
                    v-model="form.stock"
                    type="number"
                    placeholder="Stock"
                    class="w-full border rounded p-3"
                >

                <select
                    v-model="form.status"
                    class="w-full border rounded p-3"
                >
                    <option value="active">Active</option>
                    <option value="sold_out">Sold Out</option>
                </select>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Gambar Produk
                    </label>

                    <img
                        v-if="product.image"
                        :src="`/storage/${product.image}`"
                        class="w-28 h-28 object-cover rounded border"
                    >

                    <input
                        type="file"
                        @change="form.image = $event.target.files[0]"
                        class="w-full border rounded p-3"
                    >
                </div>

                <div v-if="form.errors.image" class="text-red-500">
                    {{ form.errors.image }}
                </div>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded"
                >
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

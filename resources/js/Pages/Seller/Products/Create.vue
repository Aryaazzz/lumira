<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

defineProps({
    categories: Array
})

const form = useForm({
    name: '',
    category_id: '',
    description: '',
    price: '',
    stock: '',
    image: null,
})

function submit() {
    form.post(
        route('seller.products.store'),
        {
            forceFormData: true,
        }
    )
}
</script>

<template>
    <Head title="Tambah Produk" />

    <AuthenticatedLayout>

        <div class="max-w-2xl mx-auto p-8">

            <h1 class="text-2xl font-bold mb-6">
                Tambah Produk
            </h1>

            <form
                @submit.prevent="submit"
                class="space-y-4"
            >

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
                        v-for="category in categories"
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

                <input
                    type="file"
                    @change="form.image = $event.target.files[0]"
                    class="w-full border rounded p-3"
                >

                <div
                    v-if="form.errors.image"
                    class="text-red-500"
                >
                    {{ form.errors.image }}
                </div>

                <button
                    type="submit"
                    class="bg-green-600 text-white px-6 py-3 rounded"
                >
                    Simpan Produk
                </button>

            </form>

        </div>

    </AuthenticatedLayout>
</template>
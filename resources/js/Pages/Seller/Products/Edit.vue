<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    name: props.product?.name ?? '',
    category_id: props.product?.category_id ?? '',
    description: props.product?.description ?? '',
    price: props.product?.price ?? '',
    stock: props.product?.stock ?? '',
    status: props.product?.status ?? 'active',
    image: null,
    images: [],
})

const handleMainImage = (event) => {
    form.image = event.target.files?.[0] ?? null
}

const handleGallery = (event) => {
    form.images = Array.from(event.target.files || [])
}

const submit = () => {
    form.put(route('seller.products.update', props.product.id), {
        forceFormData: true,
    })
}
</script>

<template>
    <Head title="Edit Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800">Edit Produk</h2>
        </template>

        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Form Edit Produk</h1>
                        <p class="text-sm text-gray-500 mt-1">Perbarui detail produk agar tetap relevan dan siap dijual kembali.</p>
                    </div>

                    <Link
                        :href="route('seller.products.index')"
                        class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:text-gray-900"
                    >
                        Kembali
                    </Link>
                </div>

                <form @submit.prevent="submit" class="p-6 sm:p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Contoh: Sepatu Running Premium"
                            />
                            <div v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select
                                id="category"
                                v-model="form.category_id"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="">Pilih Kategori</option>
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.category_id" class="mt-1 text-sm text-red-500">{{ form.errors.category_id }}</div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="5"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Jelaskan detail produk, bahan, manfaat, dan fitur utama..."
                            />
                            <div v-if="form.errors.description" class="mt-1 text-sm text-red-500">{{ form.errors.description }}</div>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                            <input
                                id="price"
                                v-model="form.price"
                                type="number"
                                min="0"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="150000"
                            />
                            <div v-if="form.errors.price" class="mt-1 text-sm text-red-500">{{ form.errors.price }}</div>
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input
                                id="stock"
                                v-model="form.stock"
                                type="number"
                                min="0"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="10"
                            />
                            <div v-if="form.errors.stock" class="mt-1 text-sm text-red-500">{{ form.errors.stock }}</div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select
                                id="status"
                                v-model="form.status"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="active">Aktif</option>
                                <option value="sold_out">Habis Terjual</option>
                            </select>
                            <div v-if="form.errors.status" class="mt-1 text-sm text-red-500">{{ form.errors.status }}</div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Utama</label>

                            <div v-if="product.image" class="mb-4">
                                <img
                                    :src="`/storage/${product.image}`"
                                    class="h-32 w-32 object-cover rounded-xl border border-gray-200 shadow-sm"
                                />
                            </div>

                            <input
                                type="file"
                                accept="image/*"
                                @change="handleMainImage"
                                class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-green-600 file:text-white file:font-medium file:cursor-pointer hover:file:bg-green-700"
                            />
                            <p v-if="form.image" class="mt-2 text-sm text-green-600">{{ form.image.name }} dipilih</p>
                            <div v-if="form.errors.image" class="mt-1 text-sm text-red-500">{{ form.errors.image }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Gallery</label>

                            <div v-if="product.images?.length" class="mb-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <img
                                    v-for="image in product.images"
                                    :key="image.id"
                                    :src="`/storage/${image.image}`"
                                    class="h-24 w-full object-cover rounded-xl border border-gray-200 shadow-sm"
                                />
                            </div>

                            <input
                                type="file"
                                multiple
                                accept="image/*"
                                @change="handleGallery"
                                class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-gray-700 file:text-white file:font-medium file:cursor-pointer hover:file:bg-gray-800"
                            />
                            <p class="text-sm text-gray-500 mt-2">Bisa pilih beberapa foto sekaligus untuk gallery produk.</p>
                            <div v-if="form.images.length" class="mt-2 text-sm text-green-600">
                                {{ form.images.length }} foto dipilih
                            </div>
                            <div v-if="form.errors.images" class="mt-1 text-sm text-red-500">{{ form.errors.images }}</div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 disabled:opacity-60 text-white px-6 py-3 rounded-xl font-medium transition shadow-sm"
                        >
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

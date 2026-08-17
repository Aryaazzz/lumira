<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    products: Array,
})

const hideProduct = (id) => {
    router.post(route('admin.products.hide', id))
}

const showProduct = (id) => {
    router.post(route('admin.products.show', id))
}

const deleteProduct = (id) => {
    if (!confirm('Hapus produk ini?')) {
        return
    }

    router.delete(route('admin.products.destroy', id))
}
</script>

<template>
    <Head title="Kelola Produk" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-indigo-600">Catalog</p>
                    <h2 class="text-xl font-bold text-slate-800">Kelola Produk</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Total Produk</p>
                    <p class="mt-3 text-3xl font-bold text-slate-800">{{ products?.length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-5 shadow-sm ring-1 ring-emerald-200">
                    <p class="text-sm text-emerald-700">Aktif</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">{{ products?.filter(item => !item.is_hidden).length ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-red-50 p-5 shadow-sm ring-1 ring-red-200">
                    <p class="text-sm text-red-700">Disembunyikan</p>
                    <p class="mt-3 text-3xl font-bold text-red-700">{{ products?.filter(item => item.is_hidden).length ?? 0 }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 p-5">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Produk</h3>
                </div>

                <div v-if="!products?.length" class="p-8 text-center text-slate-500">Belum ada produk.</div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-left text-slate-600">
                            <tr>
                                <th class="p-4">Produk</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Seller</th>
                                <th class="p-4">Harga</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.id" class="border-t border-slate-200">
                                <td class="p-4 font-medium text-slate-800">{{ product.name }}</td>
                                <td class="p-4 text-slate-700">{{ product.category?.name || '-' }}</td>
                                <td class="p-4 text-slate-700">{{ product.store?.name || '-' }}</td>
                                <td class="p-4 text-slate-700">Rp {{ Number(product.price || 0).toLocaleString('id-ID') }}</td>
                                <td class="p-4">
                                    <span v-if="product.is_hidden" class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Disembunyikan</span>
                                    <span v-else class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button v-if="!product.is_hidden" @click="hideProduct(product.id)" class="rounded-xl bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-600">Hide</button>
                                        <button v-else @click="showProduct(product.id)" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">Show</button>
                                        <button @click="deleteProduct(product.id)" class="rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

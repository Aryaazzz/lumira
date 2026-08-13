<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Dashboard User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">
                    Dashboard User
                </h2>

                <div class="flex gap-2">
                    <Link
                        :href="route('topup.index')"
                        class="px-4 py-2 bg-green-600 text-white rounded"
                    >
                        Top Up Saldo
                    </Link>

                    <Link
                        :href="route('orders.index')"
                        class="px-4 py-2 bg-blue-600 text-white rounded"
                    >
                        Pesanan Saya
                    </Link>

                    <Link
                        :href="route('notifications.index')"
                        class="px-4 py-2 bg-yellow-500 text-white rounded"
                    >
                        Notifikasi
                    </Link>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-8">
            <div class="bg-white rounded-lg shadow p-6">

                <h1 class="text-3xl font-bold">
                    Selamat Datang di Lumira
                </h1>

                <p class="mt-3 text-gray-600">
                    Marketplace Sampah Daur Ulang Indonesia
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">

                    <Link
                        :href="route('marketplace')"
                        class="bg-blue-500 text-white p-6 rounded-lg text-center hover:bg-blue-600"
                    >
                        <h3 class="font-bold text-lg">
                            Marketplace
                        </h3>

                        <p class="mt-2">
                            Lihat produk daur ulang
                        </p>
                    </Link>

                    <Link
                        :href="route('cart.index')"
                        class="bg-yellow-500 text-white p-6 rounded-lg text-center hover:bg-yellow-600"
                    >
                        <h3 class="font-bold text-lg">
                            Keranjang
                        </h3>

                        <p class="mt-2">
                            Produk yang akan dibeli
                        </p>
                    </Link>

                    <Link
                        :href="route('seller.apply')"
                        class="bg-green-500 text-white p-6 rounded-lg text-center hover:bg-green-600"
                    >
                        <h3 class="font-bold text-lg">
                            Daftar Seller
                        </h3>

                        <p class="mt-2">
                            Mulai berjualan di Lumira
                        </p>
                    </Link>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
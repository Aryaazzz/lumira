<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Seller Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Dashboard Seller
            </h2>
        </template>

        <div class="p-8">

            <div class="grid grid-cols-3 gap-4">

                <div class="bg-white p-5 rounded shadow">
                    <h3>Total Produk</h3>
                    <p class="text-3xl font-bold">0</p>
                </div>

                <div class="bg-white p-5 rounded shadow">
                    <h3>Total Penjualan</h3>
                    <p class="text-3xl font-bold">0</p>
                </div>

                <div class="bg-white p-5 rounded shadow">
                    <h3>Balance</h3>
                    <p class="text-3xl font-bold">
                        Rp 0
                    </p>
                </div>

            </div>
            <Link
    :href="route('seller.orders.index')"
    class="px-4 py-2 bg-blue-600 text-white rounded"
>
    Pesanan Masuk
</Link>

        </div>

    </AuthenticatedLayout>
</template>
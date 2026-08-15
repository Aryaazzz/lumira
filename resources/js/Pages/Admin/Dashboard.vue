
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    stats: Object,
    topSeller: Object,
    topProduct: Object,
    latestOrders: Array,
})
</script>

<template>
    <Head title="Dashboard Admin" />

    <AuthenticatedLayout>

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">
                    Dashboard Admin
                </h2>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <!-- MENU CEPAT -->

            <div class="flex flex-wrap gap-3 mb-8">

                <Link
                    :href="route('admin.seller.applications')"
                    class="bg-green-600 text-white px-4 py-2 rounded"
                >
                    Kelola Pengajuan Seller
                </Link>

                <Link
                    :href="route('admin.sellers.index')"
                    class="bg-red-600 text-white px-4 py-2 rounded"
                >
                    Kelola Seller
                </Link>

                <Link
                    :href="route('admin.topups.index')"
                    class="bg-yellow-500 text-white px-4 py-2 rounded"
                >
                    Kelola Top Up
                </Link>

                <Link
                    :href="route('admin.categories.index')"
                    class="bg-blue-600 text-white px-4 py-2 rounded"
                >
                    Kelola Kategori
                </Link>

                <Link
                    :href="route('admin.announcements.index')"
                    class="bg-purple-600 text-white px-4 py-2 rounded"
                >
                    Kelola Pengumuman
                </Link>

                <Link
                    :href="route('admin.products.index')"
                    class="bg-indigo-600 text-white px-4 py-2 rounded"
                >
                    Kelola Produk
                </Link>

            </div>

            <!-- STATISTIK -->

            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
            >

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Total User
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.users }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Total Seller
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.sellers }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Total Produk
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.products }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Total Order
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.orders }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Total Pendapatan
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        Rp {{ stats.revenue }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Top Up Pending
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.pendingTopups }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Pengajuan Seller
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.pendingSellerApplications }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500">
                        Produk Sold Out
                    </h3>

                    <p class="text-3xl font-bold mt-2">
                        {{ stats.soldOutProducts }}
                    </p>
                </div>

            </div>

            <!-- TOP SELLER & TOP PRODUCT -->

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8"
            >

                <div
                    class="bg-white p-6 rounded-lg shadow"
                >
                    <h3
                        class="font-bold text-lg mb-4"
                    >
                        🏆 Top Seller
                    </h3>

                    <div v-if="topSeller">

                        <p
                            class="text-xl font-semibold"
                        >
                            {{ topSeller.name }}
                        </p>

                        <p
                            class="text-gray-500 mt-2"
                        >
                            Total Sales:
                            {{ topSeller.total_sales }}
                        </p>

                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        Belum ada data seller.
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow"
                >
                    <h3
                        class="font-bold text-lg mb-4"
                    >
                        🔥 Produk Terlaris
                    </h3>

                    <div v-if="topProduct">

                        <p
                            class="text-xl font-semibold"
                        >
                            {{ topProduct.name }}
                        </p>

                        <p
                            class="text-gray-500 mt-2"
                        >
                            Terjual:
                            {{ topProduct.sold_count }}
                        </p>

                    </div>

                    <div
                        v-else
                        class="text-gray-500"
                    >
                        Belum ada data produk.
                    </div>
                </div>

            </div>

            <!-- PESANAN TERBARU -->

            <div
                class="bg-white p-6 rounded-lg shadow mt-8"
            >

                <h3
                    class="font-bold text-lg mb-4"
                >
                    Pesanan Terbaru
                </h3>

                <div
                    class="overflow-x-auto"
                >

                    <table
                        class="w-full"
                    >

                        <thead>

                            <tr
                                class="border-b"
                            >
                                <th class="text-left py-3">
                                    ID
                                </th>

                                <th class="text-left py-3">
                                    User
                                </th>

                                <th class="text-left py-3">
                                    Total
                                </th>

                                <th class="text-left py-3">
                                    Status
                                </th>

                                <th class="text-left py-3">
                                    Tanggal
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr
                                v-for="order in latestOrders"
                                :key="order.id"
                                class="border-b"
                            >

                                <td class="py-3">
                                    #{{ order.id }}
                                </td>

                                <td class="py-3">
                                    {{ order.user?.name }}
                                </td>

                                <td class="py-3">
                                    Rp {{ order.total_price }}
                                </td>

                                <td class="py-3">
                                    {{ order.status }}
                                </td>

                                <td class="py-3">
                                    {{ order.created_at }}
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>

</template>


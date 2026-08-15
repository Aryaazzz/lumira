
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    announcement: Object,
})
</script>

<template>
    <Head title="Dashboard Seller" />

    <AuthenticatedLayout>

        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        Dashboard Seller
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Kelola produk dan pesanan toko Anda
                    </p>
                </div>
            </div>
        </template>

        <!-- Announcement -->
        <div
            v-if="announcement"
            class="max-w-7xl mx-auto mt-6"
        >
            <div
                class="bg-yellow-100 border border-yellow-300 rounded-lg p-4"
            >
                <h3 class="font-bold text-lg">
                    📢 {{ announcement.title }}
                </h3>

                <p class="mt-2">
                    {{ announcement.content }}
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto py-8">

            <!-- Welcome Card -->
            <div
                class="bg-white rounded-xl shadow p-8 mb-8"
            >
                <h1
                    class="text-3xl font-bold"
                >
                    Selamat Datang Seller 👋
                </h1>

                <p
                    class="text-gray-600 mt-3"
                >
                    Kelola toko, produk, dan pesanan pelanggan
                    Anda melalui dashboard ini.
                </p>
            </div>

            <!-- Menu Seller -->
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-6"
            >

                <Link
                    :href="route('seller.products.index')"
                    class="bg-green-600 text-white p-6 rounded-xl text-center hover:bg-green-700 transition"
                >
                    <div class="text-4xl mb-3">
                        📦
                    </div>

                    <h3 class="font-bold text-lg">
                        Produk Saya
                    </h3>

                    <p class="mt-2 text-sm">
                        Kelola produk yang dijual
                    </p>
                </Link>

                <Link
                    :href="route('seller.products.create')"
                    class="bg-blue-600 text-white p-6 rounded-xl text-center hover:bg-blue-700 transition"
                >
                    <div class="text-4xl mb-3">
                        ➕
                    </div>

                    <h3 class="font-bold text-lg">
                        Tambah Produk
                    </h3>

                    <p class="mt-2 text-sm">
                        Tambahkan produk baru
                    </p>
                </Link>

                <Link
                    :href="route('seller.orders.index')"
                    class="bg-purple-600 text-white p-6 rounded-xl text-center hover:bg-purple-700 transition"
                >
                    <div class="text-4xl mb-3">
                        🛒
                    </div>

                    <h3 class="font-bold text-lg">
                        Pesanan Masuk
                    </h3>

                    <p class="mt-2 text-sm">
                        Lihat dan proses pesanan
                    </p>
                </Link>

            </div>

            <!-- Menu Tambahan -->
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6"
            >

                <Link
                    :href="route('marketplace')"
                    class="bg-orange-500 text-white p-6 rounded-xl text-center hover:bg-orange-600 transition"
                >
                    <div class="text-4xl mb-3">
                        🏪
                    </div>

                    <h3 class="font-bold text-lg">
                        Marketplace
                    </h3>

                    <p class="mt-2 text-sm">
                        Lihat semua produk
                    </p>
                </Link>

                <Link
                    :href="route('notifications.index')"
                    class="bg-yellow-500 text-white p-6 rounded-xl text-center hover:bg-yellow-600 transition"
                >
                    <div class="text-4xl mb-3">
                        🔔
                    </div>

                    <h3 class="font-bold text-lg">
                        Notifikasi
                    </h3>

                    <p class="mt-2 text-sm">
                        Cek aktivitas terbaru
                    </p>
                </Link>

                <Link
                    :href="route('profile.edit')"
                    class="bg-gray-700 text-white p-6 rounded-xl text-center hover:bg-gray-800 transition"
                >
                    <div class="text-4xl mb-3">
                        👤
                    </div>

                    <h3 class="font-bold text-lg">
                        Profil Saya
                    </h3>

                    <p class="mt-2 text-sm">
                        Edit profil akun
                    </p>
                </Link>

            </div>

        </div>

    </AuthenticatedLayout>
</template>

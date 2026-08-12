<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Dashboard Admin
            </h2>
        </template>

        <div class="p-8">

            <div class="bg-white rounded p-6 shadow">

                <h1 class="text-2xl font-bold">
                    Admin Panel Lumira
                </h1>

                <div class="mt-5">

                    <Link
                        :href="route('admin.seller.applications')"
                        class="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        Kelola Pengajuan Seller
                    </Link>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
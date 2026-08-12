<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="User Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Dashboard User
            </h2>
        </template>

        <div class="p-8">
            <div class="rounded bg-white p-6 shadow">

                <h1 class="text-2xl font-bold">
                    Selamat Datang di Lumira
                </h1>

                <p class="mt-2">
                    Marketplace Sampah Daur Ulang Indonesia
                </p>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
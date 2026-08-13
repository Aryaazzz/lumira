<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    topUps: Array,
})
</script>

<template>
    <Head title="Riwayat Top Up" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold">
                Riwayat Top Up
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div class="bg-white rounded shadow overflow-hidden">

                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">
                                Tanggal
                            </th>

                            <th class="p-3 text-left">
                                Nominal
                            </th>

                            <th class="p-3 text-left">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="topup in topUps"
                            :key="topup.id"
                            class="border-t"
                        >
                            <td class="p-3">
                                {{ topup.created_at }}
                            </td>

                            <td class="p-3">
                                Rp {{ topup.amount }}
                            </td>

                            <td class="p-3">
                                {{ topup.status }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </AuthenticatedLayout>
</template>
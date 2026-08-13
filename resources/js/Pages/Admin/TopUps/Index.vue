<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    topUps: Array,
})

const approve = (id) => {
    router.post(
        route('admin.topups.approve', id)
    )
}

const reject = (id) => {
    router.post(
        route('admin.topups.reject', id)
    )
}
</script>

<template>
    <Head title="Manajemen Top Up" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Manajemen Top Up
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div class="bg-white rounded shadow overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">
                                User
                            </th>

                            <th class="p-3 text-left">
                                Nominal
                            </th>

                            <th class="p-3 text-left">
                                Status
                            </th>

                            <th class="p-3 text-left">
                                Aksi
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
                                {{ topup.user.name }}
                            </td>

                            <td class="p-3">
                                Rp {{ topup.amount }}
                            </td>

                            <td class="p-3">
                                {{ topup.status }}
                            </td>

                            <td class="p-3">

                                <div
                                    v-if="topup.status === 'pending'"
                                    class="flex gap-2"
                                >
                                    <button
                                        @click="approve(topup.id)"
                                        class="px-3 py-1 bg-green-600 text-white rounded"
                                    >
                                        Approve
                                    </button>

                                    <button
                                        @click="reject(topup.id)"
                                        class="px-3 py-1 bg-red-600 text-white rounded"
                                    >
                                        Reject
                                    </button>
                                </div>

                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
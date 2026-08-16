
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    sellers: Array,
})

function warningSeller(id) {
    if (
        confirm(
            'Berikan warning kepada seller ini?'
        )
    ) {
        router.post(
            route(
                'admin.sellers.warning',
                id
            )
        )
    }
}

function suspendSeller(id) {
    if (
        confirm(
            'Suspend seller ini?'
        )
    ) {
        router.post(
            route(
                'admin.sellers.suspend',
                id
            )
        )
    }
}

function unsuspendSeller(id) {
    if (
        confirm(
            'Aktifkan kembali seller ini?'
        )
    ) {
        router.post(
            route(
                'admin.sellers.unsuspend',
                id
            )
        )
    }
}
</script>

<template>
    <Head title="Kelola Seller" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Kelola Seller
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <!-- Statistik -->

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"
            >

                <div
                    class="bg-white rounded-xl shadow p-5"
                >
                    <p class="text-gray-500">
                        Total Seller
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                    >
                        {{ sellers.length }}
                    </h3>
                </div>

                <div
                    class="bg-white rounded-xl shadow p-5"
                >
                    <p class="text-gray-500">
                        Seller Aktif
                    </p>

                    <h3
                        class="text-3xl font-bold text-green-600 mt-2"
                    >
                        {{
                            sellers.filter(
                                s => !s.is_suspended
                            ).length
                        }}
                    </h3>
                </div>

                <div
                    class="bg-white rounded-xl shadow p-5"
                >
                    <p class="text-gray-500">
                        Seller Suspended
                    </p>

                    <h3
                        class="text-3xl font-bold text-red-600 mt-2"
                    >
                        {{
                            sellers.filter(
                                s => s.is_suspended
                            ).length
                        }}
                    </h3>
                </div>

            </div>

            <!-- Table -->

            <div
                class="bg-white rounded-xl shadow overflow-hidden"
            >

                <div
                    class="p-5 border-b"
                >
                    <h3
                        class="font-bold text-lg"
                    >
                        Daftar Seller
                    </h3>
                </div>

                <div
                    v-if="sellers.length === 0"
                    class="p-8 text-center text-gray-500"
                >
                    Belum ada seller.
                </div>

                <div
                    v-else
                    class="overflow-x-auto"
                >

                    <table
                        class="w-full"
                    >

                        <thead
                            class="bg-gray-100"
                        >
                            <tr>

                                <th
                                    class="p-4 text-left"
                                >
                                    Seller
                                </th>

                                <th
                                    class="p-4 text-left"
                                >
                                    Toko
                                </th>

                                <th
                                    class="p-4 text-left"
                                >
                                    Warning
                                </th>

                                <th
                                    class="p-4 text-left"
                                >
                                    Status
                                </th>

                                <th
                                    class="p-4 text-left"
                                >
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr
                                v-for="seller in sellers"
                                :key="seller.id"
                                class="border-t hover:bg-gray-50"
                            >

                                <td class="p-4">

                                    <div
                                        class="font-semibold"
                                    >
                                        {{ seller.name }}
                                    </div>

                                    <div
                                        class="text-sm text-gray-500"
                                    >
                                        {{ seller.email }}
                                    </div>

                                </td>

                                <td class="p-4">
                                    {{
                                        seller.store?.name
                                        ?? '-'
                                    }}
                                </td>

                                <td class="p-4">

                                    <span
                                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm"
                                    >
                                        {{
                                            seller.warning_count
                                        }}
                                    </span>

                                </td>

                                <td class="p-4">

                                    <span
                                        v-if="seller.is_suspended"
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold"
                                    >
                                        Suspended
                                    </span>

                                    <span
                                        v-else
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold"
                                    >
                                        Active
                                    </span>

                                </td>

                                <td class="p-4">

                                    <div
                                        class="flex flex-wrap gap-2"
                                    >

                                        <button
                                            @click="
                                                warningSeller(
                                                    seller.id
                                                )
                                            "
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded"
                                        >
                                            Warning
                                        </button>

                                        <button
                                            v-if="
                                                !seller.is_suspended
                                            "
                                            @click="
                                                suspendSeller(
                                                    seller.id
                                                )
                                            "
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded"
                                        >
                                            Suspend
                                        </button>

                                        <button
                                            v-else
                                            @click="
                                                unsuspendSeller(
                                                    seller.id
                                                )
                                            "
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded"
                                        >
                                            Unsuspend
                                        </button>

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

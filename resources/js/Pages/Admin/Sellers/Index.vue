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

        <div
            class="max-w-7xl mx-auto py-8"
        >

            <h1
                class="text-3xl font-bold mb-6"
            >
                Kelola Seller
            </h1>

            <div
                class="bg-white rounded-xl shadow overflow-hidden"
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
                            class="border-t"
                        >

                            <td class="p-4">
                                {{ seller.name }}
                                <br>
                                <span
                                    class="text-sm text-gray-500"
                                >
                                    {{ seller.email }}
                                </span>
                            </td>

                            <td class="p-4">
                                {{
                                    seller.store?.name ??
                                    '-'
                                }}
                            </td>

                            <td class="p-4">
                                {{ seller.warning_count }}
                            </td>

                            <td class="p-4">

                                <span
                                    v-if="seller.is_suspended"
                                    class="text-red-600 font-bold"
                                >
                                    Suspended
                                </span>

                                <span
                                    v-else
                                    class="text-green-600 font-bold"
                                >
                                    Active
                                </span>

                            </td>

                            <td class="p-4">

                                <div
                                    class="flex gap-2 flex-wrap"
                                >

                                    <button
                                        @click="
                                            warningSeller(
                                                seller.id
                                            )
                                        "
                                        class="bg-yellow-500 text-white px-3 py-2 rounded"
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
                                        class="bg-red-600 text-white px-3 py-2 rounded"
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
                                        class="bg-green-600 text-white px-3 py-2 rounded"
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

    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    applications: Array
})

const approve = (id) => {
    router.post(
        route('admin.seller.approve', id)
    )
}

const reject = (id) => {
    router.post(
        route('admin.seller.reject', id)
    )
}
</script>

<template>
    <Head title="Seller Applications" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Seller Applications
            </h2>
        </template>

        <div class="p-8">

            <div
                v-for="item in applications"
                :key="item.id"
                class="mb-4 rounded border bg-white p-5"
            >

                <h3 class="font-bold text-lg">
                    {{ item.store_name }}
                </h3>

                <p>
                    Pemilik:
                    {{ item.user.name }}
                </p>

                <p>
                    Status:
                    {{ item.seller_status }}
                </p>

                <div class="mt-3 flex gap-2">

                    <button
                        @click="approve(item.id)"
                        class="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        Approve
                    </button>

                    <button
                        @click="reject(item.id)"
                        class="bg-red-600 text-white px-4 py-2 rounded"
                    >
                        Reject
                    </button>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
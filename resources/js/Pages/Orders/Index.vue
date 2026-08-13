<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    orders: Array,
})
</script>

<template>
    <Head title="Pesanan Saya" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold">
                Pesanan Saya
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div
                v-if="orders.length === 0"
                class="bg-white p-6 rounded shadow"
            >
                Belum ada pesanan.
            </div>

            <div
                v-else
                class="space-y-6"
            >

                <div
                    v-for="order in orders"
                    :key="order.id"
                    class="bg-white p-6 rounded shadow"
                >

                    <div
                        class="flex justify-between"
                    >
                        <div>

                            <h3 class="font-bold">
                                Order #{{ order.id }}
                            </h3>

                            <p>
                                Status:
                                {{ order.status }}
                            </p>

                            <p>
                                Pembayaran:
                                {{ order.payment_method }}
                            </p>

                            <p>
                                Status Bayar:
                                {{ order.payment_status }}
                            </p>

                        </div>

                        <div>
                            <p class="font-bold">
                                Rp {{ order.total_price }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div
                        v-for="item in order.items"
                        :key="item.id"
                        class="py-2"
                    >

                        <div>
                            {{ item.product.name }}
                        </div>

                        <div>
                            Qty:
                            {{ item.quantity }}
                        </div>

                        <div>
                            Rp {{ item.price }}
                        </div>

                    </div>

                    <div
                        v-if="
                            order.status === 'completed'
                            && !order.review
                        "
                        class="mt-4"
                    >

                        <Link
                            :href="
                                route(
                                    'reviews.create',
                                    order.id
                                )
                            "
                            class="inline-block bg-yellow-500 text-white px-4 py-2 rounded"
                        >
                            Beri Review
                        </Link>

                    </div>

                    <div
                        v-if="order.review"
                        class="mt-4 p-3 bg-green-100 rounded"
                    >

                        <p class="font-bold">
                            Review Terkirim
                        </p>

                        <p>
                            Rating:
                            {{ order.review.rating }}/5
                        </p>

                        <p>
                            {{ order.review.comment }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
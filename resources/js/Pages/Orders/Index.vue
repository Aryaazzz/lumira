
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

defineProps({
    orders: Array,
})

const form = useForm({
    rating: 5,
    comment: '',
})

function submitReview(orderId)
{
    form.post(
        route('reviews.store', orderId),
        {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
            }
        }
    )
}
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

                    <div class="flex justify-between">

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
                        class="mt-6 border-t pt-4"
                    >

                        <h4 class="font-bold mb-3">
                            Beri Review Toko
                        </h4>

                        <form
                            @submit.prevent="
                                submitReview(order.id)
                            "
                            class="space-y-3"
                        >

                            <select
                                v-model="form.rating"
                                class="border rounded p-2 w-full"
                            >
                                <option :value="5">⭐⭐⭐⭐⭐</option>
                                <option :value="4">⭐⭐⭐⭐</option>
                                <option :value="3">⭐⭐⭐</option>
                                <option :value="2">⭐⭐</option>
                                <option :value="1">⭐</option>
                            </select>

                            <textarea
                                v-model="form.comment"
                                rows="3"
                                class="border rounded p-2 w-full"
                                placeholder="Tulis review..."
                            />

                            <button
                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                            >
                                Kirim Review
                            </button>

                        </form>

                    </div>

                    <div
                        v-if="order.review"
                        class="mt-6 border-t pt-4"
                    >

                        <div class="font-bold">
                            Review Anda
                        </div>

                        <div>
                            Rating:
                            {{ order.review.rating }}/5
                        </div>

                        <div>
                            {{ order.review.comment }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>

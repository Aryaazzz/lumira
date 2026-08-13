<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

defineProps({
    orders: Array,
});

const shipOrder = (id) => {
    router.post(
        route('seller.orders.ship', id)
    );
};

const completeOrder = (id) => {
    router.post(
        route('seller.orders.complete', id)
    );
};
</script>

<template>
    <Head title="Pesanan Masuk" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold">
                Pesanan Masuk
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div
                v-if="orders.length === 0"
                class="bg-white p-6 rounded shadow"
            >
                Belum ada pesanan masuk.
            </div>

            <div
                v-else
                class="space-y-4"
            >

                <div
                    v-for="item in orders"
                    :key="item.id"
                    class="bg-white p-6 rounded shadow"
                >

                    <h3 class="font-bold">
                        {{ item.product.name }}
                    </h3>

                    <p>
                        Pembeli:
                        {{ item.order.user.name }}
                    </p>

                    <p>
                        Qty:
                        {{ item.quantity }}
                    </p>

                    <p>
                        Harga:
                        Rp {{ item.price }}
                    </p>

                    <p>
                        Status:
                        {{ item.order.status }}
                    </p>

                    <p>
                        Pembayaran:
                        {{ item.order.payment_method }}
                    </p>

                    <div class="mt-4 flex gap-2">

                        <button
                            v-if="
                                item.order.status === 'pending'
                            "
                            @click="shipOrder(item.id)"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Kirim Pesanan
                        </button>

                        <button
                            v-if="
                                item.order.status === 'shipped'
                            "
                            @click="completeOrder(item.id)"
                            class="px-4 py-2 bg-green-600 text-white rounded"
                        >
                            Selesaikan
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
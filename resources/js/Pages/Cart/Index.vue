<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    cart: Object,
});

const form = useForm({
    payment_method: 'balance',
});

const removeItem = (id) => {
    router.delete(route('cart.remove', id));
};

const updateQuantity = (id, quantity) => {
    router.patch(route('cart.update', id), {
        quantity,
    });
};

const totalPrice = () => {
    let total = 0;

    props.cart.items.forEach((item) => {
        total += item.product.price * item.quantity;
    });

    return total;
};

const checkout = () => {
    form.post(route('checkout.store'));
};
</script>

<template>
    <Head title="Keranjang" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold">
                Keranjang Belanja
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div
                v-if="cart.items.length === 0"
                class="bg-white p-6 rounded shadow"
            >
                Keranjang masih kosong.
            </div>

            <div
                v-else
                class="space-y-4"
            >

                <div
                    v-for="item in cart.items"
                    :key="item.id"
                    class="bg-white p-4 rounded shadow"
                >
                    <div class="flex justify-between items-center">

                        <div>
                            <h3 class="font-bold">
                                {{ item.product.name }}
                            </h3>

                            <p>
                                Rp {{ Number(item.product.price).toLocaleString('id-ID') }}
                            </p>

                            <p>
                                Qty: {{ item.quantity }}
                            </p>
                        </div>

                        <div class="space-x-2">

                            <button
                                class="px-3 py-1 bg-gray-200 rounded"
                                @click="
                                    updateQuantity(
                                        item.id,
                                        item.quantity + 1
                                    )
                                "
                            >
                                +
                            </button>

                            <button
                                v-if="item.quantity > 1"
                                class="px-3 py-1 bg-gray-200 rounded"
                                @click="
                                    updateQuantity(
                                        item.id,
                                        item.quantity - 1
                                    )
                                "
                            >
                                -
                            </button>

                            <button
                                class="px-3 py-1 bg-red-500 text-white rounded"
                                @click="removeItem(item.id)"
                            >
                                Hapus
                            </button>

                        </div>

                    </div>
                </div>

                <div class="bg-white p-6 rounded shadow">

                    <h3 class="text-xl font-bold mb-4">
                        Total:
                        Rp {{ Number(totalPrice()).toLocaleString('id-ID') }}
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Metode Pembayaran
                        </label>

                        <select
                            v-model="form.payment_method"
                            class="w-full border rounded px-3 py-2"
                        >
                            <option value="balance">
                                Saldo Lumira
                            </option>

                            <option value="cod">
                                COD (Bayar di Tempat)
                            </option>
                        </select>
                    </div>

                    <div class="mt-4 flex gap-3">

    <button
        class="px-4 py-2 bg-blue-600 text-white rounded"
        @click="
            router.post(
                route('checkout.store'),
                {
                    payment_method: 'balance'
                }
            )
        "
    >
        Bayar Dengan Saldo
    </button>

    <button
        class="px-4 py-2 bg-green-600 text-white rounded"
        @click="
            router.post(
                route('checkout.store'),
                {
                    payment_method: 'cod'
                }
            )
        "
    >
        Bayar COD
    </button>

</div>

                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>
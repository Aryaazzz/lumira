<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { computed } from 'vue'
import { Head, router, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps({
    cart: {
        type: Object,
        default: () => ({ items: [] }),
    },
})

const cartItems = computed(() => props.cart?.items ?? [])

const form = useForm({
    payment_method: 'balance',
    voucher_code: '',
})

const formatRupiah = (value) =>
    Number(value || 0).toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    })

const subtotal = computed(() =>
    cartItems.value.reduce(
        (total, item) => total + Number(item.product?.price || 0) * Number(item.quantity || 0),
        0,
    ),
)

const removeItem = (id) => {
    router.delete(route('cart.remove', id), {
        preserveScroll: true,
    })
}

const updateQuantity = (id, quantity) => {
    if (quantity < 1) return

    router.patch(route('cart.update', id), { quantity }, {
        preserveScroll: true,
    })
}

const checkout = (paymentMethod = form.payment_method) => {
    form.payment_method = paymentMethod
    form.post(route('checkout.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('voucher_code')
            window.alert('Pesanan berhasil dibuat dan menunggu proses selanjutnya.')
        },
        onError: () => {
            window.alert('Checkout gagal. Periksa voucher atau saldo Anda.')
        },
    })
}
</script>

<template>
    <Head title="Keranjang" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800">Keranjang Belanja</h2>
        </template>

        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700">
                {{ page.props.flash.success }}
            </div>
            <div v-if="page.props.flash?.error" class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                {{ page.props.flash.error }}
            </div>

            <div v-if="cartItems.length === 0" class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-12 text-center shadow-sm">
                <div class="text-xl font-semibold text-gray-700">Keranjang masih kosong</div>
                <p class="mt-2 text-sm text-gray-500">Belum ada produk yang kamu pilih. Ayo mulai belanja dulu.</p>
            </div>

            <div v-else class="grid gap-6 lg:grid-cols-[1.7fr_0.9fr]">
                <div class="space-y-4">
                    <div
                        v-for="item in cartItems"
                        :key="item.id"
                        class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md"
                    >
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <img
                                :src="item.product?.image ? `/storage/${item.product.image}` : '/images/default-product.jpg'"
                                alt="Product"
                                class="h-24 w-24 rounded-xl object-cover border border-gray-200"
                            />

                            <div class="flex-1">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Produk</p>
                                        <h3 class="text-lg font-bold text-gray-800">{{ item.product?.name }}</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ formatRupiah(item.product?.price) }} / item</p>
                                    </div>

                                    <button
                                        type="button"
                                        class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100"
                                        @click="removeItem(item.id)"
                                    >
                                        Hapus
                                    </button>
                                </div>

                                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            class="h-9 w-9 rounded-lg border border-gray-300 bg-gray-100 text-lg font-semibold text-gray-700 transition hover:bg-gray-200"
                                            @click="updateQuantity(item.id, item.quantity - 1)"
                                        >
                                            −
                                        </button>

                                        <div class="flex h-9 min-w-12 items-center justify-center rounded-lg border border-gray-300 bg-gray-50 px-3 text-sm font-semibold text-gray-800">
                                            {{ item.quantity }}
                                        </div>

                                        <button
                                            type="button"
                                            class="h-9 w-9 rounded-lg border border-gray-300 bg-gray-100 text-lg font-semibold text-gray-700 transition hover:bg-gray-200"
                                            @click="updateQuantity(item.id, item.quantity + 1)"
                                        >
                                            +
                                        </button>
                                    </div>

                                    <div class="text-lg font-bold text-gray-900">
                                        {{ formatRupiah(Number(item.product?.price || 0) * Number(item.quantity || 0)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-800">Ringkasan Belanja</h3>

                    <div class="mt-5 space-y-3 text-sm text-gray-600">
                        <div class="flex items-center justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-gray-800">{{ formatRupiah(subtotal) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Biaya admin</span>
                            <span class="font-semibold text-gray-800">Rp 0</span>
                        </div>
                    </div>

                    <div class="my-5 border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>{{ formatRupiah(subtotal) }}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="voucher" class="mb-2 block text-sm font-medium text-gray-700">Kode Voucher</label>
                            <input
                                id="voucher"
                                v-model="form.voucher_code"
                                type="text"
                                placeholder="Contoh: LUMIRA10"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            />
                        </div>

                        <div>
                            <label for="payment-method" class="mb-2 block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <select
                                id="payment-method"
                                v-model="form.payment_method"
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="balance">Saldo Lumira</option>
                                <option value="cod">COD (Bayar di Tempat)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <button
                            type="button"
                            class="w-full rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700"
                            @click="checkout('balance')"
                        >
                            Bayar Dengan Saldo
                        </button>

                        <button
                            type="button"
                            class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                            @click="checkout('cod')"
                        >
                            Bayar COD
                        </button>
                    </div>
                </aside>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
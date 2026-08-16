<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

const page = usePage()

defineProps({
    announcement: Object,
})
</script>

<template>
    <Head title="Dashboard User" />

    <AuthenticatedLayout>
        <div v-if="announcement" class="mx-auto mt-6 max-w-7xl">
            <div class="rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-yellow-50 p-4 shadow-sm shadow-amber-200/40">
                <h3 class="text-lg font-black text-[#0b2617]">
                    <i class="fas fa-bullhorn mr-2 text-slate-500"></i>{{ announcement.title }}
                </h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    {{ announcement.content }}
                </p>
            </div>
        </div>

        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-[#0c7c43]">Welcome back</p>
                    <h2 class="mt-2 text-2xl font-black text-[#0b2617] md:text-3xl">
                        Halo, {{ $page.props.auth.user.name }}
                    </h2>
                </div>

                <div class="flex flex-wrap gap-2">
                    <Link :href="route('topup.index')" class="rounded-xl bg-[#0c7c43] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-green-900/20 transition hover:-translate-y-0.5 hover:bg-[#0b2617]">
                        <i class="fas fa-wallet mr-2"></i>Top Up Saldo
                    </Link>
                    <Link :href="route('orders.index')" class="rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:text-[#0c7c43]">
                        <i class="fas fa-box mr-2 text-slate-500"></i>Pesanan Saya
                    </Link>
                    <Link :href="route('notifications.index')" class="rounded-xl bg-[#eafaf1] px-4 py-2.5 text-sm font-bold text-[#0c7c43] shadow-sm ring-1 ring-green-100 transition hover:-translate-y-0.5">
                        <i class="fas fa-bell mr-2"></i>Notifikasi
                    </Link>
                </div>
            </div>
        </template>

        <div class="mx-auto py-8">
            <div v-if="page.props.flash?.error" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                {{ page.props.flash.error }}
            </div>

            <div v-if="$page.props.auth.user.seller_status === 'suspended'" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-6 shadow-sm">
                <h3 class="text-lg font-black text-red-700">Akun Seller Ditangguhkan</h3>
                <p class="mt-2 text-sm leading-6 text-red-600">
                    Hak seller Anda sedang dicabut oleh admin. Anda masih dapat menggunakan akun ini sebagai pembeli.
                </p>
                <div class="mt-4">
                    <Link href="/seller/apply" class="inline-block rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700">
                        Ajukan Seller Kembali
                    </Link>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white p-6 shadow-[0_20px_60px_rgba(18,41,24,0.08)] ring-1 ring-slate-100 md:p-8">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.2em] text-[#0c7c43]">Marketplace</p>
                        <h1 class="mt-2 text-3xl font-black text-[#0b2617] md:text-4xl">
                            Selamat datang di Lumira
                        </h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 rounded-full bg-[#edf9ee] px-4 py-2 text-sm font-bold text-[#0c7c43]">
                        <i class="fas fa-leaf text-[#0c7c43]"></i>
                        Marketplace Sampah Daur Ulang Indonesia
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
                    <Link :href="route('marketplace')" class="group rounded-[1.6rem] bg-gradient-to-br from-[#0c7c43] to-[#0b2617] p-6 text-white shadow-lg shadow-green-900/20 transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex items-center justify-between">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-xl"><i class="fas fa-store"></i></span>
                            <span class="rounded-full bg-white/10 px-2 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-green-100">Open</span>
                        </div>
                        <h3 class="mt-8 text-xl font-black">Marketplace</h3>
                        <p class="mt-2 text-sm leading-6 text-green-50/80">Jelajahi produk daur ulang berkualitas dan ramah lingkungan.</p>
                    </Link>

                    <Link :href="route('cart.index')" class="group rounded-[1.6rem] bg-gradient-to-br from-[#f3f7f5] to-[#ebf8f0] p-6 text-slate-800 ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-900/10">
                        <div class="flex items-center justify-between">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl text-slate-500"><i class="fas fa-shopping-cart"></i></span>
                            <span class="rounded-full bg-[#eafaf1] px-2 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-[#0c7c43]">Cart</span>
                        </div>
                        <h3 class="mt-8 text-xl font-black">Keranjang</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Lihat produk yang sudah Anda pilih dan siap dibeli.</p>
                    </Link>

                    <Link v-if="$page.props.auth.user.seller_status !== 'suspended'" :href="route('seller.apply')" class="group rounded-[1.6rem] bg-gradient-to-br from-[#edf9ee] to-[#e4f8e7] p-6 text-slate-800 ring-1 ring-green-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-900/10">
                        <div class="flex items-center justify-between">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl text-[#0c7c43]"><i class="fas fa-seedling"></i></span>
                            <span class="rounded-full bg-white px-2 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-[#0c7c43]">Seller</span>
                        </div>
                        <h3 class="mt-8 text-xl font-black">Daftar Seller</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Mulai jualan dan bangun bisnis ramah lingkungan Anda.</p>
                    </Link>

                    <div v-else class="rounded-[1.6rem] bg-slate-100 p-6 text-slate-600 ring-1 ring-slate-200">
                        <div class="flex items-center justify-between">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl text-slate-500"><i class="fas fa-ban"></i></span>
                            <span class="rounded-full bg-white px-2 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Paused</span>
                        </div>
                        <h3 class="mt-8 text-xl font-black">Status Seller Ditangguhkan</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Hubungi admin atau ajukan kembali untuk aktifkan akun seller.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

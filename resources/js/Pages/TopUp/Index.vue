<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    topUps: Array,
});

const form = useForm({
    amount: '',
    proof: null,
});

const submit = () => {
    form.post(route('topup.store'));
};
</script>

<template>
    <Head title="Top Up Saldo" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold">
                Top Up Saldo
            </h2>
        </template>

        <div class="max-w-4xl mx-auto py-8">

            <div class="bg-white p-6 rounded shadow">

                <h3 class="font-bold mb-4">
                    Ajukan Top Up
                </h3>

                <form @submit.prevent="submit">

                    <input
                        v-model="form.amount"
                        type="number"
                        placeholder="Nominal"
                        class="w-full border rounded p-2 mb-4"
                    >

                    <input
                        type="file"
                        @input="
                            form.proof =
                            $event.target.files[0]
                        "
                        class="mb-4"
                    >

                    <button
                        class="px-4 py-2 bg-green-600 text-white rounded"
                    >
                        Kirim
                    </button>

                </form>

            </div>

            <div class="mt-8">

                <h3 class="font-bold mb-4">
                    Riwayat Top Up
                </h3>

                <div
                    v-for="topup in topUps"
                    :key="topup.id"
                    class="bg-white p-4 rounded shadow mb-4"
                >

                    <p>
                        Rp {{ topup.amount }}
                    </p>

                    <p>
                        Status:
                        {{ topup.status }}
                    </p>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
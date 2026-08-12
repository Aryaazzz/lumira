<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
    application: Object
})

const form = useForm({
    store_name: '',
    description: '',
    phone: '',
    id_card: null,
    selfie: null,
})

const submit = () => {
    form.post(
        route('seller.apply.store')
    )
}
</script>

<template>
    <Head title="Daftar Seller" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Daftar Menjadi Seller
            </h2>
        </template>

        <div class="p-8">

            <div
                v-if="application"
                class="mb-6 rounded bg-yellow-100 p-4"
            >
                Status:
                <strong>
                    {{ application.status }}
                </strong>
            </div>

            <form
                class="space-y-4 bg-white p-6 rounded shadow"
                @submit.prevent="submit"
            >

                <div>
                    <label>Nama Toko</label>

                    <input
                        v-model="form.store_name"
                        class="w-full border p-2"
                    >
                </div>

                <div>
                    <label>Deskripsi</label>

                    <textarea
                        v-model="form.description"
                        class="w-full border p-2"
                    />
                </div>

                <div>
                    <label>No HP</label>

                    <input
                        v-model="form.phone"
                        class="w-full border p-2"
                    >
                </div>

                <div>
                    <label>KTP</label>

                    <input
                        type="file"
                        @input="
                        form.id_card =
                        $event.target.files[0]
                        "
                    >
                </div>

                <div>
                    <label>Selfie</label>

                    <input
                        type="file"
                        @input="
                        form.selfie =
                        $event.target.files[0]
                        "
                    >
                </div>

                <button
                    class="rounded bg-green-600 px-4 py-2 text-white"
                >
                    Kirim Pengajuan
                </button>

            </form>

        </div>

    </AuthenticatedLayout>
</template>
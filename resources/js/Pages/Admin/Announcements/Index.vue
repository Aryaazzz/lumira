<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
    announcements: Array,
})

const form = useForm({
    title: '',
    content: '',
})

const submit = () => {
    form.post(
        route('admin.announcements.store'),
        {
            onSuccess: () => {
                form.reset()
            },
        }
    )
}
</script>

<template>
    <Head title="Pengumuman" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Pengumuman Admin
            </h2>
        </template>

        <div class="max-w-5xl mx-auto py-8">

            <div
                class="bg-white rounded-lg shadow p-6 mb-8"
            >

                <h3
                    class="font-bold text-lg mb-4"
                >
                    Buat Pengumuman
                </h3>

                <form @submit.prevent="submit">

                    <input
                        v-model="form.title"
                        type="text"
                        placeholder="Judul"
                        class="w-full border rounded p-2 mb-4"
                    />

                    <textarea
                        v-model="form.content"
                        rows="5"
                        placeholder="Isi pengumuman..."
                        class="w-full border rounded p-2 mb-4"
                    />

                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                    >
                        Simpan
                    </button>

                </form>

            </div>

            <div
                class="bg-white rounded-lg shadow p-6"
            >

                <h3
                    class="font-bold text-lg mb-4"
                >
                    Daftar Pengumuman
                </h3>

                <div
                    v-for="announcement in announcements"
                    :key="announcement.id"
                    class="border-b py-4"
                >

                    <h4
                        class="font-bold"
                    >
                        {{ announcement.title }}
                    </h4>

                    <p
                        class="text-gray-600 mt-2"
                    >
                        {{ announcement.content }}
                    </p>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
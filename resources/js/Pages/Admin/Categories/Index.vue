<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'

const props = defineProps({
    categories: Array,
})

const form = useForm({
    name: '',
})

const editingId = ref(null)

const submit = () => {

    if (editingId.value) {

        form.patch(
            route(
                'admin.categories.update',
                editingId.value
            ),
            {
                preserveScroll: true,
                onSuccess: () => {
                    cancelEdit()
                },
            }
        )

        return
    }

    form.post(
        route('admin.categories.store'),
        {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        }
    )
}

const editCategory = (category) => {

    editingId.value = category.id

    form.name = category.name
}

const cancelEdit = () => {

    editingId.value = null

    form.reset()
}

const destroyCategory = (id) => {

    if (!confirm('Hapus kategori ini?')) {
        return
    }

    router.delete(
        route(
            'admin.categories.destroy',
            id
        )
    )
}
</script>

<template>
    <Head title="Kelola Kategori" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Kelola Kategori
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8">

            <div class="bg-white p-6 rounded shadow">

                <h3
                    class="font-bold text-lg mb-4"
                >
                    {{
                        editingId
                            ? 'Edit Kategori'
                            : 'Tambah Kategori'
                    }}
                </h3>

                <form
                    @submit.prevent="submit"
                    class="flex gap-2"
                >
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="Nama kategori"
                        class="border rounded px-3 py-2 flex-1"
                    />

                    <button
                        class="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        {{
                            editingId
                                ? 'Simpan'
                                : 'Tambah'
                        }}
                    </button>

                    <button
                        v-if="editingId"
                        type="button"
                        @click="cancelEdit"
                        class="bg-gray-500 text-white px-4 py-2 rounded"
                    >
                        Batal
                    </button>

                </form>

            </div>

            <div
                class="bg-white p-6 rounded shadow mt-6"
            >

                <h3
                    class="font-bold text-lg mb-4"
                >
                    Daftar Kategori
                </h3>

                <table class="w-full">

                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">
                                Nama
                            </th>

                            <th class="text-left py-2">
                                Slug
                            </th>

                            <th class="text-left py-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr
                            v-for="category in categories"
                            :key="category.id"
                            class="border-b"
                        >
                            <td class="py-3">
                                {{ category.name }}
                            </td>

                            <td class="py-3">
                                {{ category.slug }}
                            </td>

                            <td class="py-3 flex gap-2">

                                <button
                                    @click="
                                        editCategory(
                                            category
                                        )
                                    "
                                    class="bg-blue-600 text-white px-3 py-1 rounded"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="
                                        destroyCategory(
                                            category.id
                                        )
                                    "
                                    class="bg-red-600 text-white px-3 py-1 rounded"
                                >
                                    Hapus
                                </button>

                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </AuthenticatedLayout>
</template>

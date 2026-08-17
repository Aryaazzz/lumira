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
        form.patch(route('admin.categories.update', editingId.value), {
            preserveScroll: true,
            onSuccess: () => cancelEdit(),
        })
        return
    }

    form.post(route('admin.categories.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    })
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

    router.delete(route('admin.categories.destroy', id))
}
</script>

<template>
    <Head title="Kelola Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-600">Catalog</p>
                    <h2 class="text-xl font-bold text-slate-800">Kelola Kategori</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 text-lg font-bold text-slate-800">{{ editingId ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">Nama Kategori</label>
                            <input v-model="form.name" type="text" placeholder="Nama kategori" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                                {{ editingId ? 'Simpan' : 'Tambah' }}
                            </button>

                            <button v-if="editingId" type="button" @click="cancelEdit" class="rounded-xl bg-slate-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-600">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 text-lg font-bold text-slate-800">Daftar Kategori</h3>

                    <div v-if="!categories?.length" class="rounded-xl bg-slate-50 p-6 text-center text-sm text-slate-500">Belum ada kategori.</div>

                    <div v-else class="space-y-3">
                        <div v-for="category in categories" :key="category.id" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-base font-semibold text-slate-800">{{ category.name }}</p>
                                <p class="text-sm text-slate-500">Slug: {{ category.slug }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <button @click="editCategory(category)" class="rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">Edit</button>
                                <button @click="destroyCategory(category.id)" class="rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


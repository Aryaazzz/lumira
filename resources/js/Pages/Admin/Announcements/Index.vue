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
    form.post(route('admin.announcements.store'), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Pengumuman" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-violet-600">CMS</p>
                    <h2 class="text-xl font-bold text-slate-800">Pengumuman Admin</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 text-lg font-bold text-slate-800">Buat Pengumuman</h3>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">Judul</label>
                            <input v-model="form.title" type="text" placeholder="Judul pengumuman" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200" />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700">Isi</label>
                            <textarea v-model="form.content" rows="6" placeholder="Isi pengumuman..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200" />
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-violet-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-violet-700">
                            Simpan Pengumuman
                        </button>
                    </form>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-5 text-lg font-bold text-slate-800">Daftar Pengumuman</h3>

                    <div v-if="!announcements?.length" class="rounded-xl bg-slate-50 p-6 text-center text-sm text-slate-500">Belum ada pengumuman.</div>

                    <div v-else class="space-y-4">
                        <div v-for="announcement in announcements" :key="announcement.id" class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <h4 class="text-lg font-bold text-slate-800">{{ announcement.title }}</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ announcement.content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

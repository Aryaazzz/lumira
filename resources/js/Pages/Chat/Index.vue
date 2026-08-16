<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    conversations: Array,
})
</script>

<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#0c7c43]">Inbox</p>
                    <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-900">Percakapan</h2>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-5xl py-8">
            <section class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm ring-1 ring-slate-100" data-aos="fade-up">
                <div v-if="conversations && conversations.length" class="space-y-4">
                    <Link
                        v-for="conversation in conversations"
                        :key="conversation.id"
                        :href="route('chat.show', conversation.id)"
                        class="block rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-white hover:shadow-md"
                    >
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#0c7c43] to-[#0b2617] text-lg font-black text-white">
                                <i class="fas fa-comments"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-3">
                                    <h3 class="truncate text-lg font-black text-slate-900">
                                        {{ conversation.product ? conversation.product.name : 'Chat' }}
                                    </h3>
                                </div>

                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">
                                    {{ conversation.messages && conversation.messages.length ? conversation.messages[conversation.messages.length - 1].message : 'Belum ada pesan' }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>

                <div v-else class="rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
                    Belum ada percakapan.
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
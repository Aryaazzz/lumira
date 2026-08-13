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
            <h2 class="text-xl font-bold">
                Percakapan
            </h2>
        </template>

        <div class="max-w-5xl mx-auto py-8">

            <div
                v-if="conversations.length === 0"
                class="bg-white p-6 rounded shadow"
            >
                Belum ada percakapan.
            </div>

            <div
                v-for="conversation in conversations"
                :key="conversation.id"
                class="bg-white p-4 rounded shadow mb-4"
            >
                <Link
                    :href="route('chat.show', conversation.id)"
                >
                    <div class="font-bold">
                        {{
                            conversation.product
                                ? conversation.product.name
                                : 'Chat'
                        }}
                    </div>

                    <div class="text-gray-500 text-sm">
                        {{
                            conversation.messages.length
                                ? conversation.messages[
                                    conversation.messages.length - 1
                                  ].message
                                : 'Belum ada pesan'
                        }}
                    </div>
                </Link>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
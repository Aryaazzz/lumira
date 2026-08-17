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

            <div v-for="conversation in conversations" :key="conversation.id" class="mb-4">
                <Link :href="route('chat.show', conversation.id)" class="block">
                    <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-700">
                                <span v-if="(conversation.buyer || conversation.seller)">
                                    {{ ((conversation.seller_id === $page.props.auth.user.id) ? (conversation.buyer?.name) : (conversation.seller?.store?.name || conversation.seller?.name || conversation.product?.name))?.charAt(0).toUpperCase() }}
                                </span>
                                <span v-else>💬</span>
                            </div>

                        <div class="flex-1 overflow-hidden">
                            <div class="flex justify-between items-start">
                                <div class="font-bold truncate">{{ (conversation.seller_id === $page.props.auth.user.id) ? (conversation.buyer?.name || conversation.product?.name) : (conversation.seller?.store?.name || conversation.seller?.name || conversation.product?.name) }}</div>
                                <div class="text-xs text-gray-400 ml-2">{{ conversation.messages.length ? (conversation.messages[conversation.messages.length-1].created_at || '').slice(0,16).replace('T',' ') : '' }}</div>
                            </div>

                            <div class="text-sm text-gray-500 truncate mt-1">
                                {{ conversation.messages.length ? conversation.messages[conversation.messages.length-1].message : 'Belum ada pesan' }}
                            </div>
                        </div>

                        <div class="ml-4">
                            <div v-if="conversation.unread_messages_count > 0" class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ conversation.unread_messages_count }}</div>
                        </div>
                    </div>
                </Link>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
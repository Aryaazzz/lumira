<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref, onMounted, nextTick, onBeforeUnmount, watch } from 'vue'

const props = defineProps({
    conversation: Object,
})

const page = usePage()
const currentUser = page.props.auth.user
const chatBox = ref(null)
const message = ref('')
const messages = ref([...props.conversation.messages])
const echoChannel = ref(null)

const isOwnMessage = (senderId) => Number(senderId) === Number(currentUser.id)

const formatTimestamp = (value) => {
    if (!value) return ''

    return new Date(value).toLocaleString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}

const scrollToBottom = () => {
    nextTick(() => {
        if (chatBox.value) {
            chatBox.value.scrollTop = chatBox.value.scrollHeight
        }
    })
}

const handleIncomingMessage = (event) => {
    if (isOwnMessage(event.sender_id)) {
        return
    }

    const exists = messages.value.some(
        (msg) => Number(msg.id) === Number(event.id)
    )

    if (exists) {
        return
    }

    messages.value.push(event)
    scrollToBottom()
}

onMounted(() => {
    scrollToBottom()

    if (!window.Echo) {
        return
    }

    echoChannel.value = window.Echo.private(
        `conversation.${props.conversation.id}`
    )

    echoChannel.value.listen('.message.sent', handleIncomingMessage)
})

watch(
    () => props.conversation.messages?.length,
    (newVal, oldVal) => {
        if (newVal !== oldVal) {
            scrollToBottom()
        }
    }
)

onBeforeUnmount(() => {
    if (echoChannel.value) {
        echoChannel.value.stopListening('.message.sent')
        window.Echo.leave(`conversation.${props.conversation.id}`)
    }
})

const sendMessage = () => {
    const text = message.value.trim()

    if (!text) {
        return
    }

    const optimisticMessage = {
        id: Date.now(),
        conversation_id: props.conversation.id,
        message: text,
        sender_id: currentUser.id,
        sender: {
            id: currentUser.id,
            name: currentUser.name,
        },
        created_at: new Date().toISOString(),
    }

    messages.value.push(optimisticMessage)
    message.value = ''
    scrollToBottom()

    router.post(
        route('chat.send', props.conversation.id),
        { message: text },
        {
            preserveScroll: true,
            onError: () => {
                const index = messages.value.findIndex(
                    (msg) => Number(msg.id) === Number(optimisticMessage.id)
                )

                if (index !== -1) {
                    messages.value.splice(index, 1)
                }

                message.value = text
            },
        }
    )
}
</script>

<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800">Chat</h2>
        </template>

        <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col" style="min-height: 70vh;">
                <div class="border-b border-gray-200 bg-gray-50 px-5 py-4">
                    <div class="font-bold text-lg text-gray-800">
                        {{ conversation.product?.name || 'Percakapan' }}
                    </div>
                    <div class="text-sm text-gray-500">Percakapan terkait produk</div>
                </div>

                <div ref="chatBox" class="flex-1 overflow-y-auto px-4 py-4 sm:px-5 space-y-3 bg-white">
                    <div v-for="msg in messages" :key="msg.id" class="flex">
                        <div :class="isOwnMessage(msg.sender_id) ? 'ml-auto' : 'mr-auto'" class="max-w-[75%]">
                            <div
                                :class="isOwnMessage(msg.sender_id)
                                    ? 'bg-green-600 text-white ml-auto'
                                    : 'bg-gray-100 text-gray-800 mr-auto'"
                                class="rounded-2xl px-4 py-3 shadow-sm"
                            >
                                <div class="text-[11px] font-medium opacity-80 mb-1">
                                    {{ msg.sender?.name || 'Anda' }}
                                </div>
                                <div class="whitespace-pre-wrap break-words text-sm leading-relaxed">
                                    {{ msg.message }}
                                </div>
                                <div class="text-[10px] mt-2 text-right opacity-80">
                                    {{ formatTimestamp(msg.created_at) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 bg-white px-4 py-4 sm:px-5">
                    <div class="flex gap-2 items-center">
                        <input
                            v-model="message"
                            @keyup.enter="sendMessage"
                            type="text"
                            placeholder="Tulis pesan..."
                            class="flex-1 rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        />
                        <button
                            @click="sendMessage"
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-medium transition shadow-sm disabled:opacity-60"
                            :disabled="!message.trim()"
                        >
                            Kirim
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
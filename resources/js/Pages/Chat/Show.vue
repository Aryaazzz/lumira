<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    conversation: Object,
})

const message = ref('')

const sendMessage = () => {

    if (!message.value) {
        return
    }

    router.post(
        route(
            'chat.send',
            props.conversation.id
        ),
        {
            message: message.value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                message.value = ''
            }
        }
    )
}
</script>

<template>
    <Head title="Chat" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold">
                Chat
            </h2>
        </template>

        <div class="max-w-5xl mx-auto py-8">

            <div
                class="bg-white rounded shadow p-6"
            >

                <div
                    class="h-[500px] overflow-y-auto border rounded p-4"
                >

                    <div
                        v-for="msg in conversation.messages"
                        :key="msg.id"
                        class="mb-3"
                    >
                        <div
                            class="font-bold text-sm"
                        >
                            {{ msg.sender.name }}
                        </div>

                        <div
                            class="bg-gray-100 rounded p-3"
                        >
                            {{ msg.message }}
                        </div>
                    </div>

                </div>

                <div
                    class="flex gap-2 mt-4"
                >

                    <input
                        v-model="message"
                        type="text"
                        placeholder="Tulis pesan..."
                        class="flex-1 border rounded p-2"
                    >

                    <button
                        @click="sendMessage"
                        class="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        Kirim
                    </button>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'

defineProps({
    notifications: Array
})

function read(id)
{
    router.post(
        route(
            'notifications.read',
            id
        )
    )
}

function readAll()
{
    router.post(
        route(
            'notifications.readAll'
        )
    )
}
</script>

<template>
    <Head title="Notifikasi" />

    <AuthenticatedLayout>

        <div class="max-w-5xl mx-auto p-8">

            <div
                class="flex justify-between items-center mb-6"
            >
                <h1
                    class="text-2xl font-bold"
                >
                    Notifikasi
                </h1>

                <button
                    @click="readAll"
                    class="bg-green-600 text-white px-4 py-2 rounded"
                >
                    Tandai Semua Dibaca
                </button>
            </div>

            <div
                v-if="notifications.length === 0"
                class="bg-white p-6 rounded shadow"
            >
                Belum ada notifikasi.
            </div>

            <div
                v-else
                class="space-y-4"
            >

                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="bg-white p-5 rounded shadow"
                >

                    <div
                        class="flex justify-between"
                    >

                        <div>

                            <h3
                                class="font-bold"
                            >
                                {{ notification.title }}
                            </h3>

                            <p>
                                {{ notification.message }}
                            </p>

                            <small>
                                {{ notification.created_at }}
                            </small>

                        </div>

                        <button
                            v-if="!notification.is_read"
                            @click="
                                read(
                                    notification.id
                                )
                            "
                            class="bg-blue-600 text-white px-3 py-2 rounded"
                        >
                            Tandai Dibaca
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
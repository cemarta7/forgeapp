<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex flex-col gap-2 p-4">
                        <div class="flex flex-col g ap-2">
                            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                                Links
                            </h2>
                        </div>
                        <div class="flex flex-col gap-2">
                            <Link :href="route('image_list')" class="px-4 py-2 w-32 text-white bg-blue-500 rounded-md">Images</Link>
                            <Link :href="route('logs')" class="px-4 py-2 w-32 text-white bg-blue-500 rounded-md">Logs</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

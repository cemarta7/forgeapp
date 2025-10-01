<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const deleteLog = (id) => {
    axios.delete(route('logs.destroy', id)).then((response) => {
        page.props.logs = page.props.logs.filter(log => log.id !== id);
    });
};


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Schedule Logs
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex flex-col gap-2 p-4">
                        <div class="flex flex-col gap-2">
                            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                                Logs
                            </h2>
                            <div class="flex flex-col gap-2">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Message</th>
                                            <th>IP Address</th>
                                            <th>Server Name</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="log in page.props.logs" :key="log.id">
                                            <td class="text-center">{{ log.id }}</td>
                                            <td class="text-center">{{ log.message }}</td>
                                            <td class="text-center">{{ log.ip_address }}</td>
                                            <td class="text-center">{{ log.server_name }}</td>
                                            <td class="text-center">{{ log.created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


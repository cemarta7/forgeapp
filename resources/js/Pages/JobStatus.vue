<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    stats: Object,
});

const jobCount = ref(5);
const stats = ref(props.stats);
const isDispatching = ref(false);
const message = ref('');
const errors = ref({});
let intervalId = null;

const fetchStats = async () => {
    try {
        const response = await axios.get(route('job_stats'));
        stats.value = response.data;
    } catch (error) {
        console.error('Error fetching stats:', error);
    }
};

const dispatchJobs = async () => {
    if (isDispatching.value) return;
    
    isDispatching.value = true;
    message.value = '';
    errors.value = {};

    try {
        const response = await axios.post(route('job_dispatch'), {
            count: jobCount.value,
        });
        
        message.value = response.data.message;
        stats.value = response.data.stats;
        
        setTimeout(() => {
            message.value = '';
        }, 3000);
    } catch (error) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            message.value = 'Error dispatching jobs';
        }
    } finally {
        isDispatching.value = false;
    }
};

onMounted(() => {
    // Refresh stats every 5 seconds
    intervalId = setInterval(fetchStats, 5000);
});

onUnmounted(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
});
</script>

<template>
    <AppLayout title="Job Status">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Job Queue Status
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <!-- Queue Stats -->
                        <div class="mb-8">
                            <h3 class="mb-4 text-lg font-semibold text-gray-800">
                                Queue Statistics
                            </h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="rounded-lg border border-gray-200 bg-blue-50 p-4">
                                    <div class="text-sm font-medium text-gray-600">
                                        Queue Driver
                                    </div>
                                    <div class="mt-1 text-2xl font-bold text-blue-600">
                                        {{ stats.driver }}
                                    </div>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-yellow-50 p-4">
                                    <div class="text-sm font-medium text-gray-600">
                                        Pending Jobs
                                    </div>
                                    <div class="mt-1 text-2xl font-bold text-yellow-600">
                                        {{ stats.pending }}
                                    </div>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-red-50 p-4">
                                    <div class="text-sm font-medium text-gray-600">
                                        Failed Jobs
                                    </div>
                                    <div class="mt-1 text-2xl font-bold text-red-600">
                                        {{ stats.failed }}
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Auto-refreshes every 5 seconds
                            </p>
                        </div>

                        <!-- Dispatch Jobs Form -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="mb-4 text-lg font-semibold text-gray-800">
                                Dispatch Test Jobs
                            </h3>
                            <p class="mb-4 text-sm text-gray-600">
                                Each test job sleeps for 2 seconds before completing.
                            </p>
                            
                            <div class="max-w-md">
                                <div class="mb-4">
                                    <InputLabel for="jobCount" value="Number of Jobs" />
                                    <TextInput
                                        id="jobCount"
                                        v-model="jobCount"
                                        type="number"
                                        class="mt-1 block w-full"
                                        min="1"
                                        max="100"
                                        required
                                    />
                                    <InputError v-if="errors.count" :message="errors.count[0]" class="mt-2" />
                                </div>

                                <PrimaryButton
                                    @click="dispatchJobs"
                                    :disabled="isDispatching"
                                    class="w-full justify-center"
                                >
                                    <span v-if="isDispatching">Dispatching...</span>
                                    <span v-else>Dispatch Jobs</span>
                                </PrimaryButton>

                                <div
                                    v-if="message"
                                    class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800"
                                >
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

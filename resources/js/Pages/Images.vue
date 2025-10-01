<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const images = ref([]);
const getImages = () => {
    axios.get(route('images.index')).then((response) => {
        images.value = response.data.images;
    });
};
getImages();

const imageInput = ref(null);
const imageName = ref(null);

const uploadImage = () => {
    console.log(imageInput.value.files[0]);
    let formData = new FormData();
    formData.append('image', imageInput.value.files[0]);
    formData.append('name', imageName.value.value);
    axios.post(route('images.store'),formData,
    {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    }).then((response) => {
        getImages();
    });
};

const deleteImage = (id) => {
    axios.delete(route('images.destroy', id)).then((response) => {
        getImages();
    });
};

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Images
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex flex-col gap-2 p-4">
                        <form @submit.prevent="uploadImage">
                            <div class="flex flex-col gap-2">
                                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                                    Upload Image
                                </h2>
                                <div>
                                    Image: <input type="file" ref="imageInput" />
                                </div>
                                <div>
                                    Name: <input type="text" ref="imageName" />
                                </div>
                                <div>
                                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">Upload</button>
                                </div>

                            </div>
                        </form>
                        <div class="flex flex-col gap-2">
                            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                                Images
                            </h2>
                            <div class="grid grid-cols-3 gap-1">
                                <div v-for="image in images" :key="image.id"  v-if="images.length > 0" class="rounded-md border-2 border-gray-300">
                                    <div class="flex flex-col p-2 w-full">
                                        <img :src="image.path" alt="Image" class="object-cover w-full h-full rounded-md" />
                                        <p class="text-sm text-gray-500">Name:{{ image.name }}</p>
                                        <p class="w-full text-sm text-gray-500 break-words word-wrap">Path:{{ image.path }}</p>
                                        <p class="text-sm text-gray-500">Created At:{{ image.created_at }}</p>
                                        <button @click="deleteImage(image.id)" class="px-4 py-2 text-white bg-red-500 rounded-md">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="images.length === 0">
                                <p>No images found</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

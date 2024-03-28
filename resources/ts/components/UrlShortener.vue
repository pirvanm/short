<script lang="ts" setup>
import { ref } from "vue";
import { copyText } from "vue3-clipboard";

import Swal from "sweetalert2";
import axios from "axios";

const url = ref("");
const shortenedUrl = ref<string | null>(null);
const loading = ref(false);

const shortenUrl = () => {
    loading.value = true;

    axios
        .post("/api/generateHash", {
            url: url.value,
        })
        .then((response) => {
            shortenedUrl.value = response.data.url;
        })
        .catch((error) => {
            Swal.fire({
                title: "Whoops!",
                text: error.response.data.message,
                icon: "error",
            });
        })
        .finally(() => {
            loading.value = false;
        });
};

const onCopy = () => {
    Swal.fire("URL copied!");
};

const onError = () => {
    Swal.fire("URL not copied!");
};
</script>

<template>
    <div
        class="bg-gray-100 border border-gray-200 rounded py-12 px-8 flex flex-col w-full md:w-10/12 lg:w-8/12 xl:w-6/12 text-center gap-4"
    >
        <h1 class="text-4xl mb-10 font-bold text-gray-700">URL Shortner</h1>
        <div class="flex mb-4">
            <input
                v-model="url"
                placeholder="Type URL..."
                type="url"
                class="w-full px-4 py-2.5 border border-gray-300 rounded rounded-r-none text-lg placeholder:text-lg focus:outline-none focus:ring-1 focus:ring-blue-300"
            />
            <button
                @click="shortenUrl"
                class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-1 focus:ring-blue-300 rounded-lg text-xl font-medium px-5 py-2.5 rounded-l-none"
            >
                Shorten
            </button>
        </div>
        <div v-if="loading" class="text-center">Loading</div>
        <div
            v-if="shortenedUrl"
            class="bg-gray-200 border border-gray-300 px-4 py-4 rounded flex justify-between items-center"
        >
            <div class="text-gray-700">
                Shortened URL:
                <span class="font-medium">{{ shortenedUrl }}</span>
            </div>
            <div>
                <button
                    class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-1 focus:ring-blue-300 rounded-lg text-lg px-5 py-1.5"
                    v-clipboard:copy="shortenedUrl"
                    v-clipboard:success="onCopy"
                    v-clipboard:error="onError"
                >
                    copy
                </button>
            </div>
        </div>
    </div>
</template>

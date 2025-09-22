<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center p-6 lg:justify-center lg:p-8 bg-[#0f0f0f]">
        <div class="flex w-full justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full flex-col-reverse overflow-hidden rounded-lg lg:flex-row">
                <div class="p-4 w-full font-sans text-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <button
                            @click="downloadData"
                            :disabled="downloading"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition cursor-pointer"
                        >{{ downloading ? "Stahování ..." : "Stáhnout" }}</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-white shadow-sm rounded">
                            <thead class="bg-gray-600">
                                <tr>
                                    <th class="text-left px-4 py-2">ID</th>
                                    <th class="text-left px-4 py-2">Jméno</th>
                                    <th class="text-left px-4 py-2">Příjmení</th>
                                    <th class="text-left px-4 py-2">Datum</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    v-for="zaznam in zaznamy"
                                    :key="zaznam.id"
                                    @click="highlightRow(zaznam.id)"
                                    :class="[
                                        'hover:bg-gray-800',
                                        'cursor-pointer',
                                        highlightedRows.includes(zaznam.id) ? 'bg-gray-500' : ''
                                    ]"
                                >
                                    <td class="px-4 py-2">{{ zaznam.id }}</td>
                                    <td class="px-4 py-2">{{ zaznam.jmeno }}</td>
                                    <td class="px-4 py-2">{{ zaznam.prijmeni }}</td>
                                    <td class="px-4 py-2">{{ new Date(zaznam.datum).toLocaleDateString("cs-CZ") }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    zaznamy: Array
});

const downloading = ref(false);
const highlightedRows = ref([]);

async function downloadData() {
    downloading.value = true;

    try {
        const response = await fetch("/download", {
            method: "POST",

            headers: {
                "X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]").getAttribute("content"),
                "Accept": "application/json"
            }
        });

        if (!response.ok) {
            throw new Error("Download failed");
        }

        router.reload({ only: ["zaznamy"] });
    } catch (error) {
        console.error(error);
    } finally {
        downloading.value = false;
    }
}

function highlightRow(id: number) {
    if (highlightedRows.value.includes(id)) {
        highlightedRows.value = highlightedRows.value.filter(hId => hId !== id);
    } else {
        highlightedRows.value.push(id);
    }
}
</script>

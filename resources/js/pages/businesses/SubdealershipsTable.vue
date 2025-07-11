<script setup lang="ts">
import { ChevronDown, ChevronRight, Trash } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    subdealerships: {
        type: Array as () => Array<{
            id: number;
            name: string;
            ruc: string;
            dealership: {
                id: number;
                name: string;
            };
        }>,
        required: true,
    },
    dealerships: {
        type: Array as () => Array<{
            id: number;
            name: string;
            ruc: string;
        }>,
        default: () => [],
    },
});

const expandedDealerships = ref<number[]>([]);

const toggleExpand = (id: number) => {
    const index = expandedDealerships.value.indexOf(id);
    if (index === -1) {
        expandedDealerships.value.push(id);
    } else {
        expandedDealerships.value.splice(index, 1);
    }
};

const generateQRUrl = (id: number) => {
    return `${window.location.origin}/qr/${id}`;
};
</script>

<template>
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md transition-all duration-200 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800"
    >
        <!-- Encabezado -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50 p-4 dark:border-gray-700 dark:from-gray-700 dark:to-gray-700">
            <h2 class="flex items-center text-xl font-semibold text-gray-800 dark:text-white">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5 text-blue-600 dark:text-blue-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                    />
                </svg>
                Relación Concesionarias - Subconcesionarias
            </h2>
        </div>

        <!-- Contenido -->
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Lista de Concesionarias -->
            <template v-for="dealership in props.dealerships" :key="`dealership-${dealership.id}`">
                <div class="group transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <button
                                @click="toggleExpand(dealership.id)"
                                class="mr-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                            >
                                <ChevronDown v-if="expandedDealerships.includes(dealership.id)" class="h-5 w-5" />
                                <ChevronRight v-else class="h-5 w-5" />
                            </button>
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">
                                    {{ dealership.name }}
                                    <span
                                        class="ml-2 rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                                        >Concesionaria</span
                                    >
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">RUC: {{ dealership.ruc }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <!-- <a
                                :href="generateQRUrl(dealership.id)"
                                target="_blank"
                                class="rounded-full p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30"
                                title="Generar QR"
                            >
                                <QrCode class="h-5 w-5" />
                            </a> -->
                            <button class="rounded-full p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30" title="Eliminar">
                                <Trash class="h-5 w-5" />
                            </button>
                        </div>
                    </div>

                    <!-- Subconcesionarias -->
                    <div v-if="expandedDealerships.includes(dealership.id)" class="pl-14">
                        <div
                            v-for="subdealership in props.subdealerships.filter((sd) => sd.dealership.id === dealership.id)"
                            :key="`subdealership-${subdealership.id}`"
                            class="border-t border-gray-200 p-4 transition-colors duration-150 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/30"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">
                                        {{ subdealership.name }}
                                        <span
                                            class="ml-2 rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-200"
                                            >Subconcesionaria</span
                                        >
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">RUC: {{ subdealership.ruc }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <!-- <a
                                        :href="generateQRUrl(subdealership.id)"
                                        target="_blank"
                                        class="rounded-full p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30"
                                        title="Generar QR"
                                    >
                                        <QrCode class="h-5 w-5" />
                                    </a> -->
                                    <button class="rounded-full p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30" title="Eliminar">
                                        <Trash class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="props.subdealerships.filter((sd) => sd.dealership.id === dealership.id).length === 0"
                            class="border-t border-gray-200 p-4 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400"
                        >
                            Esta concesionaria no tiene subconcesionarias registradas
                        </div>
                    </div>
                </div>
            </template>

            <!-- Subconcesionarias sin concesionaria padre -->
            <template v-if="props.dealerships.length === 0">
                <div
                    v-for="subdealership in props.subdealerships"
                    :key="`subdealership-${subdealership.id}`"
                    class="p-4 transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700/30"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">
                                {{ subdealership.name }}
                                <span
                                    class="ml-2 rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-200"
                                    >Subconcesionaria</span
                                >
                            </h4>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">RUC: {{ subdealership.ruc }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <!-- <a
                                :href="generateQRUrl(subdealership.id)"
                                target="_blank"
                                class="rounded-full p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30"
                                title="Generar QR"
                            >
                                <QrCode class="h-5 w-5" />
                            </a> -->
                            <button class="rounded-full p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30" title="Eliminar">
                                <Trash class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Estado vacío -->
            <div v-if="props.subdealerships.length === 0 && props.dealerships.length === 0" class="p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay concesionarias registradas</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agrega tu primera concesionaria para comenzar</p>
            </div>
        </div>
    </div>
</template>

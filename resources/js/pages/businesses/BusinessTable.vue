<script setup lang="ts">
import ServicePopover from './ServicePopover.vue';

const props = defineProps({
    businesses: {
        type: Array,
        default: () => [],
    },
    services: {
        type: Array,
        default: () => [],
    },
    headquarters: {
        type: Array,
        default: () => [],
    },
});

const getBusinessHeadquarters = (businessId) => {
    return props.headquarters.filter((h) => h.business.id === businessId);
};
</script>
<template>
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md transition-all duration-200 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800"
    >
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
                Empresas y sus Sedes
            </h2>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <div
                v-for="business in businesses"
                :key="business.id"
                class="group transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700"
            >
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">{{ business.name }}</h3>
                            <p v-if="business.description" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ business.description }}
                            </p>
                        </div>
                        <ServicePopover
                            :services="services"
                            :business="business"
                            class="opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                        />
                    </div>

                    <div v-if="getBusinessHeadquarters(business.id).length > 0" class="mt-3 space-y-2">
                        <div
                            v-for="headquarter in getBusinessHeadquarters(business.id)"
                            :key="headquarter.id"
                            class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-600 dark:bg-gray-700/50"
                        >
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">{{ headquarter.name }}</h4>
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        <span v-if="headquarter.address" class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="mr-1 h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                            </svg>
                                            {{ headquarter.address }}
                                        </span>
                                        <span v-if="headquarter.phone" class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="mr-1 h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                />
                                            </svg>
                                            {{ headquarter.phone }}
                                        </span>
                                    </div>
                                </div>
                                <button class="text-red-500 hover:text-red-700 dark:hover:text-red-400" title="Eliminar sede">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        v-else
                        class="mt-3 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-3 text-center dark:border-gray-600 dark:bg-gray-700/30"
                    >
                        <p class="text-sm text-gray-500 dark:text-gray-400">Esta empresa no tiene sedes registradas</p>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="businesses.length === 0" class="p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay empresas</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agrega tu primera empresa para comenzar</p>
        </div>
    </div>
</template>

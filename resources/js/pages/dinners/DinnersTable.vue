<script setup lang="ts">
import { Dinner, Service } from '@/types';
import SaleDialog from './SaleDialog.vue';

const props = defineProps({
    dinners: {
        type: Array as () => Dinner[],
        required: true,
    },
    services: {
        type: Array as () => Service[],
        required: true,
    },
});
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-2 lg:grid-cols-3">
            <div
                class="group overflow-hidden rounded-lg border-l-4 border-orange-400 bg-white shadow-sm transition-all hover:-translate-y-0.5 hover:border-orange-500 hover:shadow-md"
                v-for="service in services"
                :key="service.id"
            >
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-lg font-semibold text-gray-800" :title="service.name">{{ service.name }}</p>
                            <p class="mt-1 text-sm text-gray-500">
                                Código: <span class="font-mono">{{ service.code }}</span>
                            </p>
                            <div class="mt-3">
                                <SaleDialog :services="props.services" />
                            </div>
                        </div>
                        <div class="ml-2 flex flex-col items-end">
                            <span
                                class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 transition-colors group-hover:bg-green-200"
                                >S./{{ service.pivot.price }}</span
                            >
                            <span v-if="service.duration" class="mt-2 flex items-center text-xs text-gray-400">
                                <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                                {{ service.duration }} min
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

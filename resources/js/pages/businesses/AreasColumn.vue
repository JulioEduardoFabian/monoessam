<script setup lang="ts">
import { Area } from '@/types';

interface Props {
    areas: Area[];
}

defineProps<Props>();
</script>

<template>
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
    >
        <!-- Header -->
        <div
            class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-zinc-100/50 px-5 py-3.5 dark:border-gray-700 dark:from-gray-800 dark:to-gray-700/50"
        >
            <div class="flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/10">
                    <i class="ri-building-line text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Áreas de la Sede</h3>
                    <p class="text-xs text-zinc-500 dark:text-gray-400">
                        {{ areas.length }} {{ areas.length === 1 ? 'área registrada' : 'áreas registradas' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="p-4">
            <!-- Lista de áreas -->
            <div v-if="areas.length > 0" class="space-y-2.5">
                <div
                    v-for="area in areas"
                    :key="area.id"
                    class="group relative overflow-hidden rounded-lg border border-zinc-200 bg-gradient-to-br from-white to-zinc-50/50 p-4 transition-all duration-200 hover:border-blue-300 hover:shadow-md dark:border-gray-600 dark:from-gray-700 dark:to-gray-700/50 dark:hover:border-blue-500"
                >
                    <!-- Efecto de hover -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-blue-500/0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                    ></div>

                    <!-- Contenido del área -->
                    <div class="relative flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-50 transition-colors duration-200 group-hover:bg-blue-100 dark:bg-blue-900/20 dark:group-hover:bg-blue-900/30"
                        >
                            <i class="ri-layout-grid-line text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ area.name }}</p>
                            <p class="text-xs text-zinc-500 dark:text-gray-400">ID: {{ area.id }}</p>
                        </div>
                        <i
                            class="ri-arrow-right-s-line text-zinc-400 opacity-0 transition-all duration-200 group-hover:translate-x-1 group-hover:opacity-100 dark:text-gray-500"
                        ></i>
                    </div>
                </div>
            </div>

            <!-- Estado vacío -->
            <div v-else class="flex flex-col items-center justify-center py-12">
                <div class="relative mb-4">
                    <!-- Círculo de fondo animado -->
                    <div class="absolute inset-0 animate-pulse rounded-full bg-zinc-100 dark:bg-gray-700"></div>

                    <!-- Icono -->
                    <div
                        class="relative flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-gray-700 dark:to-gray-600"
                    >
                        <i class="ri-inbox-line text-4xl text-zinc-400 dark:text-gray-500"></i>
                    </div>
                </div>

                <h4 class="mb-2 text-lg font-semibold text-zinc-900 dark:text-white">No hay áreas registradas</h4>
                <p class="mb-4 max-w-sm text-center text-sm text-zinc-500 dark:text-gray-400">
                    Esta sede aún no tiene áreas asignadas. Agrega tu primera área para comenzar.
                </p>

                <!-- Botón de acción opcional -->
                <!-- <button
                    class="group/btn flex items-center gap-2 rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white transition-all duration-200 hover:bg-blue-600 hover:shadow-md active:scale-95"
                >
                    <i class="ri-add-line transition-transform duration-200 group-hover/btn:rotate-90"></i>
                    <span>Agregar área</span>
                </button> -->
            </div>
        </div>
    </div>
</template>

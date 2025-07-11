<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';
const props = defineProps({
    headquarters: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md transition-all duration-200 dark:border-gray-700 dark:bg-gray-800"
    >
        <Table>
            <TableCaption
                class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50 p-4 dark:border-gray-700 dark:from-gray-700 dark:to-gray-700"
            >
                <div class="flex items-center">
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
                    <span class="text-lg font-semibold text-gray-800 dark:text-white">Lista de Sedes del Sistema</span>
                </div>
            </TableCaption>
            <TableHeader class="bg-gray-50 dark:bg-gray-700">
                <TableRow class="hover:bg-transparent">
                    <TableHead class="py-3 font-medium text-gray-600 dark:text-gray-300">Sede</TableHead>
                    <TableHead class="py-3 font-medium text-gray-600 dark:text-gray-300">Empresa</TableHead>
                    <TableHead class="py-3 text-right font-medium text-gray-600 dark:text-gray-300">Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody class="divide-y divide-gray-200 dark:divide-gray-700">
                <TableRow
                    v-for="headquarter in props.headquarters"
                    :key="headquarter.id"
                    class="transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700"
                >
                    <TableCell class="py-3 font-medium text-gray-900 dark:text-white">
                        {{ headquarter.name }}
                    </TableCell>
                    <TableCell class="py-3 text-gray-600 dark:text-gray-300">
                        {{ headquarter.business.name }}
                    </TableCell>
                    <TableCell class="py-3 text-right">
                        <Button
                            variant="ghost"
                            size="sm"
                            class="rounded-full p-2 text-red-500 transition-colors hover:bg-red-50 dark:hover:bg-red-900/30"
                            aria-label="Eliminar sede"
                        >
                            <Trash class="h-4 w-4" />
                        </Button>
                    </TableCell>
                </TableRow>
                <TableRow v-if="props.headquarters.length === 0">
                    <TableCell colspan="3" class="py-6 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mx-auto h-12 w-12 text-gray-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay sedes registradas</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agrega tu primera sede para comenzar</p>
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

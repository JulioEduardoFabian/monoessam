<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Ingredient, Service } from '@/types';
import { Head } from '@inertiajs/vue3';
import NewIngredientDialog from '../logistics/NewIngredientDialog.vue';
import NewProviderDialog from '../logistics/NewProviderDialog.vue';

const props = defineProps<{
    services: Service[];
    providers: any[];
    ingredients: Ingredient[];
}>();
</script>

<template>
    <Head title="Ingredientes" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
            <!-- Header mejorado -->
            <div class="md:col-span-3">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Ingredientes</h1>
                        <p class="mt-1 text-sm text-gray-500">Lista completa de ingredientes y sus proveedores</p>
                    </div>
                    <div class="flex gap-2">
                        <NewProviderDialog />
                        <NewIngredientDialog :providers="providers" :ingredients="ingredients" />
                        <button class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 transition-colors hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Exportar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtros de búsqueda -->
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Buscar</label>
                        <input
                            type="text"
                            placeholder="Nombre del ingrediente..."
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Proveedor</label>
                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option>Todos los proveedores</option>
                            <option v-for="provider in props.providers" :key="provider.id">{{ provider.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Ordenar por</label>
                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option>Nombre (A-Z)</option>
                            <option>Nombre (Z-A)</option>
                            <option>Precio (Mayor a menor)</option>
                            <option>Precio (Menor a mayor)</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full rounded-md bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700">
                            Aplicar filtros
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla mejorada -->
            <div class="md:col-span-3">
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Proveedor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Unidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Precio Unitario</th>
                                <th class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <template v-for="provider in props.providers" :key="provider.id">
                                <tr
                                    v-for="(ingredient, index) in provider.ingredients"
                                    :key="ingredient.id"
                                    :class="{ 'bg-gray-50': index % 2 === 0 }"
                                >
                                    <td
                                        v-if="index === 0"
                                        :rowspan="provider.ingredients.length"
                                        class="border-r border-gray-200 px-6 py-4 align-top text-sm font-medium whitespace-nowrap text-gray-900"
                                    >
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-600">
                                                {{ provider.name.charAt(0) }}
                                            </div>
                                            <div>
                                                <p class="font-medium">{{ provider.name }}</p>
                                                <p class="text-xs text-gray-500">{{ provider.ingredients.length }} productos</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-900">
                                        {{ ingredient.name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-500">
                                        {{ ingredient.unit || 'kg' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-gray-900">
                                        S./ {{ ingredient.pivot.cost_price }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                        <div class="flex justify-end gap-2">
                                            <button class="rounded p-1 text-blue-600 hover:bg-blue-50 hover:text-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                                    />
                                                </svg>
                                            </button>
                                            <button class="rounded p-1 text-red-600 hover:bg-red-50 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr v-if="providers.length === 0">
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2 text-gray-500">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 opacity-50"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                            />
                                        </svg>
                                        <p class="font-medium">No hay ingredientes registrados</p>
                                        <p class="text-sm">Comienza agregando un nuevo ingrediente</p>
                                        <button class="mt-2 rounded-lg bg-blue-600 px-4 py-2 text-sm text-white transition-colors hover:bg-blue-700">
                                            Agregar primer ingrediente
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4 flex items-center justify-between rounded-b-lg border-t border-gray-200 bg-white px-4 py-3">
                    <div class="flex flex-1 justify-between sm:hidden">
                        <button
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Anterior
                        </button>
                        <button
                            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Siguiente
                        </button>
                    </div>
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Mostrando <span class="font-medium">1</span> a <span class="font-medium">10</span> de
                                <span class="font-medium">20</span> resultados
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <button
                                    class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50"
                                >
                                    <span class="sr-only">Anterior</span>
                                    <svg
                                        class="h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                                <button
                                    aria-current="page"
                                    class="relative z-10 inline-flex items-center border border-blue-500 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600"
                                >
                                    1
                                </button>
                                <button
                                    class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50"
                                >
                                    2
                                </button>
                                <button
                                    class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50"
                                >
                                    3
                                </button>
                                <button
                                    class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50"
                                >
                                    <span class="sr-only">Siguiente</span>
                                    <svg
                                        class="h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

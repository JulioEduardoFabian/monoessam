<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import Input from '@/components/ui/input/Input.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import axios from 'axios';
import { Trash } from 'lucide-vue-next';
import { ref } from 'vue';
import DatePicker from './DatePicker.vue';

interface Props {
    categories: [];
}

defineProps<Props>();

const categoriesSelected = ref([]);

const dishesSearched = ref([]);

const breakfastDishes = ref([]);
const lunchDishes = ref([]);
const dinnerDishes = ref([]);

const selectCategory = (category: any) => {
    categoriesSelected.value.push(category);
};

const searchDish = (e) => {
    axios
        .get('/search-dish/' + e.target.value)
        .then((result) => {
            dishesSearched.value = result.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const selectDish = (dish) => {
    breakfastDishes.value.push(dish);
};
</script>

<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-2 aspect-video overflow-hidden rounded-xl border">
                    <DropdownMenu>
                        <DropdownMenuTrigger>Seleccionar Categoría</DropdownMenuTrigger>
                        <DropdownMenuContent>
                            <DropdownMenuItem v-for="category in categories" :key="category.id" @click="selectCategory(category)">{{
                                category.name
                            }}</DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[105px]">Orden</TableHead>
                                <TableHead class="">Codigo</TableHead>
                                <TableHead class="">Nombre de Categoria</TableHead>
                                <TableHead class="">Volumen Referenecial</TableHead>
                                <TableHead class="">Ración</TableHead>
                                <TableHead class="">Costo unitario</TableHead>
                                <TableHead class="">Costo Total</TableHead>
                                <TableHead class="text-right">Opciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="category in categoriesSelected" :key="category.id">
                                <TableCell class="w-[105px]"><Input type="number" /></TableCell>
                                <TableCell class="text-right">{{ category.id }}</TableCell>
                                <TableCell class="">{{ category.name }}</TableCell>
                                <TableCell class="text-right"> </TableCell>
                                <TableCell class="text-right"> </TableCell>
                                <TableCell class="text-right"> </TableCell>
                                <TableCell class="text-right"> </TableCell>
                                <TableCell class="text-right">
                                    <Button><Trash /></Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                        <TableCaption>Lista de categorías de la nueva estructura.</TableCaption>
                    </Table>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-1 aspect-video overflow-hidden rounded-xl border">
                    <p>Menus</p>
                </div>
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-2 aspect-video overflow-hidden overflow-y-auto rounded-xl border"
                >
                    <h1>Programación</h1>
                    <DatePicker :breakfasts="breakfastDishes" />
                </div>
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-1 aspect-video overflow-hidden overflow-y-auto rounded-xl border"
                >
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Platos</h2>

                        <div class="relative">
                            <Input
                                type="text"
                                @keyup="searchDish"
                                placeholder="Buscar platos..."
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 transition-all duration-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                            />
                            <svg
                                class="absolute top-3.5 right-3 h-5 w-5 text-gray-400 dark:text-gray-300"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>

                        <ul class="max-h-96 space-y-2 overflow-y-auto pr-2">
                            <li
                                v-for="dish in dishesSearched"
                                :key="dish.id"
                                class="cursor-pointer rounded-xl border border-gray-200 bg-white p-3 transition-colors duration-200 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600"
                                @click="selectDish(dish)"
                            >
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-800 dark:text-white">{{ dish.name }}</span>
                                    <span class="rounded-full bg-blue-100 px-2 py-1 text-sm text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ dish.dish_category.name }}
                                    </span>
                                </div>
                            </li>

                            <li v-if="dishesSearched.length === 0" class="p-3 text-center text-gray-500 dark:text-gray-400">
                                No se encontraron platos
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import { Dish } from '@/types';
import axios from 'axios';
import { ref } from 'vue';

const dishesSearched = ref([] as Dish[]);
const dialogRefs = ref<HTMLElement[]>([]);

const searchDish = (e: any) => {
    if (!e.target.value) {
        dishesSearched.value = [];
        return;
    }

    axios
        .get('/search-dish/' + e.target.value)
        .then((result) => {
            dishesSearched.value = result.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const dragstartHandler = (e: any) => {
    const dishId = e.target.id;

    const dishSelected = dishesSearched.value.find((dish) => `dish${dish.id}` === dishId);

    e.dataTransfer.setData('dishObject', JSON.stringify(dishSelected));
    e.dataTransfer.setData('text', dishId);
};
</script>

<template>
    <div
        class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-1 aspect-video overflow-hidden overflow-y-auto rounded-xl border"
    >
        <div class="space-y-4">
            <h2 class="text-md text-center font-bold text-gray-800 dark:text-white">Platos</h2>

            <div class="relative">
                <Input
                    type="text"
                    @keyup="searchDish"
                    placeholder="Buscar platos..."
                    class="mx-2 w-[95%] border border-gray-300 px-4 py-3 transition-all duration-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                />
            </div>

            <ul class="max-h-96 space-y-2 overflow-y-auto pr-2">
                <p
                    draggable="true"
                    @dragstart="dragstartHandler"
                    @dragover.prevent
                    @dragenter.prevent
                    :id="`dish${dish.id}`"
                    v-for="dish in dishesSearched"
                    :key="dish.id"
                    class="w-full rounded border p-2"
                >
                    {{ dish.name }} - {{ dish.dish_categories[0].name }}
                </p>
                <li v-if="dishesSearched.length === 0" class="p-3 text-center text-gray-500 dark:text-gray-400">No se encontraron platos</li>
            </ul>
        </div>
    </div>
</template>

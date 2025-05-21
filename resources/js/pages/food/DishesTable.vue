<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dish } from '@/types';
import axios from 'axios';
import { Pencil } from 'lucide-vue-next';
import { ref } from 'vue';
import IngredientsPopover from './IngredientsPopover.vue';

const props = defineProps<{
    dishes?: Dish[];
}>();

const searchDish = (e) => {
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

const dishesSearched = ref([]);
dishesSearched.value = props.dishes || [];
</script>
<template>
    <Input @keyup="searchDish"></Input>
    <Table>
        <TableCaption>Lista de Platos del Sistema.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[100px]">Nombre</TableHead>
                <TableHead class="w-[200px]">Categoria</TableHead>
                <TableHead class="text-right">Opciones</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="dish in dishesSearched" :key="dish.id" class="overflow-x-visible">
                <TableCell class="w-[100px]" :title="dish.name">{{
                    dish.name.length > 30 ? dish.name.substring(0, 30) + '...' : dish.name
                }}</TableCell>
                <TableCell class="w-[200px] font-medium">{{ dish.dish_category.name }}</TableCell>
                <TableCell class="text-right">
                    <Button class="mx-1 bg-blue-400"><Pencil /></Button>
                    <IngredientsPopover :ingredients="dish.ingredients" />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

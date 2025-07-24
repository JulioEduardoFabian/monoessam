<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DishCategory } from '@/types';
import axios from 'axios';
import { Trash } from 'lucide-vue-next';
import { ref } from 'vue';
const props = defineProps<{
    dishCategories: DishCategory[];
}>();

const dishCategoriesPassed = ref([]);

dishCategoriesPassed.value = props.dishCategories;

const deleteDishCategory = (dishCategoryId: string) => {
    if (confirm('Quieres eliminar esta categoría de plato?')) {
        axios
            .delete('/delete-dish-category/' + dishCategoryId)
            .then((result) => {
                dishCategoriesPassed.value = dishCategoriesPassed.value.filter((category) => category.id != dishCategoryId);
            })
            .catch((err) => {
                console.log(err);
            });
    }
};
</script>
<template>
    <Table>
        <TableCaption>Lista de Categoría de Platos.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[200px]">Nombre</TableHead>
                <TableHead class="w-[100px]">Descripción</TableHead>
                <TableHead class="w-[100px]">Unidad</TableHead>
                <TableHead class="text-right">Opciones</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="dishCategory in dishCategoriesPassed" :key="dishCategory.id">
                <TableCell class="font-medium">{{ dishCategory.name }}</TableCell>
                <TableCell class="font-medium">{{ dishCategory.description }}</TableCell>
                <TableCell class="font-medium">{{ dishCategory.mesearument_unit }}</TableCell>
                <TableCell class="text-right">
                    <Button @click="deleteDishCategory(dishCategory.id)" size="sm" class="bg-red-500"><Trash class="h-4 w-4" /></Button>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

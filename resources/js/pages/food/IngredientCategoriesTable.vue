<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { IngredientCategory } from '@/types';
import { Trash } from 'lucide-vue-next';
const props = defineProps<{
    ingredientCategories: IngredientCategory[];
}>();
</script>
<template>
    <div class="w-full overflow-x-auto">
        <Table class="w-full min-w-[600px]">
            <TableCaption>Lista de Categorías de Ingredientes.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[150px]">Nombre</TableHead>
                    <!-- Reduje el ancho -->
                    <TableHead class="w-[250px]">Descripción</TableHead>
                    <!-- Ajusté el ancho -->
                    <TableHead class="w-[100px] text-right">Opciones</TableHead>
                    <!-- Ancho más pequeño -->
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="ingredientCategory in props.ingredientCategories" :key="ingredientCategory.id">
                    <TableCell class="truncate" :title="ingredientCategory.name">{{
                        ingredientCategory.name.length > 30 ? ingredientCategory.name.substring(0, 30) + '...' : ingredientCategory.name
                    }}</TableCell>
                    <!-- Added truncate -->
                    <TableCell class="truncate" :title="ingredientCategory.description">{{
                        ingredientCategory.description.length > 30
                            ? ingredientCategory.description.substring(0, 30) + '...'
                            : ingredientCategory.description
                    }}</TableCell>
                    <!-- Added truncate -->
                    <TableCell class="text-right">
                        <Button size="sm" class="bg-red-500"><Trash class="h-4 w-4" /></Button>
                        <!-- <Button size="sm"><Pencil class="h-4 w-4" /></Button> -->
                        <!-- Hice el botón más pequeño -->
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

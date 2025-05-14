<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Pencil } from 'lucide-vue-next';

const props = defineProps<{
    dishes?: Dish[];
}>();
</script>
<template>
    <Table>
        <TableCaption>Lista de Platos del Sistema.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[100px]">Nombre</TableHead>
                <TableHead>Categoria</TableHead>
                <TableHead class="text-right">Opciones</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="dish in dishes" :key="dish.id">
                <TableCell class="w-[100px]">{{ dish.name }}</TableCell>
                <TableCell class="font-medium">{{ dish.dish_category.name }}</TableCell>
                <TableCell class="text-right">
                    <Button><Pencil /></Button>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import Input from '@/components/ui/input/Input.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    categories?: [];
}>();

const categoriesSelected = ref([]);

const selectCategory = (category: any) => {
    categoriesSelected.value.push(category);
};

const deleteCategory = (index) => {
    console.log(index);
    categoriesSelected.value.splice(index, 1);
};
</script>

<template>
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
                <TableRow v-for="(category, index) in categoriesSelected" :key="category.id">
                    <TableCell class="w-[105px]"><Input type="number" /></TableCell>
                    <TableCell class="text-right">{{ category.id }}</TableCell>
                    <TableCell class="">{{ category.name }}</TableCell>
                    <TableCell class="text-right"> <Input type="number" /></TableCell>
                    <TableCell class="text-right"><Input type="number" /></TableCell>
                    <TableCell class="text-right"> <Input type="number" /></TableCell>
                    <TableCell class="text-right"> <Input type="number" /></TableCell>
                    <TableCell class="text-right">
                        <Button @click="deleteCategory(index)"><Trash /></Button>
                    </TableCell>
                </TableRow>
            </TableBody>
            <TableCaption>Lista de categorías de la nueva estructura.</TableCaption>
        </Table>
    </div>
</template>

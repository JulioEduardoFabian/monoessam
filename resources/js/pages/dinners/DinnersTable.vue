<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';

const props = defineProps({
    dinners: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Table>
            <TableCaption>Lista de Comensales del Sistema. </TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="">Nombre</TableHead>
                    <TableHead class="">DNI</TableHead>
                    <TableHead class="">Telefono</TableHead>
                    <TableHead class="">Cafetería</TableHead>
                    <TableHead>Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="dinner in props.dinners" :key="dinner.id">
                    <TableCell class="font-medium">{{ dinner.name }}</TableCell>
                    <TableCell class="">{{ dinner.dni }}</TableCell>
                    <TableCell class="">{{ dinner.phone }}</TableCell>
                    <TableCell class="">{{ dinner.cafe.name }}</TableCell>
                    <TableCell
                        ><Button class="bg-red-400"><Trash /></Button
                    ></TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

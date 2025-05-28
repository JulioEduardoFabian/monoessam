<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';
import ServicePopover from './ServicePopover.vue';

const props = defineProps({
    businesses: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Table>
            <TableCaption>Lista de Empresas del Sistema.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="">Empresa</TableHead>
                    <TableHead class="">Servicios</TableHead>
                    <TableHead>Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="business in businesses" :key="business.id">
                    <TableCell class="font-medium">{{ business.name }}</TableCell>
                    <TableCell class="font-medium"><ServicePopover /></TableCell>
                    <TableCell
                        ><Button class="bg-red-400"><Trash /></Button
                    ></TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

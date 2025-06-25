<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';

const props = defineProps({
    services: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Table>
            <TableCaption>Lista de Servicios del Sistema. </TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="">Servicio</TableHead>
                    <TableHead>Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="service in services" :key="service.id">
                    <TableCell class="font-medium">{{ service.name }}</TableCell>
                    <TableCell
                        ><Button class="bg-red-400"><Trash /></Button
                    ></TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

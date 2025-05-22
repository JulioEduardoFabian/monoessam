<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';
const props = defineProps({
    headquarters: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Table>
            <TableCaption>Lista de Sedes del Sistema.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="">Sede</TableHead>
                    <TableHead class="">Empresa</TableHead>
                    <TableHead>Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="headquarter in props.headquarters" :key="headquarter.id">
                    <TableCell class="font-medium">{{ headquarter.name }}</TableCell>
                    <TableCell class="font-medium">{{ headquarter.business.name }}</TableCell>
                    <TableCell
                        ><Button class="bg-red-400"><Trash /></Button
                    ></TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

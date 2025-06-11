<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Trash } from 'lucide-vue-next';
import { ref } from 'vue';
const properties = ref([
    { id: 1, name: 'Laptop Dell XPS 13' },
    { id: 2, name: 'Proyector Epson' },
    { id: 3, name: 'Impresora HP LaserJet' },
    { id: 4, name: 'Monitor Samsung 24"' },
    { id: 5, name: 'Teclado Mecánico Logitech' },
    { id: 6, name: 'Mouse Inalámbrico Logitech' },
    { id: 7, name: 'Disco Duro Externo Seagate' },
    { id: 8, name: 'Router TP-Link Archer C6' },
]);

const props = defineProps({
    subdealerships: {
        type: Array,
        required: true,
    },
});

const generateQRUrl = (id: number) => {
    return `${window.location.origin}/qr/${id}`;
};
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden overflow-y-auto rounded-xl border">
        <Table>
            <TableCaption>Lista de Subconcesionarias de la Empresa. </TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="">Subconsecionaria</TableHead>
                    <TableHead class="">Consecionaria</TableHead>
                    <TableHead class="">RUC</TableHead>
                    <TableHead>Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="subdealership in props.subdealerships" :key="subdealership.id">
                    <TableCell class="font-medium">{{ subdealership.name }}</TableCell>
                    <TableCell class="font-medium">{{ subdealership.dealership.name }}</TableCell>
                    <TableCell>
                        {{ subdealership.ruc }}
                    </TableCell>
                    <TableCell
                        ><Button class="bg-red-400"><Trash /></Button
                    ></TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

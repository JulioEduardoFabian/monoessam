<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import SaleDetailsPopover from './SaleDetailsPopover.vue';
/* const searchDish = (e) => {
    if (!e.target.value) {
        dishesSearched.value = [];
        return;
    }

    axios
        .get('/sales/'e)
        .then((result) => {
            sales.value = result.data;
        })
        .catch((err) => {
            console.log(err);
        });
}; */

const props = defineProps({
    sales: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Table>
            <TableCaption>Lista de Ventas</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]">DNI</TableHead>
                    <TableHead class="w-[200px]">Nombre</TableHead>
                    <TableHead class="w-[200px]">Total</TableHead>
                    <TableHead class="text-right">Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="sale in props.sales" :key="sale.id">
                    <TableCell class="w-[100px]">{{ sale.tickets[0]?.dinner.dni }}</TableCell>
                    <TableCell class="w-[200px] font-medium" :title="sale.name">{{ sale.tickets[0]?.dinner.name }}</TableCell>
                    <TableCell class="w-[200px] font-medium" :title="sale.total">{{ parseFloat(sale.total).toFixed(2) }}</TableCell>
                    <TableCell class="text-right">
                        <Button>Imprimir</Button>
                        <SaleDetailsPopover :ticket="sale.tickets[0]" />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

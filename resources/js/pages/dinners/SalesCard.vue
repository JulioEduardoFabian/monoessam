<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Service } from '@/types';
import axios from 'axios';
import { Trash } from 'lucide-vue-next';
import { ref } from 'vue';
import SaleDialog from './SaleDialog.vue';

const props = defineProps({
    services: {
        type: Array as () => Service[],
        required: true,
    },
});

const dinnersFound = ref([]);

const searchDinner = (event: Event) => {
    event.preventDefault();

    axios
        .get('/search-dinner/' + event.target.value)
        .then((response) => {
            dinnersFound.value = response.data;
        })
        .catch((error) => {
            console.error('Error fetching dinners:', error);
        });
};
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Card class="min-h-full w-full p-3 shadow">
            <p class="text-center font-semibold">Ventas</p>
            <div class="mt-2">
                <Input type="text" placeholder="Buscar por dni o nombre de comensal" class="w-full" @keyup="searchDinner" />
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="">Nombre</TableHead>
                            <TableHead class="">DNI</TableHead>
                            <TableHead class="">Unidad</TableHead>
                            <TableHead class="">Cafetería</TableHead>
                            <TableHead>Opciones</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="dinner in dinnersFound" :key="dinner.id">
                            <TableCell class="font-medium">{{ dinner.name }}</TableCell>
                            <TableCell class="">{{ dinner.dni }}</TableCell>
                            <TableCell class="">{{ dinner.cafe.unit.name }}</TableCell>
                            <TableCell class="">{{ dinner.cafe.name }}</TableCell>
                            <TableCell class="flex items-center justify-start gap-2">
                                <SaleDialog :services="props.services" />
                                <Button class="bg-red-400"><Trash /></Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </Card>
    </div>
</template>

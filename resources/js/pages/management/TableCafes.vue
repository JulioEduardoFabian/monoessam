<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Service } from '@/types';
import { Pencil } from 'lucide-vue-next';
import ServiceablesPopover from './ServiceablesPopover.vue';

const props = defineProps<{
    cafes: {
        id: number;
        name: string;
        unit: {
            name: string;
            mine: {
                name: string;
            };
        };
    }[];
    services: Service[];
}>();
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>Cafeterías</CardTitle>
        </CardHeader>
        <CardContent class="space-y-4">
            <Table>
                <TableCaption>Lista de Cafeterías del Sistema.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">Nombre</TableHead>
                        <TableHead class="w-[100px]">Unidad</TableHead>
                        <TableHead class="w-[100px]">Mina</TableHead>
                        <TableHead class="text-right">Opciones</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="cafe in props.cafes" :key="cafe.id">
                        <TableCell class="font-medium">{{ cafe.name }}</TableCell>
                        <TableCell class="font-medium">{{ cafe.unit.name }}</TableCell>
                        <TableCell class="font-medium">{{ cafe.unit.mine.name }}</TableCell>
                        <TableCell class="flex flex-row justify-end gap-2 text-right">
                            <Button><Pencil /></Button>
                            <ServiceablesPopover :services="cafe.unit.services" :business="cafe" :placeType="3" />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </CardContent>
    </Card>
</template>

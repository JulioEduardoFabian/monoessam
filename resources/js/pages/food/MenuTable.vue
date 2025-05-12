<script setup lang="ts">
import { Table, TableBody, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
</script>
<template>
    <Table>
        <TableCaption>Lista de Menus del Sistema.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[200px]">Nombre</TableHead>
                <TableHead class="w-[100px]">Unidad</TableHead>
                <TableHead class="text-right">Opciones</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <!-- <TableRow v-for="mine in mines" :key="mine.id">
                                <TableCell class="font-medium">{{ mine.name }}</TableCell>
                                <TableCell class="text-right">
                                    <Button><Pencil /></Button>
                                </TableCell>
                            </TableRow> -->
        </TableBody>
    </Table>
</template>

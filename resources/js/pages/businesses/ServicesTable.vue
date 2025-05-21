<script setup lang="ts">
import { Table, TableBody, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Table>
            <TableCaption>Lista de Servicios del Sistema.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="">Servicio</TableHead>
                    <TableHead>Opciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <!--  <TableRow v-for="business in businesses" :key="business.id">
                    <TableCell class="font-medium">{{ business.name }}</TableCell>
                    <TableCell
                        ><Button class="bg-red-400"><Trash /></Button
                    ></TableCell>
                </TableRow> -->
            </TableBody>
        </Table>
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Cafe, Mine, Unit } from '@/types';
import { Head } from '@inertiajs/vue3';
import ManagementModal from './ManagementModal.vue';

interface Props {
    mines: Mine[];
    units: Unit[];
    cafes: Cafe[];
}

defineProps<Props>();
</script>
<template>
    <Head title="Lugares" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <Table>
                        <TableCaption>Lista de Minas del Sistema.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[100px]">Nombre</TableHead>
                                <TableHead class="text-right">Opciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="mine in mines" :key="mine.id">
                                <TableCell class="font-medium">{{ mine.name }}</TableCell>
                                <TableCell class="text-right"> <Button>Editar</Button> </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <Table>
                        <TableCaption>Lista de Unidades del Sistema.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[100px]">Nombre</TableHead>
                                <TableHead class="text-right">Opciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="unit in units" :key="unit.id">
                                <TableCell class="font-medium">{{ unit.name }}</TableCell>
                                <TableCell class="text-right"> <Button>Editar</Button> </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <Table>
                        <TableCaption>Lista de Cafes del Sistema.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[100px]">Nombre</TableHead>
                                <TableHead class="text-right">Opciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="cafe in cafes" :key="cafe.id">
                                <TableCell class="font-medium">{{ cafe.name }}</TableCell>
                                <TableCell class="text-right"> <Button>Editar</Button> </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
        <ManagementModal />
    </AppLayout>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Pencil } from 'lucide-vue-next';
const props = defineProps<{
    mines: { id: number; name: string }[];
}>();
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>Minas</CardTitle>
        </CardHeader>
        <CardContent class="space-y-4">
            <Table>
                <TableCaption>Lista de Minas del Sistema.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">Nombre</TableHead>
                        <TableHead class="text-right">Opciones</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="mine in props.mines" :key="mine.id">
                        <TableCell class="font-medium">{{ mine.name }}</TableCell>
                        <TableCell class="text-right">
                            <Button><Pencil /></Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </CardContent>
    </Card>
</template>

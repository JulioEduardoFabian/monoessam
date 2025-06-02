<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'; /* PartiallyEnd: #3632/scriptSetup.vue */
import TableCafes from './TableCafes.vue';
import TableMines from './TableMines.vue';
import TableUnits from './TableUnits.vue';

const props = defineProps<{
    mines: { id: number; name: string }[];
    units: { id: number; name: string; mine: object }[];
    cafes: { id: number; name: string }[];
}>();
</script>

<template>
    <Tabs default-value="mines" class="w-full">
        <TabsList class="grid w-full grid-cols-3">
            <TabsTrigger value="mines"> Minas </TabsTrigger>
            <TabsTrigger value="units"> Unidades </TabsTrigger>
            <TabsTrigger value="cafes"> Cafeterías </TabsTrigger>
        </TabsList>
        <TabsContent value="mines">
            <TableMines :mines="props.mines" />
        </TabsContent>
        <TabsContent value="units">
            <TableUnits :units="props.units" />
        </TabsContent>
        <TabsContent value="cafes">
            <TableCafes :cafes="props.cafes" />
        </TabsContent>
    </Tabs>
</template>

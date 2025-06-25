<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'; /* PartiallyEnd: #3632/scriptSetup.vue */
import { Service } from '@/types';
import TableCafes from './TableCafes.vue';
import TableMines from './TableMines.vue';
import TableUnits from './TableUnits.vue';

const props = defineProps<{
    mines: { id: number; name: string }[];
    units: { id: number; name: string; mine: object }[];
    cafes: { id: number; name: string }[];
    services: Service[];
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
            <TableMines :mines="props.mines" :services="services" />
        </TabsContent>
        <TabsContent value="units">
            <TableUnits :units="props.units" :services="services" />
        </TabsContent>
        <TabsContent value="cafes">
            <TableCafes :cafes="props.cafes" :services="services" />
        </TabsContent>
    </Tabs>
</template>

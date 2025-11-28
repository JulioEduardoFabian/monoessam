<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Unit } from '@/types';

// La prop 'units' ahora incluye la relación 'cafes' para el siguiente nivel.
interface UnitWithCafes extends Unit {
    cafes: { id: number; name: string }[];
}

const props = defineProps<{
    units: UnitWithCafes[];
    selectedUnitId: number | null;
}>();

const emit = defineEmits<{
    (e: 'selectUnit', id: number): void;
}>();

/**
 * Emite el ID de la unidad seleccionada.
 * Si se hace clic en la unidad ya seleccionada, la deselecciona (emite null).
 * @param unitId ID de la unidad
 */
const selectUnit = (unitId: number) => {
    if (unitId === props.selectedUnitId) {
        emit('selectUnit', null); // Deseleccionar
    } else {
        emit('selectUnit', unitId); // Seleccionar
    }
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Unidades 🏢</CardTitle>
        </CardHeader>
        <CardContent class="max-h-[80vh] space-y-2 overflow-y-auto">
            <div v-if="units && units.length > 0">
                <div
                    v-for="unit in units"
                    :key="unit.id"
                    @click="selectUnit(unit.id)"
                    :class="{
                        'cursor-pointer rounded-lg border p-3 transition-colors': true,
                        'border-yellow-700 bg-yellow-500 text-white shadow-lg': unit.id === selectedUnitId,
                        'border-gray-200 hover:bg-gray-100': unit.id !== selectedUnitId,
                    }"
                >
                    <div class="font-semibold">{{ unit.name }}</div>
                    <!-- <div class="text-sm" :class="{ 'text-white/80': unit.id === selectedUnitId, 'text-gray-500': unit.id !== selectedUnitId }">
                        {{ unit.cafes.length }} Cafetería(s)
                    </div> -->
                </div>
            </div>
            <div v-else class="p-4 text-center text-gray-500">No hay unidades asociadas a esta Mina.</div>
        </CardContent>
    </Card>
</template>

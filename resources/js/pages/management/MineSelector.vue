<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

defineProps<{
    mines: { id: number; name: string }[];
    selectedMineId: number | null;
}>();

const emit = defineEmits<{
    (e: 'selectMine', id: number): void;
}>();
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Minas ⛏️</CardTitle>
        </CardHeader>
        <CardContent class="max-h-[80vh] space-y-2 overflow-y-auto">
            <div
                v-for="mine in mines"
                :key="mine.id"
                @click="emit('selectMine', mine.id)"
                :class="{
                    'cursor-pointer rounded-lg p-3 transition-colors': true,
                    'bg-blue-500 text-white shadow-lg': mine.id === selectedMineId,
                    'hover:bg-gray-100': mine.id !== selectedMineId,
                }"
            >
                {{ mine.name }}
            </div>
        </CardContent>
    </Card>
</template>

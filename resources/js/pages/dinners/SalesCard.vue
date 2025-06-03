<script setup lang="ts">
import { Card } from '@/components/ui/card';
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
        <Card class="min-h-full w-full p-3 shadow">
            <p class="text-center font-semibold">Ventas del Día</p>
            <div class="mt-2">
                <p class="font-bold">Desayuno</p>
                <div class="drop-area mb-2 min-h-[50px] rounded bg-gray-100 p-2" @dragover.prevent @drop.prevent>
                    <p class="text-sm">No hay ventas registradas.</p>
                </div>
                <p class="font-bold">Almuerzo</p>
                <div class="drop-area mb-2 min-h-[50px] rounded bg-gray-100 p-2" @dragover.prevent @drop.prevent>
                    <p class="text-sm">No hay ventas registradas.</p>
                </div>
                <p class="font-bold">Cena</p>
                <div class="drop-area mb-2 min-h-[50px] rounded bg-gray-100 p-2" @dragover.prevent @drop.prevent>
                    <p class="text-sm">No hay ventas registradas.</p>
                </div>
            </div>
        </Card>
    </div>
</template>

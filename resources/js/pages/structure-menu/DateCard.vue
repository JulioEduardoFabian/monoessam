<script setup lang="ts">
import { Card } from '@/components/ui/card';

type Dish = { id: number; name: string };

const props = defineProps<{
    dateRangeArray?: {
        formatted: string;
        desayuno?: Dish[];
        almuerzo?: Dish[];
        cena?: Dish[];
    }[];
}>();

// Para manejar el evento de drop
function handleDrop(e: any, mealType: string, index: number) {
    e.preventDefault();
    const dishData = e.dataTransfer?.getData('text');
    const dishObject = e.dataTransfer?.getData('dishObject');
    const original = document.getElementById(dishData);
    if (original) {
        const clone = original.cloneNode(true);
        clone.id = `${original.id}-copy-${Date.now()}`;
        // Asegúrate que el contenedor tenga una clase clara, como .drop-area
        const dropZone = e.currentTarget.closest('.drop-area');
        if (dropZone) {
            dropZone.appendChild(clone);

            const newDish = JSON.parse(dishObject);

            const mealTypes = {
                desayuno: 'desayuno',
                almuerzo: 'almuerzo',
                cena: 'cena',
            };

            newDish.mealType = mealTypes[mealType];

            props.dateRangeArray[index].dishes.push(newDish);

            console.log(props.dateRangeArray);
        }
    }
}

function allowDrop(event: DragEvent) {
    event.preventDefault();
}
</script>

<template>
    <Card v-for="(date, index) in dateRangeArray" :key="index" class="min-h-[200px] w-72 p-3 shadow">
        <p class="text-center font-semibold">{{ date.formatted }}</p>

        <div class="mt-2">
            <p class="font-bold">Desayuno</p>
            <div class="drop-area mb-2 min-h-[50px] rounded bg-gray-100 p-2" @dragover="allowDrop" @drop="(e) => handleDrop(e, 'desayuno', index)">
                <p v-for="dish in date.desayuno" :key="dish.id" class="text-sm">
                    {{ dish.name }}
                </p>
            </div>

            <p class="font-bold">Almuerzo</p>
            <div class="drop-area mb-2 min-h-[50px] rounded bg-gray-100 p-2" @dragover="allowDrop" @drop="(e) => handleDrop(e, 'almuerzo', index)">
                <p v-for="dish in date.almuerzo" :key="dish.id" class="text-sm">
                    {{ dish.name }}
                </p>
            </div>

            <p class="font-bold">Cena</p>
            <div class="drop-area min-h-[50px] rounded bg-gray-100 p-2" @dragover="allowDrop" @drop="(e) => handleDrop(e, 'cena', index)">
                <p v-for="dish in date.cena" :key="dish.id" class="text-sm">
                    {{ dish.name }}
                </p>
            </div>
        </div>
    </Card>
</template>

<script setup lang="ts">
import { Card } from '@/components/ui/card';
const props = defineProps<{
    dateRangeArray?: [];
}>();
</script>

<template>
    <Card v-for="(date, index) in dateRangeArray" :key="index" class="p-3">
        <p class="text-center">{{ date.formatted }}</p>
        <p>Desayuno</p>
        <p v-for="dish in date.dishes" :key="dish.id">{{ dish.name }}</p>
        <p>Almuerzo</p>
        <p>Cena</p>
    </Card>
</template>

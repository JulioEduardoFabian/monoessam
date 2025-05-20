<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type DateValue, getLocalTimeZone, today } from '@internationalized/date';
import { type Ref, ref } from 'vue';
import CategorySelection from './CategorySelection.vue';
import DishSearch from './DishSearch.vue';
import MealSchedule from './MealSchedule.vue';
import MenuDisplay from './MenuDisplay.vue';

interface Props {
    categories: [];
}

defineProps<Props>();

const value = ref(today(getLocalTimeZone())) as Ref<DateValue>;

const dishesSearched = ref([]);

const lunchDishes = ref([]);
const dinnerDishes = ref([]);

const selectDish = (dish) => {
    dishesPicked.value.push(dish);
};
</script>

<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <CategorySelection :categories="categories" />
                <MenuDisplay />
                <MealSchedule />
                <DishSearch />
            </div>
        </div>
    </AppLayout>
</template>

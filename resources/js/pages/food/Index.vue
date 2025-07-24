<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Dish, DishCategory, Ingredient, IngredientCategory } from '@/types';
import { Head } from '@inertiajs/vue3';
import DishCategoriesModal from './DishCategoriesModal.vue';
import DishesTable from './DishesTable.vue';
import IngredientCategoriesModal from './IngredientCategoriesModal.vue';
import IngredientCategoriesTable from './IngredientCategoriesTable.vue';
import MenuTable from './MenuTable.vue';
import NewDishModal from './NewDishModal.vue';

interface Props {
    dishes: Dish[];
    ingredient_categories: IngredientCategory[];
    dish_categories: DishCategory[];
    ingredients: Ingredient[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <NewDishModal :ingredients="ingredients" />
                    <DishesTable :dishes="dishes" />
                </div>
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden overflow-y-auto rounded-xl border"
                >
                    <h6 class="text-center font-bold">Categoría de Platos</h6>
                    <DishCategoriesModal />
                    <MenuTable :dishCategories="dish_categories" />
                </div>
                <div
                    class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden overflow-y-auto rounded-xl border"
                >
                    <h6 class="text-center font-bold">Categoría de Ingredientes</h6>
                    <IngredientCategoriesModal />
                    <IngredientCategoriesTable :ingredientCategories="ingredient_categories" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

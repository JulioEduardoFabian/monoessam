<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { computed } from 'vue';

const props = defineProps({
    ingredient_city_providers: {
        type: Array as () => any[],
        required: true,
        default: () => [],
    },
});

// Función para agrupar ingredientes por ciudad
const groupedByCity = computed(() => {
    const grouped: Record<number, any> = {};

    props.ingredient_city_providers.forEach((item) => {
        if (!grouped[item.city_id]) {
            grouped[item.city_id] = {
                city: item.city,
                ingredients: [],
            };
        }

        // Verificar si el ingrediente ya existe para evitar duplicados
        const existingIngredient = grouped[item.city_id].ingredients.find((ing: any) => ing.ingredient_id === item.ingredient_id);

        if (!existingIngredient) {
            grouped[item.city_id].ingredients.push({
                ...item.ingredient,
                providers: props.ingredient_city_providers
                    .filter((x) => x.ingredient_id === item.ingredient_id && x.city_id === item.city_id)
                    .map((provider) => ({
                        provider_name: provider.provider.name,
                        cost_price: provider.cost_price,
                    })),
            });
        }
    });

    return grouped;
});
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <h1 class="mb-6 text-2xl font-bold">Ingredientes por Ciudad y Proveedor</h1>

            <div v-for="(cityData, cityId) in groupedByCity" :key="cityId" class="mb-8">
                <div class="overflow-hidden rounded-lg bg-white shadow-md">
                    <!-- Encabezado de la ciudad -->
                    <div class="border-b bg-gray-100 px-4 py-3">
                        <h2 class="text-xl font-semibold">{{ cityData.city.name }}</h2>
                    </div>

                    <!-- Lista de ingredientes -->
                    <div v-for="(ingredient, index) in cityData.ingredients" :key="ingredient.id" :class="{ 'border-t': index > 0 }">
                        <div class="px-4 py-3">
                            <h3 class="text-lg font-medium text-gray-800">
                                {{ ingredient.name }}
                            </h3>
                            <p class="mb-2 text-sm text-gray-600">{{ ingredient.description }}</p>

                            <div class="grid grid-cols-1 gap-2 text-sm md:grid-cols-2">
                                <div>
                                    <span class="font-medium">Presentación:</span>
                                    {{ ingredient.presentation }}
                                </div>
                                <div>
                                    <span class="font-medium">Calorías:</span>
                                    {{ ingredient.calories }} kcal
                                </div>
                                <div>
                                    <span class="font-medium">Unidad de medida:</span>
                                    {{ ingredient.measurement_unit }}
                                </div>
                                <div>
                                    <span class="font-medium">Desperdicio:</span>
                                    Líquido {{ ingredient.liquid_waste * 100 }}%, Sólido {{ ingredient.solid_waste * 100 }}%
                                </div>
                            </div>

                            <!-- Proveedores y precios -->
                            <div class="mt-3">
                                <h4 class="mb-1 font-medium text-gray-700">Proveedores:</h4>
                                <ul class="divide-y divide-gray-200">
                                    <li v-for="provider in ingredient.providers" :key="provider.provider_name" class="flex justify-between py-2">
                                        <span>{{ provider.provider_name }}</span>
                                        <span class="font-medium">S/ {{ provider.cost_price }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!ingredient_city_providers.length" class="py-8 text-center text-gray-500">No hay datos disponibles</div>
        </div>
    </AppLayout>
</template>

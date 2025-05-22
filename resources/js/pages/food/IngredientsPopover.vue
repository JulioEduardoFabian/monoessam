<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Ingredient } from '@/types';
import { Soup } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps<{
    ingredients: Ingredient[];
}>();

const popoverOpen = ref(false);

// Inicializar los permisos seleccionados basados en el rol actual
watch(
    () => props.ingredients,
    (role) => {},
    { immediate: true },
);
</script>

<template>
    <Popover v-model:open="popoverOpen">
        <PopoverTrigger asChild>
            <Button class="bg-green-400"><Soup /></Button>
        </PopoverTrigger>
        <PopoverContent class="w-64 p-4">
            <div class="grid grid-cols-2 gap-2">
                <p v-for="ingredient in props.ingredients" :key="ingredient.id">
                    {{ ingredient.name }}
                </p>
            </div>
        </PopoverContent>
    </Popover>
</template>

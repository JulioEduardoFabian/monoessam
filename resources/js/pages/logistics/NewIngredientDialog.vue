<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Ingredient } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const open = ref(false);
const ingredientsFounded = ref([] as Ingredient[]);
const searchIngredient = ref('');
const ingredientSelectedId = ref(0);
const providerSelectedId = ref(0);
const cityId = ref(0);

const form = useForm({
    ingredient_id: 0,
    provider_id: 0,
    city_id: 0,
    cost_price: 0,
});

const props = defineProps<{
    providers: any[];
    ingredients: Ingredient[];
}>();

const submit = () => {
    form.post(route('providers.assign'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
    });
};

const searchIngredients = (e: Event) => {
    const element = e.target as HTMLInputElement;

    if (element?.value == '') ingredientsFounded.value = [];
    else ingredientsFounded.value = props.ingredients?.filter((ingredient) => ingredient.name.toLowerCase().includes(element?.value)).slice(0, 10);
};

const selectIngredient = (ingredient: Ingredient) => {
    searchIngredient.value = ingredient.name;
    ingredientsFounded.value = [];
    form.ingredient_id = ingredient.id;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger
            ><Button title="Agregar Usuario" class="h-full w-auto bg-blue-600"><Plus /> Nueva asignación</Button></DialogTrigger
        >
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Nueva asignación</DialogTitle>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Proveedor</label>
                    <select
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        v-model="form.provider_id"
                    >
                        <option v-for="provider in props.providers" :key="provider.id" :value="provider.id">{{ provider.name }}</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Ciudad</label>
                    <select
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        v-model="form.city_id"
                    >
                        <option value="1">LIMA</option>
                        <option value="2">HUANCAYO</option>
                    </select>
                </div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Ingrediente</label>
                <Input type="text" placeholder="Nombre de ingrediente" @keyup="searchIngredients" v-model="searchIngredient" />
                <table>
                    <tbody>
                        <tr v-for="ingredient in ingredientsFounded" :key="ingredient.id">
                            <Button @click="selectIngredient(ingredient)">{{ ingredient.name }}</Button>
                        </tr>
                    </tbody>
                </table>
                <label class="mb-1 block text-sm font-medium text-gray-700">Precio de Costo</label>
                <Input type="number" placeholder="Precio" v-model="form.cost_price" />
            </DialogHeader>
            <DialogFooter>
                <Button @click="submit">Agregar</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

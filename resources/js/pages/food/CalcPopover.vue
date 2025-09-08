<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Ingredient, Provider } from '@/types';
import { ref, watch } from 'vue';

const props = defineProps<{
    ingredient: Ingredient;
    totalMateriaPrima: number;
    totalSolidWaste: number;
    totalLiquidWaste: number;
    totalCalories: number;
    totalCost: number;
    totalfinalProduct: number;
}>();

const emits = defineEmits(['calcMassiveProperties']);

const ingredientSelected = ref(props.ingredient);
const providerSelected = ref(0);
const priceSelected = ref(0.0);
const priceUeGr = ref(0.0);
const baseCost = ref(0.0);
const baseCostPercentage = ref(0.0);
const finalProduct = ref(0.0);
const finalProductPercentage = ref(0.0);

const updateCalcValues = (e: Event) => {
    baseCost.value = parseFloat(priceSelected.value) * parseFloat(e.target.value);

    ingredientSelected.value.gross_weight = e.target.value * 1000;
    ingredientSelected.value.solid_waste = (
        (ingredientSelected.value.gross_weight *
            parseFloat(ingredientSelected.value.amount) *
            parseFloat(ingredientSelected.value.originalValues.solid_waste)) /
        parseFloat(ingredientSelected.value.amount)
    ).toFixed(2);

    ingredientSelected.value.liquid_waste =
        (ingredientSelected.value.gross_weight *
            parseFloat(ingredientSelected.value.amount) *
            parseFloat(ingredientSelected.value.originalValues.liquid_waste)) /
        parseFloat(ingredientSelected.value.amount);
    console.log(ingredientSelected.value.liquid_waste);
    ingredientSelected.value.calories =
        (ingredientSelected.value.gross_weight *
            parseFloat(ingredientSelected.value.amount) *
            parseFloat(ingredientSelected.value.originalValues.calories)) /
        parseFloat(ingredientSelected.value.amount);

    finalProduct.value = ingredientSelected.value.gross_weight - ingredientSelected.value.solid_waste - ingredientSelected.value.liquid_waste;

    emits('calcMassiveProperties', ingredientSelected.value.id, [
        ingredientSelected.value.gross_weight,
        ingredientSelected.value.solid_waste,
        ingredientSelected.value.liquid_waste,
        ingredientSelected.value.calories,
        baseCost.value,
        finalProduct.value,
    ]);
};

const selectPrice = (provider: Provider) => {
    priceSelected.value = provider.pivot.cost_price;
    priceUeGr.value = priceSelected.value / 1000;
};

watch(props, (newValue) => {
    ingredientSelected.value.gross_weight_volume = ((ingredientSelected.value.gross_weight / newValue.totalMateriaPrima) * 100).toFixed(2);
    ingredientSelected.value.solid_waste_volume = ((ingredientSelected.value.solid_waste / newValue.totalSolidWaste) * 100).toFixed(2);
    ingredientSelected.value.liquid_waste_volume = ((ingredientSelected.value.liquid_waste / newValue.totalLiquidWaste) * 100).toFixed(2);
    ingredientSelected.value.calories_volume = ((ingredientSelected.value.calories / newValue.totalCalories) * 100).toFixed(2);
    baseCostPercentage.value = baseCost.value / props.totalCost;
    finalProductPercentage.value = finalProduct.value / props.totalfinalProduct;
});
</script>
<template>
    <Popover>
        <PopoverTrigger>
            <Button variant="outline" class="gap-2">
                <SettingsIcon class="h-4 w-4" />
                Valores Nutricionales
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-96" side="right">
            <div class="grid gap-4">
                <div class="space-y-4">
                    <h4 class="leading-none font-medium">Ajustes de ingrediente</h4>
                    <p class="text-muted-foreground text-sm">Modifica los valores nutricionales y de costos</p>
                </div>

                <Select v-model="providerSelected">
                    <SelectTrigger class="w-[180px]">
                        <SelectValue placeholder="Seleccione Proveedor" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Proveedores</SelectLabel>
                            <SelectItem
                                @click="selectPrice(provider)"
                                v-for="provider in ingredientSelected.providers"
                                :key="provider.id"
                                :value="provider.id"
                                >{{ provider.name }} - {{ provider.cities[0].name }}</SelectItem
                            >
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Separator />

                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <Label for="quantity">Precio Unitario</Label>
                        <Input v-model="priceSelected" type="text" class="h-8" readonly />
                    </div>
                    <div class="space-y-2">
                        <Label for="unit">Pr. x (UE)% Gr</Label>
                        <Input v-model="priceUeGr" type="text" class="h-8" readonly />
                    </div>
                    <div class="space-y-2">
                        <Label for="unit">Var x (UE)% Gr</Label>
                        <Input type="text" class="h-8" readonly />
                    </div>
                </div>

                <!-- Cantidad y Unidad -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="quantity">Cantidad</Label>
                        <Input v-model="ingredientSelected.quantity" @keyup="updateCalcValues($event)" type="text" id="quantity" class="h-8" />
                    </div>
                    <div class="space-y-2">
                        <Label for="unit">Unidad</Label>
                        <Input v-model="ingredientSelected.measurement_unit" type="text" id="unit" class="h-8" readonly />
                    </div>
                </div>

                <!-- Costos -->

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <Label for="baseCost">Costo Base</Label>
                        <Input v-model="baseCost" type="text" id="baseCost" class="h-8" />
                    </div>
                    <div class="space-y-2">
                        <Label for="costPercentage">% Costos</Label>
                        <Input v-model="baseCostPercentage" type="text" id="costPercentage" class="h-8" />
                    </div>
                </div>

                <Separator />

                <!-- Materia Prima -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="solidWaste"> Materia Prima </Label>
                        <span class="text-muted-foreground text-xs">% Volumen</span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="ingredientSelected.gross_weight" type="text" id="solidWaste" class="h-8 flex-1" />
                        <Input v-model="ingredientSelected.gross_weight_volume" type="text" class="h-8 w-16" placeholder="%" />
                    </div>
                </div>

                <!-- Desechos Sólidos -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="solidWaste"> Desecho sólido (original: {{ ingredientSelected.originalValues.solid_waste }}) </Label>
                        <span class="text-muted-foreground text-xs">% Volumen</span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="ingredientSelected.solid_waste" type="text" id="solidWaste" class="h-8 flex-1" />
                        <Input v-model="ingredientSelected.solid_waste_volume" type="text" class="h-8 w-16" placeholder="%" />
                    </div>
                </div>

                <!-- Desechos Líquidos -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="liquidWaste"> Desecho líquido (original: {{ ingredientSelected.originalValues.liquid_waste }}) </Label>
                        <span class="text-muted-foreground text-xs">% Volumen</span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="ingredientSelected.liquid_waste" type="text" id="liquidWaste" class="h-8 flex-1" />
                        <Input v-model="ingredientSelected.liquid_waste_volume" type="text" class="h-8 w-16" placeholder="%" />
                    </div>
                </div>

                <!-- Prod. Final -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="calories">Producto Final</Label>
                        <span class="text-muted-foreground text-xs">% Volumen</span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="finalProduct" type="text" id="final_product" class="h-8 flex-1" />
                        <Input v-model="finalProductPercentage" type="text" class="h-8 w-16" placeholder="%" />
                    </div>
                </div>

                <!-- Calorías -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="calories"> Calorías (original: {{ ingredientSelected.originalValues.calories }}) </Label>
                        <span class="text-muted-foreground text-xs">% Calorías</span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="ingredientSelected.calories" type="text" id="calories" class="h-8 flex-1" />
                        <Input v-model="ingredientSelected.calories_volume" type="text" class="h-8 w-16" placeholder="%" />
                    </div>
                </div>

                <Separator />

                <div class="flex justify-end gap-2">
                    <Button variant="outline" size="sm">Cancelar</Button>
                    <Button size="sm">Guardar</Button>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>

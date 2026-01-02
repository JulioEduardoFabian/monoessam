<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface Props {
    prendas: Array<{ label: string; talla: string }>;
}

defineProps<Props>();
</script>

<template>
    <div class="space-y-6">
        <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
            <div class="mb-4 flex flex-col justify-between border-b pb-2 sm:flex-row sm:items-center">
                <h3 class="text-lg font-semibold text-zinc-800">Implementos</h3>
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div
                    v-for="(prenda, index) in prendas"
                    :key="index"
                    class="flex items-start space-x-3 rounded border border-transparent p-2 hover:border-zinc-100 hover:bg-zinc-50"
                >
                    <div class="w-full space-y-1">
                        <Label :for="'prenda-' + index" class="cursor-pointer text-sm font-normal">
                            {{ prenda.label }}
                        </Label>

                        <!-- Selects para tallas S, M, L, XL, XXL (primeros 9) -->
                        <Select v-if="index < 9" v-model="prenda.talla">
                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="s">S</SelectItem>
                                <SelectItem value="m">M</SelectItem>
                                <SelectItem value="l">L</SelectItem>
                                <SelectItem value="xl">XL</SelectItem>
                                <SelectItem value="xxl">XXL</SelectItem>
                            </SelectContent>
                        </Select>

                        <!-- Select especial para Guantes (index 9) -->
                        <Select v-else-if="index === 9" v-model="prenda.talla">
                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="8">8</SelectItem>
                                <SelectItem value="9">9</SelectItem>
                            </SelectContent>
                        </Select>

                        <!-- Input de texto para el resto -->
                        <Input v-else placeholder="Talla" v-model="prenda.talla" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

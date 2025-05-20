<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import axios from 'axios';
import { ref } from 'vue';

const dishesSearched = ref([]);

const searchDish = (e) => {
    if (!e.target.value) {
        dishesSearched.value = [];
        return;
    }

    axios
        .get('/search-dish/' + e.target.value)
        .then((result) => {
            dishesSearched.value = result.data;
        })
        .catch((err) => {
            console.log(err);
        });
};
</script>

<template>
    <div
        class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-1 aspect-video overflow-hidden overflow-y-auto rounded-xl border"
    >
        <div class="space-y-4">
            <h2 class="text-md text-center font-bold text-gray-800 dark:text-white">Platos</h2>

            <div class="relative">
                <Input
                    type="text"
                    @keyup="searchDish"
                    placeholder="Buscar platos..."
                    class="mx-2 w-[95%] border border-gray-300 px-4 py-3 transition-all duration-200 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                />
            </div>

            <ul class="max-h-96 space-y-2 overflow-y-auto pr-2">
                <Dialog v-for="dish in dishesSearched" :key="dish.id">
                    <DialogTrigger as-child>
                        <Button variant="outline" class="w-full"> {{ dish.name }} - {{ dish.dish_category.name }} </Button>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Escoger fecha y turno</DialogTitle>
                        </DialogHeader>
                        <div class="grid gap-4 py-4">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="name" class="text-right"> Fecha </Label>
                                <Input id="name" value="Pedro Duarte" class="col-span-3" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="username" class="text-right"> Turno </Label>
                                <Select>
                                    <SelectTrigger class="col-span-3">
                                        <SelectValue placeholder="Seleccionar turno" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="desayuno">Desayuno</SelectItem>
                                        <SelectItem value="almuerzo">Almuerzo</SelectItem>
                                        <SelectItem value="cena">Cena</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        <DialogFooter>
                            <Button type="submit"> Asignar </Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>

                <li v-if="dishesSearched.length === 0" class="p-3 text-center text-gray-500 dark:text-gray-400">No se encontraron platos</li>
            </ul>
        </div>
    </div>
</template>

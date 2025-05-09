<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

// Estados para las listas de búsqueda
const mines = ref([]);
const units = ref([]);
const cafes = ref([]);
const open = ref(false);
const isLoading = ref({
    mine: false,
    unit: false,
    cafe: false,
});

const form = useForm({
    mine: '',
    mineId: 0,
    unit: '',
    unitId: 0,
    cafe: '',
    cafeId: 0,
});

const submit = () => {
    form.post(route('users'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
        },
    });
};

// Funciones de búsqueda
const searchMine = debounce(() => {
    if (form.mine.trim() === '') {
        mines.value = [];
        return;
    }
    isLoading.value.mine = true;
    axios
        .get('/search-mine/' + form.mine)
        .then((result) => {
            mines.value = result.data;
        })
        .catch(console.error)
        .finally(() => (isLoading.value.mine = false));
}, 300);

const searchUnit = debounce(() => {
    if (form.unit.trim() === '') {
        units.value = [];
        return;
    }
    isLoading.value.unit = true;
    axios
        .get('/search-unit/' + form.unit)
        .then((result) => {
            units.value = result.data;
        })
        .catch(console.error)
        .finally(() => (isLoading.value.unit = false));
}, 300);

const searchCafe = debounce(() => {
    if (form.cafe.trim() === '') {
        cafes.value = [];
        return;
    }
    isLoading.value.cafe = true;
    axios
        .get('/search-cafe/' + form.cafe)
        .then((result) => {
            cafes.value = result.data;
        })
        .catch(console.error)
        .finally(() => (isLoading.value.cafe = false));
}, 300);

// Funciones para crear nuevos elementos
const insertMine = () => {
    if (form.mine.trim() === '') return;

    isLoading.value.mine = true;
    axios
        .post('/mines', { name: form.mine })
        .then(() => {
            form.mineId = 0; // Reset para permitir nueva selección
            searchMine(); // Refrescar resultados
        })
        .catch(console.error)
        .finally(() => (isLoading.value.mine = false));
};

const insertUnit = () => {
    if (form.unit.trim() === '' || form.mineId == 0) return;

    isLoading.value.unit = true;
    axios
        .post('/units', { name: form.unit, mine_id: form.mineId })
        .then(() => {
            form.unitId = 0;
            searchUnit();
        })
        .catch(console.error)
        .finally(() => (isLoading.value.unit = false));
};

const insertCafe = () => {
    if (form.cafe.trim() === '' || form.unitId == 0) return;

    isLoading.value.cafe = true;
    axios
        .post('/cafes', { name: form.cafe, unit_id: form.unitId })
        .then(() => {
            form.cafeId = 0;
            searchCafe();
        })
        .catch(console.error)
        .finally(() => (isLoading.value.cafe = false));
};

// Funciones para seleccionar elementos
const selectMine = (mine: any) => {
    form.mine = mine.name;
    form.mineId = mine.id;
    mines.value = [];
    units.value = mine.units;
};

const selectUnit = (unit: any) => {
    form.unit = unit.name;
    form.unitId = unit.id;
    units.value = [];
    cafes.value = unit.cafes;
    console.log(unit);
};

const selectCafe = (cafe: any) => {
    form.cafe = cafe.name;
    form.cafeId = cafe.id;
    cafes.value = [];
};

// Función debounce para mejorar performance
function debounce(fn: Function, delay: number) {
    let timeoutId: number;
    return function (...args: any[]) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn.apply(null, args), delay);
    };
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button variant="outline">Añadir Lugar</Button>
        </DialogTrigger>
        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle class="mb-4 text-lg font-semibold">Agregar Nuevo Lugar</DialogTitle>

                <!-- Campo Mina -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium">Mina</label>
                    <div class="flex gap-2">
                        <Input v-model="form.mine" type="text" placeholder="Buscar mina..." @input="searchMine" @focus="searchMine" class="flex-1" />
                        <Button type="button" @click="insertMine" :disabled="!form.mine.trim() || isLoading.mine">
                            <span v-if="isLoading.mine">...</span>
                            <span v-else>+</span>
                        </Button>
                    </div>
                    <ul v-if="mines.length > 0" class="mt-1 max-h-40 overflow-auto rounded-md border">
                        <li
                            v-for="mine in mines"
                            :key="mine.id"
                            class="cursor-pointer p-2 hover:bg-gray-100 hover:text-black"
                            @click="selectMine(mine)"
                        >
                            {{ mine.name }}
                        </li>
                    </ul>
                </div>

                <!-- Campo Unidad -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium">Unidad</label>
                    <div class="flex gap-2">
                        <Input
                            v-model="form.unit"
                            type="text"
                            placeholder="Buscar unidad..."
                            @input="searchUnit"
                            @focus="searchUnit"
                            class="flex-1"
                        />
                        <Button type="button" @click="insertUnit" :disabled="!form.unit.trim() || isLoading.unit">
                            <span v-if="isLoading.unit">...</span>
                            <span v-else>+</span>
                        </Button>
                    </div>
                    <ul v-if="units.length > 0" class="mt-1 max-h-40 overflow-auto rounded-md border">
                        <li
                            v-for="unit in units"
                            :key="unit.id"
                            class="cursor-pointer p-2 hover:bg-gray-100 hover:text-black"
                            @click="selectUnit(unit)"
                        >
                            {{ unit.name }}
                        </li>
                    </ul>
                </div>

                <!-- Campo Café -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium">Cafetería</label>
                    <div class="flex gap-2">
                        <Input
                            v-model="form.cafe"
                            type="text"
                            placeholder="Buscar cafetería..."
                            @input="searchCafe"
                            @focus="searchCafe"
                            class="flex-1"
                        />
                        <Button type="button" @click="insertCafe" :disabled="!form.cafe.trim() || isLoading.cafe">
                            <span v-if="isLoading.cafe">...</span>
                            <span v-else>+</span>
                        </Button>
                    </div>
                    <ul v-if="cafes.length > 0" class="mt-1 max-h-40 overflow-auto rounded-md border">
                        <li
                            v-for="cafe in cafes"
                            :key="cafe.id"
                            class="cursor-pointer p-2 hover:bg-gray-100 hover:text-black"
                            @click="selectCafe(cafe)"
                        >
                            {{ cafe.name }}
                        </li>
                    </ul>
                </div>
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>

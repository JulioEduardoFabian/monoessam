<script setup lang="ts">
import { Card } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import { Service } from '@/types';
import axios from 'axios';
import { Badge, Building, Fingerprint, Phone, Sandwich, User } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    services: {
        type: Array as () => Service[],
        required: true,
    },
});

const dinnersFound = ref([]);
const subdealership = ref({});

const searchDinner = (event: Event) => {
    event.preventDefault();

    axios
        .get('/search-dinner/' + event.target.value)
        .then((response) => {
            dinnersFound.value = response.data;
            subdealership.value = response.data[0]?.subdealership || {};
        })
        .catch((error) => {
            console.error('Error fetching dinners:', error);
        });
};
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden overflow-y-auto rounded-xl border">
        <Card class="min-h-full w-full overflow-y-auto p-3 shadow">
            <p class="text-center font-semibold">Ventas</p>
            <div class="mt-2">
                <Input type="text" placeholder="Buscar por dni o nombre de comensal" class="w-full" @keyup.enter="searchDinner" />
                <div class="mt-2 grid auto-rows-min gap-4 md:grid-cols-2" v-if="dinnersFound.length > 0">
                    <div class="w-full max-w-md overflow-hidden rounded-lg bg-white shadow-md">
                        <div class="bg-red-600 p-4 text-white">
                            <h3 class="text-xl font-bold">Información de la Concesionaria</h3>
                        </div>
                        <div class="space-y-3 p-4">
                            <div class="flex items-center">
                                <Building />
                                <div>
                                    <p class="text-sm text-gray-500">Nombre</p>
                                    <p class="font-medium">{{ subdealership.name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Fingerprint />
                                <div>
                                    <p class="text-sm text-gray-500">RUC</p>
                                    <p class="font-medium">{{ subdealership.ruc }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Phone />
                                <div>
                                    <p class="text-sm text-gray-500">Teléfono</p>
                                    <p class="font-medium">{{ subdealership.phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full max-w-md overflow-hidden rounded-lg bg-white shadow-md">
                        <div class="bg-green-600 p-4 text-white">
                            <h3 class="text-xl font-bold">Información del Comensal</h3>
                        </div>
                        <div class="space-y-3 p-4">
                            <div class="flex items-center">
                                <User />
                                <div>
                                    <p class="text-sm text-gray-500">Nombre</p>
                                    <p class="font-medium">{{ dinnersFound[0].name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Badge />
                                <div>
                                    <p class="text-sm text-gray-500">DNI</p>
                                    <p class="font-medium">{{ dinnersFound[0].dni }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Phone />
                                <div>
                                    <p class="text-sm text-gray-500">Teléfono</p>
                                    <p class="font-medium">{{ dinnersFound[0].phone }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Sandwich />
                                <div>
                                    <p class="text-sm text-gray-500">Cafetería</p>
                                    <p class="font-medium">{{ dinnersFound[0].cafe.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

<script setup lang="ts">
import { Card } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import { Service } from '@/types';
import { Badge, Building, Fingerprint, Phone, Sandwich, User } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    services: {
        type: Array as () => Service[],
        required: true,
    },
    cafeSelected: {
        type: Number,
        required: true,
    },
    saletypeSelected: {
        type: Number,
        required: true,
    },
    servicesSelectedToSale: {
        type: Array as () => any[],
        required: true,
    },
    receiptType: {
        type: Number,
        required: true,
    },
    doublePrice: {
        type: Boolean,
    },
    dateSelected: {
        type: String,
        default: '',
    },
    dinnerFound: {
        type: Object,
    },
    subdealership: {
        type: Object,
    },
});

const emits = defineEmits(['handleShowAlert', 'showDialog', 'updateDni']);

const dni = ref('');
</script>
<template>
    <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden overflow-y-auto rounded-xl border">
        <Card class="min-h-full w-full overflow-y-auto p-3 shadow">
            <p class="text-center font-semibold">Punto de Venta</p>
            <div class="mt-2">
                <Input
                    type="text"
                    placeholder="Buscar por dni o nombre de comensal"
                    v-model="dni"
                    class="w-full"
                    @keyup.enter="emits('updateDni', dni)"
                />
                <div class="mt-2 grid auto-rows-min gap-4 md:grid-cols-2" v-if="dinnerFound.id">
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
                                    <p class="font-medium">{{ dinnerFound.name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Badge />
                                <div>
                                    <p class="text-sm text-gray-500">DNI</p>
                                    <p class="font-medium">{{ dinnerFound.dni }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Phone />
                                <div>
                                    <p class="text-sm text-gray-500">Teléfono</p>
                                    <p class="font-medium">{{ dinnerFound.phone }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <Sandwich />
                                <div>
                                    <p class="text-sm text-gray-500">Cafetería</p>
                                    <p class="font-medium">{{ dinnerFound.cafe?.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

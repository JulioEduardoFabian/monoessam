<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { Cafe, Dinner, Service, Unit } from '@/types';
import { Head } from '@inertiajs/vue3';
import { UserRoundPlus } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import DinnersTable from './DinnersTable.vue';
import ExcelDialog from './ExcelDialog.vue';
import PricesDialog from './PricesDialog.vue';
import SalesCard from './SalesCard.vue';

const cafeSelected = ref(0);
const servicesSelected = ref([]);

interface Props {
    dinners: Dinner[];
    services: Service[];
    units: Unit[];
    cafes: Cafe[];
}

const props = defineProps<Props>();

watch(cafeSelected, (newVal) => {
    const cafeSelected = props.cafes.find((cafe) => cafe.id === newVal);
    if (cafeSelected) {
        servicesSelected.value = cafeSelected.services;
    } else {
        servicesSelected.value = [];
    }
});
</script>
<template>
    <Head title="Comensales" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex h-[40px] w-full items-center justify-start gap-1">
                <Select class="w-full" v-model="cafeSelected">
                    <SelectTrigger>
                        <SelectValue placeholder="Selecciona una cafetería" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Comedores Autorizadas</SelectLabel>
                            <SelectItem v-for="cafe in cafes" :value="cafe.id" :key="cafe.id">
                                {{ cafe.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button class="bg-blue-500"><UserRoundPlus /></Button>
                <ExcelDialog />
                <PricesDialog :services="servicesSelected" />
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <SalesCard :services="services" />
                <DinnersTable :dinners="dinners" :services="servicesSelected" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Cafe } from '@/types';
import { UserRoundPlus } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import DatePicker from './DatePicker.vue';
import ExcelDialog from './ExcelDialog.vue';
import OtherUnitDialog from './OtherUnitDialog.vue';
import PricesDialog from './PricesDialog.vue';

interface Props {
    cafes: Cafe[];
    services: any[];
    receipt_types: any[];
    sale_types: any[];
}

interface SaleFormData {
    receipt_type_id: number;
    sale_type_id: number;
    cafe_id: number;
    date: string;
}

const emits = defineEmits(['showServicesFromCafeSelected', 'updateDate', 'updateFormData']);

const emitFormData = () => {
    const formData: SaleFormData = {
        receipt_type_id: receiptType.value,
        sale_type_id: saletypeSelected.value,
        cafe_id: cafeSelected.value,
    };
    emits('updateFormData', formData);
};

const props = defineProps<Props>();
const doublePrice = ref(false);

const cafeSelected = ref(0);
const saletypeSelected = ref(0);
const servicesSelected = ref([]);
const receiptType = ref(0);
const showOtherUnitDialog = ref(false);

const doublePriceSave = () => {
    doublePrice.value = true;
    showOtherUnitDialog.value = false;
};

watch(cafeSelected, (newVal) => {
    const cafeSelected = props.cafes.find((cafe) => cafe.id === newVal);
    if (cafeSelected) {
        servicesSelected.value = cafeSelected.services;
        emits('showServicesFromCafeSelected', servicesSelected.value);
    } else {
        servicesSelected.value = [];
        emits('showServicesFromCafeSelected', servicesSelected.value);
    }
});

watch([receiptType, saletypeSelected, cafeSelected], () => {
    emitFormData();
});

const updateDate = (date) => {
    emits('updateDate', date);
};
</script>
<template>
    <div class="flex h-[40px] w-full items-center justify-start gap-1">
        <Select class="w-full" v-model="receiptType">
            <SelectTrigger>
                <SelectValue placeholder="Selecciona un tipo de documento" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Tipo de Documento</SelectLabel>
                    <SelectItem v-for="receipt_type in receipt_types" :value="receipt_type.id" :key="receipt_type.id">
                        {{ receipt_type.name }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
        <Select class="w-full" v-model="saletypeSelected">
            <SelectTrigger>
                <SelectValue placeholder="Selecciona un tipo de venta" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Tipo de Venta</SelectLabel>
                    <SelectItem v-for="sale_type in sale_types" :value="sale_type.id" :key="sale_type.id">
                        {{ sale_type.name }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
        <Select class="w-full" v-model="cafeSelected">
            <SelectTrigger>
                <SelectValue placeholder="Selecciona una cafetería" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Cafeterías Autorizadas</SelectLabel>
                    <SelectItem v-for="cafe in cafes" :value="cafe.id" :key="cafe.id">
                        {{ cafe.name }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
        <DatePicker @updateDate="updateDate" />
        <Button class="bg-blue-500"><UserRoundPlus /></Button>
        <ExcelDialog />
        <PricesDialog :services="servicesSelected" />
        <OtherUnitDialog :showOtherUnitDialog="showOtherUnitDialog" @doublePriceSave="doublePriceSave" />
    </div>
</template>

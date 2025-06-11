<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Business, Headquarter } from '@/types';
import BusinessTable from './BusinessTable.vue';
import DealershipsDialog from './DealershipsDialog.vue';
import DealershipsTable from './DealershipsTable.vue';
import HeadquartersTable from './HeadquartersTable.vue';
import InsertModal from './InsertBusinessModal.vue';
import ServiceDialog from './ServiceDialog.vue';
import ServicesTable from './ServicesTable.vue';
import SubdealershipsDialog from './SubdealershipsDialog.vue';
import SubdealershipsTable from './SubdealershipsTable.vue';

interface Props {
    businesses: Business[];
    headquarters: Headquarter[];
    services: any[];
    dealerships: any[];
    subdealerships: any[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex h-[40px] w-full items-center justify-start gap-1">
                <InsertModal />
                <ServiceDialog />
                <SubdealershipsDialog :dealerships="dealerships" />
                <DealershipsDialog />
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <BusinessTable :businesses="businesses" :services="services" />
                <HeadquartersTable :headquarters="headquarters" />
                <ServicesTable :services="services" />
                <DealershipsTable :dealerships="dealerships" />
                <SubdealershipsTable :subdealerships="subdealerships" :dealerships="dealerships" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Business, Cafe, Mine, Service, Unit } from '@/types';
import { Head } from '@inertiajs/vue3';
import ManagementModal from './ManagementModal.vue';
import Tabs from './Tabs.vue';

interface Props {
    mines: Mine[];
    units: Unit[];
    cafes: Cafe[];
    services: Service[];
    businesses: Business[];
}

defineProps<Props>();
</script>
<template>
    <Head title="Lugares" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Tabs :mines="mines" :units="units" :cafes="cafes" :services="services" />
        </div>
        <ManagementModal :businesses="businesses" />
    </AppLayout>
</template>

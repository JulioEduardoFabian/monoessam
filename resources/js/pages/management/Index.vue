<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Cafe, Mine, Unit } from '@/types';
import { Head } from '@inertiajs/vue3';
import ManagementModal from './ManagementModal.vue';
import Tabs from './Tabs.vue';

interface Props {
    mines: Mine[];
    units: Unit[];
    cafes: Cafe[];
}

defineProps<Props>();
</script>
<template>
    <Head title="Lugares" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Tabs :mines="mines" :units="units" :cafes="cafes" />
        </div>
        <ManagementModal />
    </AppLayout>
</template>

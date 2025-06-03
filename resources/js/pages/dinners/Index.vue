<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Dinner } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Sheet, UserRoundPlus } from 'lucide-vue-next';
import DinnersTable from './DinnersTable.vue';
import SalesCard from './SalesCard.vue';

interface Props {
    dinners: Dinner[];
}

defineProps<Props>();
</script>
<template>
    <Head title="Comensales" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex h-[40px] w-full items-center justify-start gap-1">
                <Button class="bg-blue-500"><UserRoundPlus /></Button>
                <Button class="bg-green-600"><Sheet /></Button>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <DinnersTable :dinners="dinners" />
                <SalesCard />
            </div>
        </div>
    </AppLayout>
</template>

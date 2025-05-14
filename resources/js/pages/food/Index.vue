<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Dish } from '@/types';
import { Head } from '@inertiajs/vue3';
import DishesTable from './DishesTable.vue';
import MenuTable from './MenuTable.vue';

interface Props {
    dishes: Dish[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <DishesTable :dishes="dishes.data" />
                    <div class="flex w-full items-center justify-center">
                        <Button @click="$inertia.get(dishes.prev_page_url)">Anterior</Button>
                        <Button class="ms-1" @click="$inertia.get(dishes.next_page_url)">Siguiente</Button>
                    </div>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <MenuTable />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border"></div>
            </div>
        </div>
    </AppLayout>
</template>

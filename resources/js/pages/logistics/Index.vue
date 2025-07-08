<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Headquarter } from '@/types';

const props = defineProps<{
    headquarters: Headquarter[];
}>();
</script>
<template>
    <Head title="Logística" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <h3 class="text-center text-2xl">Centro logístico</h3>
            <div class="flex flex-row justify-around p-3">
                <div
                    class="min-w-[300px] cursor-pointer rounded bg-red-400 p-4 text-white"
                    v-for="headquarter in props.headquarters"
                    :key="headquarter.id"
                >
                    {{ headquarter.name }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>

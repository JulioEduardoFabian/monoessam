<script setup lang="ts">
import { ref } from 'vue';
import DatePicker from './DatePicker.vue';

const dishesPicked = ref([]);
</script>

<template>
    <div
        class="border-sidebar-border/70 dark:border-sidebar-border relative col-span-2 aspect-video overflow-hidden overflow-y-auto rounded-xl border"
    >
        <h1>Programación</h1>
        <DatePicker :dishes="dishesPicked" />
    </div>
</template>

<script lang="ts" setup>
import Draggable from './Draggable.vue';

interface Props {
    users: Array<any>;
}

const props = defineProps<Props>();
</script>
<template>
    <div>
        <p>PERSONAL</p>

        <Draggable v-for="user in users" :user="user" :key="user.id" />
    </div>
</template>

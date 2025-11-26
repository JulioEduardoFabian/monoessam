<script setup lang="ts">
import { Role } from '@/types';
import { useDroppable } from '@vue-dnd-kit/core';
import axios from 'axios';
import { ref } from 'vue';
import Draggable from './Draggable.vue';

interface Props {
    role: Role;
}

interface User {
    id: number;
    name: string;
    type: number;
    avatar?: string;
}

const emit = defineEmits<{
    (e: 'roleAssigned', userId: number): void;
    (e: 'unassignUser', userId: number): void;
}>();

const props = defineProps<Props>();

const userDropped = ref<User | null>(null);

if (props.role?.user) {
    userDropped.value = props.role.user as User;
}

const unassignUser = (userId: number) => {
    userDropped.value = null;
    emit('unassignUser', userId);
};

const { elementRef: guardRolesDropzoneRef, isOvered } = useDroppable({
    id: 'guard-roles-dropzone',
    events: {
        onDrop: (store, payload) => {
            const droppedUser = payload.items[0].data?.user;
            console.log(props.role);
            if (droppedUser) {
                console.log(`Usuario ${droppedUser.name} asignado a rol ${props.role.role.name}!`);
                userDropped.value = droppedUser;

                axios
                    .post('/guard-roles-user', {
                        user_id: droppedUser.id,
                        guard_role_id: props.role.id,
                    })
                    .then((response) => {
                        console.log('Rol asignado con éxito:', response.data);
                        emit('roleAssigned', droppedUser.id);
                    })
                    .catch((error) => {
                        console.error('Error al asignar el rol:', error);
                    });
            }
        },
    },
});
</script>

<template>
    <div ref="guardRolesDropzoneRef" class="min-h-[6rem] w-full">
        <div
            v-if="!userDropped || !userDropped.id"
            :class="{
                'rounded border-2 border-dashed border-zinc-600 p-5 transition-colors': true,
                'bg-zinc-100 dark:bg-zinc-800': isOvered, // Puedes usar isOvered aquí para feedback visual
            }"
        >
            Arrastre aquí el colaborador a asignar
        </div>

        <div v-else>
            <Draggable :user="userDropped" @unassignUser="unassignUser" />
        </div>
    </div>
</template>

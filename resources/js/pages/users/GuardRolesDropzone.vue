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
}>();

const props = defineProps<Props>();

// 👈 Inicialización correcta con ref
const userDropped = ref<User | null>(null);

const { elementRef: guardRolesDropzoneRef, isOvered } = useDroppable({
    id: 'guard-roles-dropzone',
    events: {
        onDrop: (store, payload) => {
            const droppedUser = payload.items[0].data?.user;
            if (droppedUser) {
                console.log(`Usuario ${droppedUser.name} asignado a rol ${props.role.name}!`);
                userDropped.value = droppedUser;

                axios
                    .post('/guard-roles-user', {
                        user_id: droppedUser.id,
                        role_id: props.role.pivot.id,
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
    <div v-if="!userDropped || !userDropped.id" class="w-full rounded border-2 border-dashed border-zinc-600 p-5" ref="guardRolesDropzoneRef">
        Arrastre aquí el colaborador a asignar
    </div>
    <div v-else>
        <Draggable :user="userDropped" />
    </div>
</template>

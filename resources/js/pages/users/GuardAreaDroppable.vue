<script lang="ts" setup>
import { Role } from '@/types';
import { useDroppable } from '@vue-dnd-kit/core';
import { ref } from 'vue';
import Draggable from './Draggable.vue';
import GuardRolesModal from './GuardRolesModal.vue';

// --- Interfaces y Tipos ---
interface Props {
    users: Array<any>;
    roles: Array<Role>;
    // Usamos 'any' para 'guard' pero definimos la estructura esperada
    guard: {
        id: number;
        name: string;
        // La estructura de roles obtenida del backend
        roles: Array<Role & { pivot?: { guard_id: number; role_id: number } }>;
        [key: string]: any; // Permite otras propiedades
    };
}

interface User {
    id: number;
    name: string;
    type: number;
    avatar?: string;
}

const emit = defineEmits<{
    (e: 'dropped', user: User): void;
}>();

const props = defineProps<Props>();

const message = ref('Arrastra el usuario aquí para asignarlo.');
const isDropped = ref(false);

const { elementRef: dropzoneRef, isOvered } = useDroppable({
    id: 'my-dropzone' + props.guard.id,
    events: {
        onDrop: (store, payload) => {
            isDropped.value = true;
            const droppedUser = payload.items[0].data.user;

            if (droppedUser) {
                message.value = `Usuario ${droppedUser.name} asignado!`;
                // NOTA: Aquí deberías añadir el usuario a un estado interno de la guardia.
            }

            emit('dropped', droppedUser as User);
        },
    },
});

const openRolesModal = () => {
    console.log('Open roles modal');
};
</script>

<template>
    <div class="container">
        <div class="content">
            <div
                ref="dropzoneRef"
                :class="{ 'border-blue-500 bg-blue-100': isOvered, 'border-green-500': isDropped }"
                class="dropzone h-[75vh] w-full rounded-lg border-4 border-dashed bg-zinc-300 p-5 shadow-inner transition-colors"
            >
                <h3 class="mb-4 text-center text-xl font-bold text-zinc-800">{{ guard.name }}</h3>

                <GuardRolesModal :roles="roles" :guard="guard" />

                <div v-if="guard.roles && guard.roles.length > 0" class="mt-4 space-y-3">
                    <h4 class="text-sm font-semibold text-zinc-600">Roles Asignados:</h4>

                    <div
                        v-for="role in guard.roles"
                        :key="role.id"
                        class="flex items-center justify-between rounded-lg border-l-4 border-green-500 bg-white p-3 shadow-md transition-shadow hover:shadow-lg"
                    >
                        <span class="font-medium text-zinc-700">{{ role.name }}</span>

                        <span v-if="role.pivot" class="text-xs text-zinc-400"> ID: {{ role.pivot.role_id }} </span>
                    </div>
                </div>
                <p class="mt-4 text-center text-sm font-medium text-zinc-500">{{ message }}</p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <Draggable v-for="user in users" :user="user" :key="user.id" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Manteniendo los estilos originales para Draggable y Dropzone */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 5px;
}

.content {
    display: flex;
    gap: 30px;
    margin-top: 20px;
    width: 100%;
}

.over {
    background-color: #e0f7fa; /* Light cyan */
    border-color: #00bcd4; /* Cyan */
}

.dropped {
    /* Mantenemos el estilo simple de borde para dropped */
    border-color: #4caf50;
}
</style>

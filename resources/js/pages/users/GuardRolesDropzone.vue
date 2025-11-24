<script setup lang="ts">
import { Role } from '@/types'; // Asegúrate de que esta importación sea correcta
import { useDroppable } from '@vue-dnd-kit/core';
import { ref } from 'vue';

// --- Interfaces y Tipos ---
interface Guardia {
    id: number;
    name: string;
    // La estructura de roles obtenida del backend
    roles: Array<Role & { pivot?: { guard_id: number; role_id: number } }>;
}

interface User {
    id: number;
    name: string;
    // Añade otras propiedades que tu draggable pueda tener
    [key: string]: any;
}

interface DroppableProps {
    // La guardia cuyos roles queremos mostrar y a la que asignaremos nuevos roles
    guard: Guardia;
}

const props = defineProps<DroppableProps>();

// 1. Definición del evento 'dropped' que emitirá el usuario que fue arrastrado
const emit = defineEmits<{
    (e: 'roleDropped', payload: { user: User; guardId: number }): void;
}>();

const message = ref('Arrastra un usuario aquí para asignarlo.');
const isDropped = ref(false);

const { elementRef: dropzoneRef, isOvered } = useDroppable({
    // Usamos la ID de la guardia para que cada zona sea única
    id: `guard-dropzone-${props.guard.id}`,
    events: {
        onDrop: (store, payload) => {
            isDropped.value = true;
            // Acceder al usuario arrastrado desde el payload
            const droppedUser = payload.items[0].data.user;

            if (droppedUser) {
                message.value = `Usuario ${droppedUser.name} listo para asignar rol.`;

                // 2. Emitir el evento con el usuario arrastrado y la ID de la guardia
                emit('roleDropped', { user: droppedUser as User, guardId: props.guard.id });
            }
        },
    },
});
</script>

<template>
    <div
        ref="dropzoneRef"
        :class="{ 'border-blue-500 bg-blue-100': isOvered, 'border-green-500': isDropped }"
        class="dropzone h-full w-full rounded-lg border-4 border-dashed bg-zinc-300 p-5 shadow-inner transition-colors"
    >
        <h3 class="mb-4 text-center text-xl font-bold text-zinc-800">{{ guard.name }}</h3>

        <GuardRolesDropzone />

        <p class="mt-4 text-center text-sm font-medium text-zinc-500">{{ message }}</p>

        <slot />
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import InputSearchRole from '@/pages/users/InputSearchRole.vue';
import InputSearchSelectable from '@/pages/users/InputSearchSelectable.vue';
import { Role, Unit } from '@/types';
import { X } from 'lucide-vue-next';
import InputSelectableUnit from '../InputSelectableUnit.vue';

interface Props {
    imagePreview: string | null;
    cafeId: number | null;
    cafes: any[];
    units: Unit[];
    unitId: number;
    roleId: number;
    roles: Role[];
}

interface Emits {
    (e: 'trigger-upload'): void;
    (e: 'remove-image'): void;
    (e: 'select-cafe', cafe: any): void;
    (e: 'select-unit', unit: Unit): void;
    (e: 'select-role', role: Role): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();
</script>

<template>
    <div class="flex flex-col items-center space-y-3 rounded-lg border bg-white p-4 shadow-sm">
        <div class="relative">
            <img
                :src="imagePreview || 'https://placehold.co/150x200/52525B/FFFFFF?text=FOTO'"
                alt="Foto Colaborador"
                class="h-40 w-32 rounded-md border object-cover shadow-sm"
            />
            <button
                v-if="imagePreview"
                @click="emit('remove-image')"
                type="button"
                class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white shadow-sm hover:bg-red-600"
            >
                <X :size="14" />
            </button>
        </div>

        <Button variant="outline" size="sm" class="w-full" @click="emit('trigger-upload')" type="button">
            {{ imagePreview ? 'Cambiar Foto' : 'Subir Foto' }}
        </Button>

        <InputSelectableUnit :units="units" @selectUnit="emit('select-unit', $event)" :unitSelected="unitId" />

        <InputSearchSelectable :cafes="cafes" @selectCafe="emit('select-cafe', $event)" :cafeSelected="cafeId" />

        <InputSearchRole @selectRole="emit('select-role', $event)" :roles="roles" :roleSelected="roleId" />
    </div>
</template>

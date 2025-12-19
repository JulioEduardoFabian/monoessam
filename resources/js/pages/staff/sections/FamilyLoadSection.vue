<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface Props {
    form: any;
}

interface Emits {
    (e: 'upload-file', event: Event, label: string, files: any[]): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();
</script>

<template>
    <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
        <h3 class="border-b pb-2 text-lg font-semibold text-zinc-800">Carga Familiar</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="space-y-1">
                <Label>Número de Hijos</Label>
                <Input v-model="form.children" />
            </div>
            <div class="space-y-1">
                <Label>DNIs en PDF</Label>
                <Input
                    type="file"
                    class="w-[350px] text-xs file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200"
                    accept="application/pdf, image/jpeg"
                    @change="emit('upload-file', $event, 'DNIs hijos', form.files)"
                />
            </div>
        </div>
    </div>
</template>

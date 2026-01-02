<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface Props {
    form: any;
}

defineProps<Props>();
</script>

<template>
    <div class="space-y-4 rounded-lg border border-red-100 bg-red-50/50 p-4">
        <h3 class="border-b border-red-200 pb-2 text-sm font-semibold tracking-wider text-red-700 uppercase">Contacto Emergencia</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="space-y-1">
                <Label>Nombre</Label>
                <Input v-model="form.contactname" class="bg-white" />
            </div>
            <div class="space-y-1">
                <Label>Celular</Label>
                <Input v-model="form.contactcell" class="bg-white" />
            </div>
        </div>
    </div>
</template>

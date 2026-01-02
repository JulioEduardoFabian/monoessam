<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface Props {
    form: any;
}

defineProps<Props>();
</script>

<template>
    <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
        <h3 class="border-b pb-2 text-lg font-semibold text-zinc-800">Datos financieros</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="space-y-1">
                <Label>Entidad Bancaria</Label>
                <Select v-model="form.tipoContrato">
                    <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="1">BBVA</SelectItem>
                        <SelectItem value="2">BCP</SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="space-y-1">
                <Label>Número de Cuenta</Label>
                <Input v-model="form.cc" />
            </div>
            <div class="space-y-1">
                <Label>Número de Cuenta CI</Label>
                <Input v-model="form.cci" />
            </div>
            <div class="space-y-1">
                <Label>Aportación</Label>
                <Select v-model="form.regimenLaboral">
                    <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="G">General</SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="space-y-1">
                <Label>Fecha de ingreso</Label>
                <Input type="date" v-model="form.fechaIngreso" />
            </div>
            <div class="space-y-1">
                <Label>Fecha de Fin de Contrato</Label>
                <Input type="date" v-model="form.fechaFinContract" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import FamilyLoadSection from '../sections/FamilyLoadSection.vue';
import FinancialInfoSection from '../sections/FinancialInfoSection.vue';

interface Props {
    form: any;
    roles: any[];
}

interface Emits {
    (e: 'select-role', role: any): void;
    (e: 'upload-file', event: Event, label: string, files: any[]): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();
</script>

<template>
    <div class="space-y-6">
        <!-- Datos del colaborador -->
        <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm">
            <h3 class="border-b pb-2 text-lg font-semibold text-zinc-800">Datos del colaborador</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="space-y-1">
                    <Label>Distrito</Label>
                    <Input v-model="form.district" />
                </div>
                <div class="space-y-1">
                    <Label>Provincia</Label>
                    <Input v-model="form.province" />
                </div>
                <div class="space-y-1">
                    <Label>Departamento</Label>
                    <Input v-model="form.department" />
                </div>
                <div class="space-y-1">
                    <Label>Fondo de pensiones</Label>
                    <Select v-model="form.fondo">
                        <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="1">AFP</SelectItem>
                            <SelectItem value="2">ONP</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <div class="space-y-1" v-if="form.fondo == 1">
                    <Label>Nombre de AFP</Label>
                    <Input v-model="form.afp" />
                </div>
                <!-- <div class="space-y-1">
                    <Label>Rol</Label>
                    <InputSearchRole @selectRole="emit('select-role', $event)" :roles="roles" :roleSelected="form.roleId" />
                </div> -->
                <div class="space-y-1">
                    <Label>Dirección</Label>
                    <Input v-model="form.address" />
                </div>
                <div class="space-y-1">
                    <Label>Sistema de Trabajo</Label>
                    <Input v-model="form.workSystem" />
                </div>
                <div class="space-y-1">
                    <Label>Reemplazo</Label>
                    <Input v-model="form.replacement" />
                </div>
                <!--  <div class="space-y-1">
                    <Label>Unidad</Label>
                    <Input v-model="form.unitSelectedText" readonly />
                </div> -->
                <div class="space-y-1">
                    <Label>Sueldo</Label>
                    <Input v-model="form.salary" />
                </div>
                <div class="space-y-1">
                    <Label>Observaciones</Label>
                    <Input v-model="form.observations" />
                </div>
            </div>
        </div>

        <!-- Datos financieros -->
        <FinancialInfoSection :form="form" />

        <!-- Carga familiar -->
        <FamilyLoadSection :form="form" @upload-file="emit('upload-file', $event, $event[1], $event[2])" />
    </div>
</template>

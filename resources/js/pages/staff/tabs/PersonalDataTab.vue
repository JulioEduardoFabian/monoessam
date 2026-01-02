<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import EmergencyContactSection from '../sections/EmergencyContactSection.vue';
import PhotoUploadSection from '../sections/PhotoUploadSection.vue';

interface Props {
    form: any;
    cafes: any[];
    imagePreview: string | null;
}

interface Emits {
    (e: 'trigger-upload'): void;
    (e: 'remove-image'): void;
    (e: 'select-cafe', cafe: any): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();
</script>

<template>
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <PhotoUploadSection
                class="md:col-span-1"
                :image-preview="imagePreview"
                :cafe-id="form.cafeId"
                :cafes="cafes"
                @trigger-upload="emit('trigger-upload')"
                @remove-image="emit('remove-image')"
                @select-cafe="emit('select-cafe', $event)"
            />

            <div class="space-y-4 md:col-span-3">
                <h3 class="border-b pb-2 text-lg font-semibold text-zinc-700">Datos Generales</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                    <div class="space-y-1">
                        <Label for="nombres">Nombre Completo *</Label>
                        <Input id="nombres" v-model="form.name" />
                    </div>
                    <div class="space-y-1">
                        <Label for="doc">DNI / C.E. *</Label>
                        <Input id="doc" v-model="form.dni" />
                    </div>
                    <div class="space-y-1">
                        <Label for="cel">Celular *</Label>
                        <Input id="cel" v-model="form.cell" />
                    </div>
                    <div class="space-y-1">
                        <Label>F. Nacimiento</Label>
                        <Input type="date" v-model="form.birthdate" />
                    </div>
                    <div class="space-y-1">
                        <Label for="age">Edad</Label>
                        <Input id="age" v-model="form.age" />
                    </div>
                    <div class="space-y-1">
                        <Label>Sexo</Label>
                        <Select v-model="form.sex">
                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1">Masculino</SelectItem>
                                <SelectItem value="2">Femenino</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="space-y-1">
                        <Label>Email</Label>
                        <Input v-model="form.email" />
                    </div>
                    <div class="space-y-1">
                        <Label>Nacionalidad</Label>
                        <Input v-model="form.country" />
                    </div>
                    <div class="space-y-1">
                        <Label>Estado Civil</Label>
                        <Select v-model="form.civilstatus">
                            <SelectTrigger><SelectValue placeholder="Seleccionar" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1">Soltero</SelectItem>
                                <SelectItem value="2">Casado</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
            </div>
        </div>

        <EmergencyContactSection :form="form" />
    </div>
</template>

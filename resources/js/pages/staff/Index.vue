<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import AppLayout from '@/layouts/AppLayout.vue';
import { Cafe, Role, Staff } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { Trash2 } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import ChangeStatusModal from './ChangeStatusModal.vue';
import StaffRegistrationDialog from './StaffRegistrationDialog.vue';

interface Props {
    cafes: Cafe[];
    staff: Staff[];
    roles: Role[];
}

const props = defineProps<Props>();

// Usar ref para reactividad
const staffComplete = ref(props.staff);

const deleteStaff = async (staffId: number) => {
    if (!confirm('Estás seguro de eliminar a este personal?')) return;

    try {
        await axios.delete('/staff/' + staffId);
        // Actualizar la referencia reactiva
        staffComplete.value = staffComplete.value.filter((s) => s.id !== staffId);
    } catch (err) {
        console.error('Error al eliminar personal:', err);
    }
};

const STATUSES = ['Lista negra', 'En proceso', 'Contratado', 'Cesado', 'Retirado', 'Abandono', 'Cumplió Contrato'] as const;

const STATUS_COLORS = [
    'bg-zinc-500 text-white',
    'bg-green-500 text-white',
    'bg-green-500 text-white',
    'bg-red-500 text-white',
    'bg-red-500 text-white',
    'bg-red-500 text-white',
    'bg-blue-500 text-white',
] as const;

const showStatus = (statusId: number) => STATUSES[statusId] ?? 'Desconocido';

const showColor = (statusId: number) => STATUS_COLORS[statusId] ?? '';

const changeStatus = () => {};

const statusesStaff = {
    0: 'Lista negra',
    1: 'En proceso',
    2: 'Contratado',
    3: 'Cesado',
    4: 'Retirado',
    5: 'Abandono',
    6: 'Cumplió Contrato',
};

watch(props, () => {
    staffComplete.value = props.staff;
});
</script>

<template>
    <Head title="Personal" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold tracking-tight">Personal</h1>
                <StaffRegistrationDialog :cafes="props.cafes" :roles="props.roles" />
            </div>

            <!-- <div class="flex items-center">
                <Input type="text" placeholder="Buscar personal por dni o nombre"></Input>
                <select
                    id="status"
                    class="ms-2 rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                >
                    <option v-for="(label, value) in statusesStaff" :key="value" :value="value">
                        {{ label }}
                    </option>
                </select>
                <Button variant="default" class="ms-2 cursor-pointer bg-blue-600 text-white hover:bg-blue-700">Buscar</Button>
            </div> -->

            <div class="bg-card rounded-xl border shadow-sm">
                <table class="w-full border-collapse">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="p-4 text-left text-sm font-semibold">Nombre</th>
                            <th class="p-4 text-left text-sm font-semibold">DNI</th>
                            <th class="p-4 text-left text-sm font-semibold">Celular</th>
                            <th class="p-4 text-left text-sm font-semibold">Comedor</th>
                            <th class="p-4 text-left text-sm font-semibold">Documentación</th>
                            <th class="p-4 text-left text-sm font-semibold">Estado</th>
                            <th class="p-4 text-center text-sm font-semibold">Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="staff in staffComplete" :key="staff.id" class="hover:bg-muted/30 border-t transition">
                            <td class="p-4">{{ staff.name }}</td>
                            <td class="p-4">{{ staff.dni }}</td>
                            <td class="p-4">{{ staff.cell }}</td>
                            <td class="p-4">
                                <p>{{ staff.cafe?.name ?? 'Sin asignar' }} - {{ staff.cafe?.unit?.name }}</p>
                            </td>
                            <td class="p-4">
                                <TooltipProvider v-for="file in staff.staff_files" :key="file.id">
                                    <Tooltip>
                                        <TooltipTrigger as-child>
                                            <a class="text-md rounded-sm text-white" :href="'/storage/' + file.file_path" target="_blank"> 📄 </a>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>{{ file.file_type }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </td>

                            <td class="p-4">
                                <Badge :class="showColor(staff.status)" class="cursor-pointer rounded-sm" @click="changeStatus()">
                                    {{ showStatus(staff.status) }}
                                </Badge>
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <ChangeStatusModal :staff="staff" />

                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        class="cursor-pointer text-red-600 hover:text-red-800"
                                        @click="deleteStaff(staff.id)"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

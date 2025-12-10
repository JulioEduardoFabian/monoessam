<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Cafe, Role } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { Edit3, Eye, Trash2 } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import FormUser from '../users/FormUser.vue';

interface Props {
    cafes: Cafe[];
    staff: any[];
    roles: Role[];
}

const props = defineProps<Props>();

// Usar ref para reactividad
const staffComplete = ref(props.staff);

const deleteStaff = async (staffId: string) => {
    if (!confirm('Estás seguro de eliminar a este personal?')) return;

    try {
        await axios.delete('/staff/' + staffId);
        // Actualizar la referencia reactiva
        staffComplete.value = staffComplete.value.filter((s) => s.id !== staffId);
    } catch (err) {
        console.error('Error al eliminar personal:', err);
    }
};

watch(props, (newVal) => {
    staffComplete.value = props.staff;
});
</script>

<template>
    <Head title="Personal" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold tracking-tight">Personal</h1>
                <FormUser :cafes="props.cafes" :roles="props.roles" />
            </div>

            <div class="bg-card rounded-xl border shadow-sm">
                <table class="w-full border-collapse">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="p-4 text-left text-sm font-semibold">Nombre</th>
                            <th class="p-4 text-left text-sm font-semibold">DNI</th>
                            <th class="p-4 text-left text-sm font-semibold">Celular</th>
                            <th class="p-4 text-left text-sm font-semibold">Documentación</th>
                            <th class="p-4 text-left text-sm font-semibold">Estado</th>
                            <th class="p-4 text-center text-sm font-semibold">Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="p in staffComplete" :key="p.id" class="hover:bg-muted/30 border-t transition">
                            <td class="p-4">{{ p.name }}</td>
                            <td class="p-4">{{ p.dni }}</td>
                            <td class="p-4">{{ p.cell }}</td>
                            <td class="p-4">
                                <a
                                    class="mx-2 rounded bg-red-400 px-2 text-white"
                                    :href="'/storage/' + file.file_path"
                                    target="_blank"
                                    v-for="file in p.staff_files"
                                    :key="file.id"
                                    >{{ file.file_type }}</a
                                >
                            </td>

                            <td class="p-4">
                                <Badge :class="p.status === 'Activo' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">
                                    {{ p.status }}
                                </Badge>
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <Button variant="ghost" size="icon" class="text-blue-600 hover:text-blue-800">
                                        <Eye class="h-4 w-4" />
                                    </Button>

                                    <Button variant="ghost" size="icon" class="text-yellow-600 hover:text-yellow-800">
                                        <Edit3 class="h-4 w-4" />
                                    </Button>

                                    <Button variant="ghost" size="icon" class="text-red-600 hover:text-red-800" @click="deleteStaff(p.id)">
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

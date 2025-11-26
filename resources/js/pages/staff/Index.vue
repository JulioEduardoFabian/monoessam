<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Edit3, Eye, Trash2 } from 'lucide-vue-next';
import FormUser from '../users/FormUser.vue';

interface Personal {
    id: number;
    nombre: string;
    dni: string;
    celular: string;
    direccion: string;
    estado: 'Activo' | 'Inactivo';
}

const personal: Personal[] = [
    {
        id: 1,
        nombre: 'Carlos Mendoza',
        dni: '74382956',
        celular: '987654321',
        direccion: 'Av. Los Próceres 204, Huancayo',
        estado: 'Activo',
    },
    {
        id: 2,
        nombre: 'Andrea Torres',
        dni: '72839485',
        celular: '945672134',
        direccion: 'Jr. Huánuco 530, El Tambo',
        estado: 'Inactivo',
    },
    {
        id: 3,
        nombre: 'Luis Rojas',
        dni: '75649213',
        celular: '912345678',
        direccion: 'Calle Real 800, Huancayo',
        estado: 'Activo',
    },
];
</script>

<template>
    <Head title="Personal" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold tracking-tight">Personal</h1>

                <Button class="bg-blue-500 text-white hover:bg-blue-600"> + Agregar Personal </Button>
            </div>

            <div class="bg-card rounded-xl border shadow-sm">
                <table class="w-full border-collapse">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="p-4 text-left text-sm font-semibold">Nombre</th>
                            <th class="p-4 text-left text-sm font-semibold">DNI</th>
                            <th class="p-4 text-left text-sm font-semibold">Celular</th>
                            <th class="p-4 text-left text-sm font-semibold">Dirección</th>
                            <th class="p-4 text-left text-sm font-semibold">Estado</th>
                            <th class="p-4 text-center text-sm font-semibold">Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="p in personal" :key="p.id" class="hover:bg-muted/30 border-t transition">
                            <td class="p-4">{{ p.nombre }}</td>
                            <td class="p-4">{{ p.dni }}</td>
                            <td class="p-4">{{ p.celular }}</td>
                            <td class="p-4">{{ p.direccion }}</td>

                            <td class="p-4">
                                <Badge :class="p.estado === 'Activo' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">
                                    {{ p.estado }}
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

                                    <Button variant="ghost" size="icon" class="text-red-600 hover:text-red-800">
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <FormUser></FormUser>
    </AppLayout>
</template>

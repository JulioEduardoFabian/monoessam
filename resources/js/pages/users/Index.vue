<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Area, Cafe, Headquarter, Permission, Role, User } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { Trash } from 'lucide-vue-next';
import AreaModal from './AreaModal.vue';
import AreaTable from './AreaTable.vue';
import Modal from './Modal.vue';
import PermissionModal from './PermissionModal.vue';
import RoleModal from './RoleModal.vue';
import RoleTable from './RoleTable.vue';
import SelectRole from './SelectRole.vue';

interface Props {
    users: User[];
    roles: Role[];
    permissions: Permission[];
    areas: Area[];
    cafes: Cafe[];
    headquarters: Headquarter[];
}

defineProps<Props>();

const locationLabel = (user: User): string => {
    const area = user.roles?.[0]?.areas?.[0];
    if (!area) return '';

    if (area.headquarter) {
        return `Sede - ${area.headquarter.name}`;
    } else if (area.cafe) {
        return `Cafetería - ${area.cafe.name}`;
    }

    return '';
};

const deletePermission = (permissionId: any) => {
    if (confirm('Estas seguro de eliminar el permiso?')) {
        router.delete(route('permissions.destroy', permissionId));
    }
};
</script>
<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex h-[40px] w-full items-center justify-start gap-1">
                <PermissionModal />
                <Modal :cafes="cafes" :headquarters="headquarters" :roles="roles" />
                <RoleModal :areas="areas" />
                <AreaModal :cafes="cafes" :headquarters="headquarters" />
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <AreaTable :areas="areas" :roles="roles" />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <Card>
                        <Table>
                            <TableCaption>Lista de Usuarios del Sistema.</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead class="w-[100px]">Nombre</TableHead>
                                    <TableHead>Correo</TableHead>
                                    <TableHead>Rol</TableHead>
                                    <TableHead class="text-right">Area</TableHead>
                                    <TableHead class="text-right">Sede o Cafetería</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="user in users" :key="user.id">
                                    <TableCell class="font-medium">{{ user.name }}</TableCell>
                                    <TableCell>{{ user.email }}</TableCell>
                                    <TableCell>
                                        <SelectRole :user="user" :roles="roles" />
                                    </TableCell>
                                    <TableCell class="text-right"> {{ user.roles[0].areas[0].name }} </TableCell>
                                    <TableCell class="text-right">
                                        {{ locationLabel(user) }}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Card>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <RoleTable :roles="roles" :permissions="permissions" />
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                    <Card>
                        <Table>
                            <TableCaption>Lista de Permisos del Sistema.</TableCaption>
                            <TableHeader>
                                <TableRow>
                                    <TableHead class="w-[100px]">Permiso</TableHead>
                                    <TableHead>Rol</TableHead>
                                    <TableHead>Opciones</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="permission in permissions" :key="permission.id">
                                    <TableCell class="font-medium">{{ permission.name }}</TableCell>
                                    <TableCell>{{ permission.guard_name }}</TableCell>
                                    <TableCell
                                        ><Button @click="deletePermission(permission.id)"><Trash /></Button
                                    ></TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

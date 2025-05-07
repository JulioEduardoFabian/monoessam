<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Permission, Role, User } from '@/types';
import Modal from './Modal.vue';
import PermissionModal from './PermissionModal.vue';
import RoleModal from './RoleModal.vue';
import RoleTable from './RoleTable.vue';
import SelectRole from './SelectRole.vue';

interface Props {
    users: User[];
    roles: Role[];
    permissions: Permission[];
}

defineProps<Props>();
</script>
<template>
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
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
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="user in users" :key="user.id">
                                    <TableCell class="font-medium">{{ user.name }}</TableCell>
                                    <TableCell>{{ user.email }}</TableCell>
                                    <TableCell>
                                        <SelectRole :user="user" :roles="roles" />
                                    </TableCell>
                                    <TableCell class="text-right"> Sistemas </TableCell>
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
                                    <TableCell><Button>Eliminar</Button></TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Card>
                </div>
            </div>
        </div>
        <PermissionModal />
        <Modal />
        <RoleModal />
    </AppLayout>
</template>

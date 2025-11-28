<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Permission, Role, User } from '@/types';
import RoleModal from '../users/RoleModal.vue';
import UserPermissionModal from './UserPermissionModal.vue';

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
            <div
                class="flex h-12 w-full items-center justify-start gap-3 rounded-lg bg-gradient-to-r from-blue-50 to-purple-50 p-2 shadow-sm dark:from-gray-700 dark:to-gray-700"
            >
                <RoleModal :areas="areas" />
            </div>
            <div class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                <Card>
                    <Table>
                        <TableCaption>Lista de Usuarios del Sistema.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[100px]">Usuario</TableHead> <TableHead>Rol</TableHead>
                                <TableHead class="text-right">Opciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="user in users" :key="user.id">
                                <TableCell class="font-medium">{{ user.name }}</TableCell>
                                <TableCell>{{ user.roles[0]?.name }}</TableCell>
                                <TableCell class="text-right">
                                    <UserPermissionModal :permissions="permissions" :user="user" />
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </Card>
            </div>
            <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <Card
                    v-for="permission in permissions"
                    :key="permission.id"
                    class="border-sidebar-border/50 dark:border-sidebar-border/70 rounded-2xl border shadow-sm transition hover:shadow-md"
                >
                    <div class="flex flex-col gap-3 p-4">
                        <h3 class="text-foreground text-lg font-semibold">
                            {{ permission.name }}
                        </h3>

                        <div class="text-muted-foreground flex items-center justify-between text-sm">
                            <span class="font-medium">Estado:</span>
                            <span class="text-green-600 dark:text-green-400">Activo</span>
                        </div>

                        <div class="text-muted-foreground flex items-center justify-between text-sm">
                            <span class="font-medium">Área:</span>
                            <span>{{ permission.roles ?? '—' }}</span>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

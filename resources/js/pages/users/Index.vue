<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { Area, Cafe, Headquarter, Permission, Role, User } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { Ban } from 'lucide-vue-next';
import { ref } from 'vue';
import AreaModal from './AreaModal.vue';
import Modal from './Modal.vue';
import PermissionModal from './PermissionModal.vue';
import RoleModal from './RoleModal.vue';
import RolePermissionPopover from './RolePermissionPopover.vue';

interface Props {
    users: User[];
    roles: Role[];
    permissions: Permission[];
    areas: Area[];
    cafes: Cafe[];
    headquarters: Headquarter[];
}

defineProps<Props>();

const areasSelected = ref([]);
const usersSelected = ref([]);
const showNoUsers = ref(false);

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

const selectedSide = ref<Cafe | Headquarter | null>(null);
const selectedArea = ref<Area | null>(null);
const selectedUser = ref<User | null>(null);

const selectSide = (side: Cafe | Headquarter) => {
    selectedSide.value = side;
    selectedArea.value = null;
    selectedUser.value = null;
    areasSelected.value = side.areas;
    usersSelected.value = [];
    showNoUsers.value = false;
};

const selectArea = (area: Area) => {
    selectedArea.value = area;
    selectedUser.value = null;
    if (area.users.length !== 0) {
        usersSelected.value = area.users;
        showNoUsers.value = false;
    } else {
        usersSelected.value = [];
        showNoUsers.value = true;
    }
};

const selectUser = (user: User) => {
    selectedUser.value = user;
};

const toBlacklist = (userId: number) => {
    if (confirm('¿Estás seguro de que deseas enviar a lista negra a este usuario?')) {
        router.get(route('blacklist', userId));
    }
};

const blockUser = (userId: number) => {
    if (confirm('¿Estás seguro de que deseas dar de baja a este usuario?')) {
        axios
            .get('./users-ban/' + userId)
            .then(() => {
                console.log('sending message');
            })
            .catch((error) => {
                console.error('Error al dar de baja al usuario:', error);
                alert('Ocurrió un error al dar de baja al usuario. Por favor, inténtalo de nuevo.');
            });
    }
};
</script>
<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Barra de acciones - Mejorada con colores -->
            <div
                class="flex h-12 w-full items-center justify-start gap-3 rounded-lg bg-gradient-to-r from-blue-50 to-purple-50 p-2 shadow-sm dark:from-gray-700 dark:to-gray-700"
            >
                <PermissionModal
                    class="rounded p-1 text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-700 dark:text-blue-400 dark:hover:bg-blue-900/30"
                />
                <Modal
                    :cafes="cafes"
                    :headquarters="headquarters"
                    :roles="roles"
                    class="rounded p-1 text-purple-600 transition-colors hover:bg-purple-100 hover:text-purple-700 dark:text-purple-400 dark:hover:bg-purple-900/30"
                />
                <RoleModal
                    :areas="areas"
                    class="rounded p-1 text-green-600 transition-colors hover:bg-green-100 hover:text-green-700 dark:text-green-400 dark:hover:bg-green-900/30"
                />
                <AreaModal
                    :cafes="cafes"
                    :headquarters="headquarters"
                    class="rounded p-1 text-orange-600 transition-colors hover:bg-orange-100 hover:text-orange-700 dark:text-orange-400 dark:hover:bg-orange-900/30"
                />
            </div>

            <!-- Contenedor principal de tres columnas -->
            <div class="grid h-full auto-rows-fr gap-6 md:grid-cols-3">
                <!-- Columna Lugares - Mejorada -->
                <div class="flex flex-col gap-4 rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Lugares</span>
                    </h2>
                    <Input
                        type="text"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        placeholder="Buscar lugar..."
                    />
                    <div class="space-y-2 overflow-y-auto">
                        <Tabs default-value="account" class="w-full">
                            <TabsList class="grid w-full grid-cols-2 bg-gray-100 dark:bg-gray-700">
                                <TabsTrigger value="areas" class="data-[state=active]:bg-blue-500 data-[state=active]:text-white">
                                    Sedes
                                </TabsTrigger>
                                <TabsTrigger value="cafes" class="data-[state=active]:bg-purple-500 data-[state=active]:text-white">
                                    Cafeterías
                                </TabsTrigger>
                            </TabsList>
                            <TabsContent value="areas">
                                <div
                                    v-for="headquarter in headquarters"
                                    :key="headquarter.id"
                                    class="my-1 flex h-14 cursor-pointer items-center rounded-lg border border-gray-200 p-3 transition-all hover:bg-blue-50 hover:shadow-md dark:border-gray-600 dark:hover:bg-blue-900/20"
                                    :class="{
                                        'border-blue-300 bg-blue-100 dark:bg-blue-900/40': selectedSide?.id === headquarter.id,
                                    }"
                                    @click="selectSide(headquarter)"
                                >
                                    <p class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ headquarter.business.name }} - {{ headquarter.name }}
                                    </p>
                                </div>
                            </TabsContent>
                            <TabsContent value="cafes">
                                <div
                                    v-for="cafe in cafes"
                                    :key="cafe.id"
                                    class="my-1 flex h-14 cursor-pointer items-center rounded-lg border border-gray-200 p-3 transition-all hover:bg-purple-50 hover:shadow-md dark:border-gray-600 dark:hover:bg-purple-900/20"
                                    :class="{
                                        'border-purple-300 bg-purple-100 dark:bg-purple-900/40': selectedSide?.id === cafe.id,
                                    }"
                                    @click="selectSide(cafe)"
                                >
                                    <p class="font-medium text-gray-700 dark:text-gray-200">{{ cafe.name }}</p>
                                </div>
                            </TabsContent>
                        </Tabs>
                    </div>
                </div>

                <!-- Columna Áreas - Mejorada -->
                <div class="flex flex-col gap-4 rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        <span class="bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">Áreas</span>
                    </h2>
                    <div class="space-y-2 overflow-y-auto">
                        <div
                            v-for="area in areasSelected"
                            :key="area.id"
                            class="flex h-14 cursor-pointer items-center rounded-lg border border-gray-200 p-3 transition-all hover:bg-green-50 hover:shadow-md dark:border-gray-600 dark:hover:bg-green-900/20"
                            :class="{
                                'border-green-300 bg-green-100 dark:bg-green-900/40': selectedArea?.id === area.id,
                            }"
                            @click="selectArea(area)"
                        >
                            <p class="font-medium text-gray-700 dark:text-gray-200">{{ area.name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Columna Usuarios - Mejorada -->
                <div class="flex flex-col gap-4 rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        <span class="bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent">Usuarios</span>
                    </h2>
                    <div
                        v-if="showNoUsers"
                        class="flex h-14 items-center justify-center rounded-lg bg-red-100 p-3 text-red-600 dark:bg-red-900/30 dark:text-red-300"
                    >
                        <p>No se encontraron usuarios en esta área</p>
                    </div>
                    <div class="space-y-3 overflow-y-auto" v-else>
                        <div
                            v-for="user in usersSelected"
                            :key="user.id"
                            class="rounded-lg border border-gray-200 p-3 transition-all hover:shadow-md dark:border-gray-600"
                            :class="{
                                'border-indigo-300 bg-indigo-50 dark:bg-indigo-900/30': selectedUser?.id === user.id,
                            }"
                            @click="selectUser(user)"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ user.name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                                </div>
                                <span
                                    class="rounded-full px-2 py-1 text-xs font-medium"
                                    :class="{
                                        'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200': user.roles[0].name === 'Admin',
                                        'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200': user.roles[0].name === 'Manager',
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': user.roles[0].name === 'Employee',
                                        'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200': user.roles[0].name === 'Guest',
                                    }"
                                >
                                    {{ user.roles[0].name }}
                                </span>
                            </div>
                            <div class="mt-2 flex justify-end gap-1">
                                <Button class="bg-red-500" title="Dar de baja" @click="blockUser(user.id)"><Ban /></Button>
                                <Button @click="toBlacklist(user.id)" title="Pasar a lista negra"><Ban /></Button>
                                <RolePermissionPopover
                                    :role="user.roles[0]"
                                    :permissions="permissions"
                                    class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { Area, Cafe, Headquarter, Permission, Role, User } from '@/types';
import { Head, router } from '@inertiajs/vue3';
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
</script>
<template>
    <Head title="Usuarios" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Barra de acciones -->
            <div class="flex h-12 w-full items-center justify-start gap-3 rounded-lg bg-white p-2 shadow-sm">
                <PermissionModal class="rounded p-1 transition-colors hover:bg-gray-100" />
                <Modal :cafes="cafes" :headquarters="headquarters" :roles="roles" class="rounded p-1 transition-colors hover:bg-gray-100" />
                <RoleModal :areas="areas" class="rounded p-1 transition-colors hover:bg-gray-100" />
                <AreaModal :cafes="cafes" :headquarters="headquarters" class="rounded p-1 transition-colors hover:bg-gray-100" />
            </div>

            <!-- Contenedor principal de tres columnas -->
            <div class="grid h-full auto-rows-fr gap-6 md:grid-cols-3">
                <div class="flex flex-col gap-4 rounded-lg bg-white p-4 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800">Lugares</h2>
                    <Input
                        type="text"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Buscar lugar..."
                    />
                    <div class="space-y-2 overflow-y-auto">
                        <Tabs default-value="account" class="w-full">
                            <TabsList class="grid w-full grid-cols-2">
                                <TabsTrigger value="areas"> Areas </TabsTrigger>
                                <TabsTrigger value="cafes"> Cafeterías </TabsTrigger>
                            </TabsList>
                            <TabsContent value="areas">
                                <div
                                    v-for="headquarter in headquarters"
                                    :key="headquarter.id"
                                    class="flex h-14 cursor-pointer items-center rounded-lg border border-gray-200 p-3 transition-all hover:bg-indigo-50 hover:shadow-md"
                                    :class="{
                                        'border-indigo-300 bg-indigo-100': selectedSide?.id === headquarter.id,
                                    }"
                                    @click="selectSide(headquarter)"
                                >
                                    <p class="font-medium text-gray-700">{{ headquarter.name }}</p>
                                </div>
                            </TabsContent>
                            <TabsContent value="cafes">
                                <div
                                    v-for="cafe in cafes"
                                    :key="cafe.id"
                                    class="flex h-14 cursor-pointer items-center rounded-lg border border-gray-200 p-3 transition-all hover:bg-indigo-50 hover:shadow-md"
                                    :class="{
                                        'border-indigo-300 bg-indigo-100': selectedSide?.id === cafe.id,
                                    }"
                                    @click="selectSide(cafe)"
                                >
                                    <p class="font-medium text-gray-700">{{ cafe.name }}</p>
                                </div>
                            </TabsContent>
                        </Tabs>
                    </div>
                </div>

                <!-- Columna Áreas - Modificado -->
                <div class="flex flex-col gap-4 rounded-lg bg-white p-4 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800">Áreas</h2>
                    <div class="space-y-2 overflow-y-auto">
                        <div
                            v-for="area in areasSelected"
                            :key="area.id"
                            class="flex h-14 cursor-pointer items-center rounded-lg border border-gray-200 p-3 transition-all hover:bg-indigo-50 hover:shadow-md"
                            :class="{
                                'border-indigo-300 bg-indigo-100': selectedArea?.id === area.id,
                            }"
                            @click="selectArea(area)"
                        >
                            <p class="font-medium text-gray-700">{{ area.name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Columna Usuarios - Modificado -->
                <div class="flex flex-col gap-4 rounded-lg bg-white p-4 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800">Usuarios</h2>
                    <div v-if="showNoUsers" class="flex h-14 items-center justify-center rounded-lg bg-red-100 p-3 text-red-600">
                        <p>No se encontraron usuarios en esta área</p>
                    </div>
                    <div class="space-y-3 overflow-y-auto" v-else>
                        <div
                            v-for="user in usersSelected"
                            :key="user.id"
                            class="rounded-lg border border-gray-200 p-3 transition-all hover:shadow-md"
                            :class="{
                                'border-indigo-300 bg-indigo-50': selectedUser?.id === user.id,
                            }"
                            @click="selectUser(user)"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">{{ user.name }}</p>
                                    <p class="text-sm text-gray-500">{{ user.email }}</p>
                                </div>
                                <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-800">
                                    {{ user.roles[0].name }}
                                </span>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <RolePermissionPopover
                                    :role="user.roles[0]"
                                    :permissions="user.roles[0].permissions"
                                    class="text-xs text-indigo-600 hover:text-indigo-800"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

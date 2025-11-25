<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { Area, Cafe, Headquarter, Mine, Permission, Role, Unit, User } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, watch } from 'vue';
import AreaModal from './AreaModal.vue';
import GuardAreaDroppable from './GuardAreaDroppable.vue';
import GuardModal from './GuardModal.vue';
import Modal from './Modal.vue';
import PermissionModal from './PermissionModal.vue';
import RoleModal from './RoleModal.vue';
import StaffSelectables from './StaffSelectables.vue';

interface Props {
    users: User[];
    roles: Role[];
    permissions: Permission[];
    areas: Area[];
    headquarters: Headquarter[];
    mines: Mine[];
    units: Unit[];
}

const props = defineProps<Props>();

const areasSelected = ref([]);
const showNoUsers = ref(false);

const selectedOptions = ref({
    mine: null,
    unit: null,
    cafe: null,
});

const selectedUnits = ref([]);
const selectedCafes = ref([]);
const usersSelected = ref([]);
const guardsSelected = ref([] as Cafe[]);

const unassignedUsers = ref([]);
const assignedUsers = ref([]);

watch(
    selectedOptions,
    (newVal) => {
        // Cambió la mina
        if (newVal.mine !== null && newVal.mine !== undefined) {
            const mineSelected = props.mines.find((mine) => String(mine.id) === String(newVal.mine));
            selectedUnits.value = mineSelected ? mineSelected.units : [];
        }

        // Cambió la unidad
        if (newVal.unit) {
            const unitSelected = selectedUnits.value.find((unit) => unit.id == newVal.unit);
            selectedCafes.value = unitSelected ? unitSelected.cafes : [];
        }

        if (newVal.cafe) {
            const cafeSelected = selectedCafes.value.find((cafe) => cafe.id == newVal.cafe);
            if (cafeSelected) {
                unassignedUsers.value = cafeSelected.users;
                guardsSelected.value = cafeSelected.guards;

                axios.get('/assigned-users/' + cafeSelected.id).then((response) => {
                    console.log(response.data);
                });
            } else {
                areasSelected.value = [];
            }
            //usersSelected.value = [];
            showNoUsers.value = false;
        }
    },
    { deep: true },
);

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
        usersSelected.value = area.users.filter((user) => user.type != 3);
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
        router
            .get(route('users.ban', userId))
            .then(() => {
                console.log('Usuario dado de baja');
                // Aquí podrías agregar lógica adicional si es necesario
            })
            .catch((error) => {
                console.error('Error al dar de baja al usuario:', error);
                alert('Ocurrió un error al dar de baja al usuario. Por favor, inténtalo de nuevo.');
            });
    }
};

const toBlacklistRoute = () => {
    router.get(route('blacklist'));
};

const handleUserAssignment = (userId: number) => {
    unassignedUsers.value = unassignedUsers.value.filter((user) => user.id !== userId);
};

const selectCafe = (value: number | string) => {
    console.log('Valor seleccionado:', value);
    console.log('Cafe seleccionado');
};

const assignGuards = (guards: Cafe[]) => {
    console.log('updating guards', guards);
    guardsSelected.value = guards;
};

const asignRolesToGuard = (guardId: number, roles: Role[]) => {
    console.log(`Asignar roles al guardia ID ${guardId}:`, roles);
    const guard = guardsSelected.value.find((g) => g.id === guardId);

    if (guard) {
        guard.roles = roles;
    }
};

const deleteGuardRole = (guardId: number, roleId: number) => {
    const guard = guardsSelected.value.find((g) => g.id === guardId);

    if (guard) {
        guard.roles = guard.roles.filter((role) => role.id !== roleId);
    }
};
</script>
<template>
    <Head title="Headcount" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex">
                <h1 class="text-2xl font-bold">Puestos</h1>
            </div>
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
                <!-- <Button @click="toBlacklistRoute"><Ban /></Button> -->
            </div>
            <p>Seleccione una mina, unidad y comedor para asignar guardias y roles</p>
            <div class="flex gap-2">
                <Select class="w-full" v-model="selectedOptions.mine">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Selecciona una mina" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Minas</SelectLabel>
                            <SelectItem v-for="mine in props.mines" :value="String(mine.id)" :key="mine.id"> {{ mine.name }} </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select class="w-full" v-model="selectedOptions.unit">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Selecciona una unidad minera" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Unidades mineras</SelectLabel>
                            <SelectItem v-for="unit in selectedUnits" :value="unit.id" :key="unit.id"> {{ unit.name }} </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select class="w-full" v-model="selectedOptions.cafe">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Selecciona un comedor" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Comedores</SelectLabel>
                            <SelectItem v-for="cafe in selectedCafes" :value="cafe.id" :key="cafe.id"> {{ cafe.name }} </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <GuardModal :cafeId="selectedOptions.cafe" @assignGuards="assignGuards" />
                <Button class="h-full w-auto bg-green-500 text-white hover:bg-green-600"> Agregar roles </Button>
                <Button class="h-full w-auto bg-green-500 text-white hover:bg-green-600"> Agregar puesto </Button>
            </div>

            <!-- Contenedor principal de tres columnas -->

            <div class="h-full">
                <div v-if="guardsSelected && guardsSelected.length > 0" class="grid h-full auto-rows-fr gap-6 md:grid-cols-4">
                    <StaffSelectables :users="unassignedUsers" />
                    <GuardAreaDroppable
                        :users="assignedUsers"
                        :roles="roles"
                        :guard="guard"
                        @dropped="handleUserAssignment"
                        v-for="guard in guardsSelected"
                        :key="guard.id"
                        @asignRolesToGuard="asignRolesToGuard"
                        @deleteGuardRole="deleteGuardRole"
                    />
                </div>
                <div v-else class="flex h-full items-center justify-center p-10 text-center">
                    <p class="text-xl font-semibold text-gray-500">
                        ⚠️ Por favor, asigne guardias para continuar.
                        <br />
                        (La lista de guardias aparecerá aquí una vez se asignen).
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

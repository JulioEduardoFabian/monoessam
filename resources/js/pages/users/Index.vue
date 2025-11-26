<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { Area, Cafe, Headquarter, Mine, Permission, Role, Unit, User } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, watch } from 'vue';
import GuardAreaDroppable from './GuardAreaDroppable.vue';
import GuardModal from './GuardModal.vue';
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
            fetchCafeData(Number(newVal.cafe));

            /* const cafeSelected = selectedCafes.value.find((cafe) => cafe.id == newVal.cafe);
            if (cafeSelected) {
                const assignedUsers: any[] = [];
                unassignedUsers.value = cafeSelected.users;
                cafeSelected.guards.forEach((guard) => {
                    guard.assigned_roles.forEach((roleAssignment) => {
                        if (roleAssignment.user_id) {
                            unassignedUsers.value = unassignedUsers.value.filter((user) => user.id !== roleAssignment.user_id);
                        }
                    });
                });
                guardsSelected.value = cafeSelected.guards;
            } else {
                areasSelected.value = [];
            }
            //usersSelected.value = [];
            showNoUsers.value = false; */
        }
    },
    { deep: true },
);

const fetchCafeData = async (cafeId: number) => {
    try {
        const response = await axios.get(`/cafes/${cafeId}`);
        const cafeData = response.data;
        unassignedUsers.value = cafeData.users;
        guardsSelected.value = cafeData.guards;
        /* 
        guardsSelected.value.forEach((guard) => {
            guard.assigned_roles.forEach((roleAssignment) => {
                if (roleAssignment.user_id) {
                    unassignedUsers.value = unassignedUsers.value.filter((user) => user.id !== roleAssignment.user_id);
                }
            });
        }); */
    } catch (error) {
        console.error('Error fetching cafe data:', error);
    }
};

const handleUserAssignment = (userId: number) => {
    unassignedUsers.value = unassignedUsers.value.filter((user) => user.id !== userId);
};

const assignGuards = (guards: Cafe[]) => {
    console.log('updating guards', guards);
    guardsSelected.value = guards;
};

const asignRolesToGuard = (guardId: number, roles: Role[]) => {
    console.log(`Asignar roles al guardia ID ${guardId}:`, roles);
    const guard = guardsSelected.value.find((g) => g.id === guardId);
    if (guard) {
        roles.forEach((role) => {
            const newRole = {
                role: {
                    id: role.id,
                    guard_id: guardId,
                    role_id: role.id,
                    name: role.name,
                },
            };

            guard.assigned_roles.push(newRole);
        });
    }
    console.log(guard);
};

const deleteGuardRole = (guardId: number, roleId: number) => {
    const guard = guardsSelected.value.find((g) => g.id === guardId);
    console.log(roleId);
    if (guard) {
        guard.assigned_roles = guard.assigned_roles.filter((role) => role.id !== roleId);
    }
};

const unassignUser = (userId: number) => {
    const cafeSelected = selectedCafes.value.find((cafe) => cafe.id == selectedOptions.value.cafe);
    if (cafeSelected) {
        const user = props.users.find((u) => u.id === userId);
        if (user) {
            unassignedUsers.value.push(user);
        }
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
                        @unassignUser="unassignUser"
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

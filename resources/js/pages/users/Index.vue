<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { Area, Cafe, Headquarter, Mine, Permission, Role, Unit, User } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { List, Sheet } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import GuardAreaDroppable from './GuardAreaDroppable.vue';
import GuardModal from './GuardModal.vue';
import StaffSelectables from './StaffSelectables.vue';
import TableHeadcount from './TableHeadcount.vue';

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

const selectedOptions = ref({
    mine: null,
    unit: null,
    cafe: null,
});

const selectedUnits = ref([]);
const selectedCafes = ref([]);
const selectedPeriods = ref([]);
const guardsSelected = ref([] as Cafe[]);
const changedView = ref(false);

const unassignedUsers = ref([]);
const assignedUsers = ref([]);

watch(
    selectedOptions,
    (newVal) => {
        // Cambió la mina
        if (newVal.mine !== null && newVal.mine !== undefined) {
            const mineSelected: any = props.mines.find((mine) => String(mine.id) === String(newVal.mine));
            selectedUnits.value = mineSelected ? mineSelected.units : [];
        }

        // Cambió la unidad
        if (newVal.unit) {
            const unitSelected: any = selectedUnits.value.find((unit: Unit) => unit.id == newVal.unit);
            selectedCafes.value = unitSelected ? unitSelected.cafes : [];
        }

        if (newVal.cafe) {
            fetchCafeData(Number(newVal.cafe));
        }
    },
    { deep: true },
);

const fetchCafeData = async (cafeId: number) => {
    try {
        const response = await axios.get(`/cafes/${cafeId}`);
        const cafeData = response.data;
        guardsSelected.value = cafeData.guards;
        unassignedUsers.value = cafeData.users.unassigned;
        assignedUsers.value = cafeData.users.assigned;
        selectedPeriods.value = cafeData.periods;
        console.log(assignedUsers);
    } catch (error) {
        console.error('Error fetching cafe data:', error);
    }
};

const handleUserAssignment = (userId: number) => {
    unassignedUsers.value = unassignedUsers.value.filter((user: User) => user.id !== userId);
    //fetchCafeData(selectedOptions.value.cafe);
};

const assignGuards = (guards: Cafe[]) => {
    console.log('updating guards', guards);
    guardsSelected.value = guards;
};

const asignRolesToGuard = (guardId: number, roles: Role[]) => {
    const guard = guardsSelected.value.find((g) => g.id === guardId);
    if (guard) {
        guard.assigned_roles = [];
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
};

const deleteGuardRole = (guardId: number, roleId: number) => {
    const guard = guardsSelected.value.find((g) => g.id === guardId);
    console.log(roleId);
    if (guard) {
        guard.assigned_roles = guard.assigned_roles.filter((role) => role.id !== roleId);
    }
};

const deleteGuard = (guardId: number) => {
    guardsSelected.value = guardsSelected.value.filter((guard) => guard.id !== guardId);
};

const unassignUser = (userId: number) => {
    const cafeSelected = selectedCafes.value.find((cafe) => cafe.id == selectedOptions.value.cafe);
    if (cafeSelected) {
        const user = cafeSelected.staffs.find((u) => u.id === userId);
        if (user) {
            unassignedUsers.value.unshift(user);
        }
    }
};

const changeView = () => {
    changedView.value = !changedView.value;
};

const exportToExcel = () => {
    const cafeId = selectedOptions.value.cafe;
    if (!cafeId) {
        alert('Por favor seleccione un comedor antes de exportar.');
        return;
    }

    window.location.href = `/cafes/${cafeId}/export-headcount`;
};
</script>
<template>
    <Head title="Headcount" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex">
                <h1 class="text-2xl font-bold">Puestos</h1>
            </div>

            <div class="flex w-full flex-row gap-2">
                <Button title="Ver en lista" class="cursor-pointer" @click="changeView()"><List></List></Button>
                <Button class="cursor-pointer bg-green-500" title="Exportar Headcount en Excel" @click="exportToExcel()"><Sheet /> </Button>
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
                <!-- <Button class="h-full w-auto bg-green-500 text-white hover:bg-green-600"> Agregar roles </Button>
                <Button class="h-full w-auto bg-green-500 text-white hover:bg-green-600"> Agregar puesto </Button> -->
            </div>

            <!-- Contenedor principal de tres columnas -->

            <div class="h-full" :hidden="changedView">
                <div v-if="guardsSelected && guardsSelected.length > 0" class="grid h-full auto-rows-fr gap-6 md:grid-cols-8">
                    <StaffSelectables :users="unassignedUsers" class="md:col-span-2" />
                    <div class="md:col-span-6">
                        <div class="overflow-x-auto" v-for="guard in guardsSelected" :key="guard.id">
                            <div class="flex h-full gap-6">
                                <GuardAreaDroppable
                                    :users="assignedUsers"
                                    :roles="roles"
                                    :guard="guard"
                                    @dropped="handleUserAssignment"
                                    @asignRolesToGuard="asignRolesToGuard"
                                    @deleteGuardRole="deleteGuardRole"
                                    @deleteGuard="deleteGuard"
                                    @unassignUser="unassignUser"
                                    :unassignedUsers="unassignedUsers"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="flex h-full items-center justify-center p-10 text-center">
                    <p class="text-xl font-semibold text-gray-500">
                        ⚠️ Por favor seleccione un comedor y asigne guardias para continuar.
                        <br />
                        (La lista de guardias aparecerá aquí una vez se asignen).
                    </p>
                </div>
            </div>
            <div class="h-full" :hidden="!changedView">
                <div class="grid h-full">
                    <TableHeadcount
                        :guards="guardsSelected"
                        :users="assignedUsers"
                        :cafeId="selectedOptions.cafe"
                        :periods="selectedPeriods"
                        @fetchCafeData="fetchCafeData"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

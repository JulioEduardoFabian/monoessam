<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Cafe, Headquarter } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

// --- Tipos de Datos ---
interface Role {
    id: number;
    name: string;
}

// Nota: La simulación de datos local 'availableRoles' ya no es necesaria,
// pues estás usando 'props.roles'.

const props = defineProps({
    cafes: {
        type: Array as () => Cafe[],
        required: true,
    },
    headquarters: {
        type: Array as () => Headquarter[],
        required: true,
    },
    guard: {
        type: Object,
        required: true,
    },
    roles: {
        type: Array as () => Role[],
        default: () => [], // Asegurar valor por defecto para evitar errores
    },
});

const open = ref(false);
const searchTerm = ref('');
const selectedRoles = ref<Role[]>([]);
const isDropdownVisible = ref(false); // Controla si el menú está abierto

const form = useForm({
    guard_id: 0,
    roles_ids: [] as number[],
});

// Lógica de filtrado de roles disponibles
const filteredRoles = computed(() => {
    const selectedIds = selectedRoles.value.map((role) => role.id);

    // 1. Iniciar con todos los roles que NO han sido seleccionados.
    // Usamos el spread (...) para asegurar que trabajamos con una copia mutable.
    let filtered = [...props.roles].filter((role) => !selectedIds.includes(role.id));

    // 2. Aplicar el filtro de texto si existe un término de búsqueda.
    if (searchTerm.value) {
        const lowerCaseSearchTerm = searchTerm.value.toLowerCase();

        filtered = filtered.filter((role) => role.name.toLowerCase().includes(lowerCaseSearchTerm));
    }

    // 3. Limitar el número de resultados (opcional, pero buena práctica)
    return filtered.slice(0, 7);
});

// Watcher para asegurar que el desplegable se abra automáticamente al escribir
watch(searchTerm, (newVal) => {
    if (newVal.length > 0 && !isDropdownVisible.value) {
        isDropdownVisible.value = true;
    }
    // Si el campo se vacía, ocultamos el desplegable (si no hay foco)
    if (newVal.length === 0 && !searchInputRef.value?.$el.contains(document.activeElement as Node)) {
        isDropdownVisible.value = false;
    }
});

// Función para agregar un rol a la lista de seleccionados
const addRole = (role: Role) => {
    if (!selectedRoles.value.some((r) => r.id === role.id)) {
        selectedRoles.value.push(role);
        searchTerm.value = '';
        // Ocultamos el desplegable al seleccionar un rol
        isDropdownVisible.value = false;
    }
};

// Función para remover un rol
const removeRole = (roleId: number) => {
    selectedRoles.value = selectedRoles.value.filter((role) => role.id !== roleId);
};

const submit = () => {
    form.roles_ids = selectedRoles.value.map((role) => role.id);

    form.guard_id = props.guard.id;

    if (form.roles_ids.length === 0) {
        alert('Por favor, selecciona al menos un rol antes de agregar.');
        return;
    }

    form.post(route('insert-guard-roles'), {
        onSuccess: () => {
            open.value = false;
            form.reset();
            selectedRoles.value = [];
        },
    });
};

// --- Lógica para controlar la visibilidad del desplegable ---

const searchInputRef = ref<InstanceType<typeof Input> | null>(null);
const resultsContainerRef = ref<HTMLElement | null>(null);

// Función para cerrar el desplegable si se hace clic fuera
const closeDropdown = (event: MouseEvent) => {
    if (
        searchInputRef.value?.$el &&
        !searchInputRef.value.$el.contains(event.target as Node) &&
        resultsContainerRef.value &&
        !resultsContainerRef.value.contains(event.target as Node)
    ) {
        isDropdownVisible.value = false;
    }
};

// Función para mostrar el desplegable cuando el input recibe un click
const openDropdown = () => {
    isDropdownVisible.value = true;
};

// Agregar un listener global para manejar el clic fuera del diálogo
watch(open, (isOpen) => {
    if (isOpen) {
        isDropdownVisible.value = false;
        document.addEventListener('click', closeDropdown);
    } else {
        document.removeEventListener('click', closeDropdown);
        isDropdownVisible.value = false;
        searchTerm.value = '';
    }
});
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <Button title="Agregar Area" class="h-full w-auto bg-green-500 text-white hover:bg-green-400"> Agregar roles </Button>
        </DialogTrigger>
        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle>Asignar roles a la guardia</DialogTitle>
            </DialogHeader>

            <div class="space-y-4">
                <div class="relative">
                    <Input
                        ref="searchInputRef"
                        placeholder="Busca y selecciona un rol (ej: Líder)"
                        v-model="searchTerm"
                        class="w-full"
                        @click="openDropdown"
                        @keydown.esc="isDropdownVisible = false"
                        autocomplete="off"
                    />

                    <div
                        v-if="isDropdownVisible && filteredRoles.length > 0"
                        ref="resultsContainerRef"
                        class="absolute z-10 mt-1 max-h-40 w-full overflow-y-auto rounded-md border bg-white shadow-lg"
                    >
                        <div
                            v-for="role in filteredRoles"
                            :key="role.id"
                            @click="addRole(role)"
                            class="cursor-pointer p-2 text-sm transition-colors hover:bg-gray-100"
                            tabindex="0"
                            @keydown.enter="addRole(role)"
                        >
                            {{ role.name }}
                        </div>
                    </div>
                    <div
                        v-else-if="isDropdownVisible"
                        class="absolute z-10 mt-1 w-full rounded-md border bg-white p-2 text-sm text-gray-500 shadow-lg"
                    >
                        {{ searchTerm ? 'No se encontraron roles.' : 'No hay más roles disponibles para seleccionar.' }}
                    </div>
                </div>

                <div class="min-h-[50px] rounded-md border bg-gray-50 p-3">
                    <p v-if="selectedRoles.length === 0" class="text-sm text-gray-500">Roles seleccionados aparecerán aquí.</p>
                    <div class="flex flex-wrap gap-2">
                        <Badge
                            v-for="role in selectedRoles"
                            :key="role.id"
                            variant="secondary"
                            class="cursor-pointer bg-green-100 text-green-800 hover:bg-green-200"
                            @click="removeRole(role.id)"
                        >
                            {{ role.name }}
                            <span class="ml-1 text-xs font-bold" title="Remover rol">×</span>
                        </Badge>
                    </div>
                </div>
            </div>

            <DialogFooter>
                <Button
                    type="submit"
                    @click="submit"
                    :disabled="form.processing || selectedRoles.length === 0"
                    class="bg-green-500 text-white hover:bg-green-600"
                >
                    {{ form.processing ? 'Agregando...' : 'Agregar Roles' }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

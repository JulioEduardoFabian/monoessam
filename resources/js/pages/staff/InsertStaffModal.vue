<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormUser from '../users/FormUser.vue';

interface ServiceType {
    value: string;
    label: string;
}

interface Service {
    id?: number;
    code: string;
    name: string;
    description: string;
    type: string;
}

const props = defineProps({
    editingService: {
        type: Object as () => Service | null,
        default: null,
    },
    serviceTypes: {
        type: Array as () => ServiceType[],
        required: true,
    },
});

const emit = defineEmits(['save', 'update:open']);

const open = ref(false);

const form = useForm({
    code: '',
    name: '',
    description: '',
    type: '',
});

/* watch(
    () => props.editingService,
    (service) => {
        if (service) {
            setValues({
                code: service.code,
                name: service.name,
                description: service.description,
                type: service.type,
            });
        } else {
            resetForm();
        }
    },
    { immediate: true },
); */

const saveService = () => {
    form.post(route('services.insert'), {
        onSuccess: () => {
            emit('fetchServices');
            form.reset();
        },
    });
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button class="cursor-pointer bg-blue-400 hover:bg-blue-500"> Agregar personal </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[1000px]">
            <DialogHeader>
                <DialogTitle>
                    {{ editingService ? 'Editar Servicio' : 'Nuevo Servicio' }}
                </DialogTitle>
            </DialogHeader>

            <FormUser />

            <DialogFooter>
                <Button variant="outline" @click="open = false"> Cancelar </Button>
                <Button type="submit" @click="saveService"> Guardar </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

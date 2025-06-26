<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { useForm } from '@inertiajs/vue3';
import { DollarSign } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        required: true,
    },
    showOtherUnitDialog: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(['doublePriceSave']);

const open = ref(false);

const servicesCopy = ref([]);

watch(props, (newVal) => {
    open.value = newVal.showOtherUnitDialog;
    console.log(newVal);
});

const form = useForm({
    services: [],
});

const submit = () => {
    emits('doublePriceSave');
};

const closeDialog = () => {
    open.value = false;
    form.reset();
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <Button title="Agregar comensales" class="bg-dark"><DollarSign /></Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle
                    >Este comensal no pertenece a esta cafetería, se le podrá dar el crédito por el doble del monto total de su pedido.</DialogTitle
                >
            </DialogHeader>
            <DialogFooter>
                <Button @click="submit">Aceptar</Button>
                <Button @click="closeDialog">Cancelar</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

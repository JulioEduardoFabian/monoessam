<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';

const props = defineProps({
    showOtherUnitDialog: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(['doublePriceSave', 'hideDialog']);

const submit = () => {
    emits('doublePriceSave');
    closeDialog();
};

const closeDialog = () => {
    emits('hideDialog');
    form.reset();
};
</script>

<template>
    <Dialog :open="showOtherUnitDialog" @update:open="(val) => emits('update:showOtherUnitDialog', val)">
        <DialogContent aria-describedby="dialog-description">
            <DialogHeader>
                <DialogTitle id="dialog-description">
                    Este comensal no pertenece a esta cafetería, se le podrá dar el crédito por el doble del monto total de su pedido.
                </DialogTitle>
            </DialogHeader>
            <DialogFooter>
                <Button @click="submit">Aceptar</Button>
                <Button variant="outline" @click="closeDialog">Cancelar</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
